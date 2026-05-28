<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Claim;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\ClaimStatusMail;
class ClaimController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | ROLE HELPER
    |--------------------------------------------------------------------------
    | FOUND POST  → Finder = post creator ($item->user), Owner = claimant ($claim->user)
    | LOST POST   → Owner  = post creator ($item->user), Finder = claimant ($claim->user)
    |--------------------------------------------------------------------------
    */
    private function resolveRoles(Item $item, Claim $claim): array
    {
        if ($item->type === 'found') {
            return [
                'finder_user' => $item->user,
                'owner_user'  => $claim->user,
            ];
        }

        return [
            'finder_user' => $claim->user,
            'owner_user'  => $item->user,
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | SCENARIO A — FOUND POST
    | Amin jumpa barang → post Found Item
    | Azri nak claim → jawab security question → pilih method → proceed
    |--------------------------------------------------------------------------
    */

    public function showClaimForm($id)
    {
        $item = Item::findOrFail($id);

        if ($item->type !== 'found') {
            return back()->with('error', 'This item cannot be claimed here.');
        }
        if ($item->user_id === auth()->id()) {
            return back()->with('error', 'You cannot claim your own post.');
        }
        if ($item->status !== 'active') {
            return back()->with('error', 'This item is no longer available for claiming.');
        }
        if (Claim::where('item_id', $id)->where('user_id', auth()->id())->exists()) {
            return back()->with('error', 'You have already submitted a claim for this item.');
        }

        return view('auth.claim', compact('item'));
    }

    public function checkSecurityAnswer(Request $request, $id)
    {
        $item = Item::findOrFail($id);

        if (password_verify($request->answer, $item->security_answer)) {
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false, 'message' => 'Incorrect answer. Please try again.']);
    }

    /**
     * Azri jawab security question betul → claim terus APPROVED
     * Delivery  → redirect ke payment page
     * Pickup    → email Amin untuk set appointment, redirect ke items
     */
    public function submitClaim(Request $request, $id)
    {
        $item = Item::with('user')->findOrFail($id);

        $request->validate([
            'answer'          => 'required|string',
            'delivery_method' => 'required|in:self_pickup,delivery',
        ]);

        // Security question must be correct
        if (!password_verify($request->answer, $item->security_answer)) {
            return back()->withErrors(['answer' => 'Incorrect answer. Please try again.'])->withInput();
        }

        // Create claim — auto approved (security Q is the verification)
        $claim = Claim::create([
            'item_id'         => $item->id,
            'user_id'         => auth()->id(),
            'answer'          => $request->answer,
            'delivery_method' => $request->delivery_method,
            'status'          => 'approved',
        ]);

        if ($request->delivery_method === 'delivery') {
            // Update item status → awaiting payment
            $item->update(['status' => 'awaiting_payment']);

            // Redirect Azri to payment page
            return redirect()->route('claim.payment', $claim->id);
        }

        // Self-pickup → email Amin to set appointment
        $item->update(['status' => 'awaiting_appointment']);

        try {
            $finderName  = $item->user->name;
            $finderEmail = $item->user->email;
            $ownerName   = auth()->user()->name;
            $itemTitle   = $item->title;

            Mail::send([], [], function ($msg) use ($finderEmail, $finderName, $ownerName, $itemTitle, $item) {
                $msg->to($finderEmail)
                    ->subject('[UTM FoundIt] Action Required: Set Pickup Appointment for ' . $itemTitle)
                    ->html("
                        <div style='font-family:Arial,sans-serif;padding:25px;color:#333;max-width:600px;border:1px solid #e5e7eb;border-radius:16px;'>
                            <h2 style='color:#800000;'>Hello, {$finderName}!</h2>
                            <p>Good news! <strong>{$ownerName}</strong> has successfully verified ownership and claimed your found item: <strong>{$itemTitle}</strong>.</p>
                            <p>They chose <strong>Self Pickup</strong>. Please log in and set an appointment date, time, and location so they can collect it.</p>
                            <p>
                                <a href='" . url('/items') . "' style='background:#800000;color:#fff;padding:12px 24px;text-decoration:none;border-radius:8px;font-weight:bold;display:inline-block;'>
                                    Set Appointment Now
                                </a>
                            </p>
                            <p style='color:#999;font-size:12px;margin-top:20px;'>Automated email — do not reply.</p>
                        </div>
                    ");
            });
        } catch (\Exception $e) {
            \Log::error('submitClaim pickup email to Finder failed: ' . $e->getMessage());
        }

        return redirect('/items')->with('status', 'Claim successful! The finder has been notified to set a pickup appointment.');
    }

    /*
    |--------------------------------------------------------------------------
    | PAYMENT PAGE — Scenario A Delivery
    | Azri uploads receipt → email Amin
    |--------------------------------------------------------------------------
    */

    public function showPayment($claimId)
    {
        $claim = Claim::with(['item.user', 'user'])->findOrFail($claimId);

        // Only the owner (Azri) may view this
        if (auth()->id() !== $claim->user_id) {
            return redirect('/items')->with('error', 'Unauthorised access.');
        }

        if ($claim->delivery_method !== 'delivery') {
            return redirect('/items')->with('error', 'This claim does not require payment.');
        }

        return view('auth.payment', compact('claim'));
    }

    public function uploadReceipt(Request $request, $claimId)
    {
        $request->validate([
            'shipping_address'      => 'required|string',
            'payment_receipt_image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $claim = Claim::with(['item.user', 'user'])->findOrFail($claimId);
        $item  = $claim->item;

        ['owner_user' => $ownerUser, 'finder_user' => $finderUser] = $this->resolveRoles($item, $claim);

        // Only Owner (Azri) may upload
        if (auth()->id() !== $ownerUser->id) {
            return back()->with('error', 'Only the item owner can submit payment.');
        }

        $path = $request->file('payment_receipt_image')->store('receipts', 'public');

        $claim->update([
            'payment_receipt'  => $path,
            'shipping_address' => $request->shipping_address,
        ]);

        // Now Amin needs to ship → status: claimed
        $item->update(['status' => 'claimed']);

        // Email Amin: receipt received, please ship
        try {
            $absPath     = storage_path('app/public/' . $path);
            $finderEmail = $finderUser->email;
            $finderName  = $finderUser->name;
            $ownerName   = $ownerUser->name;
            $itemTitle   = $item->title;
            $address     = $request->shipping_address;

            Mail::send([], [], function ($msg) use ($finderEmail, $finderName, $ownerName, $itemTitle, $address, $absPath) {
                $msg->to($finderEmail)
                    ->subject('[UTM FoundIt] Payment Received — Please Ship ' . $itemTitle)
                    ->html("
                        <div style='font-family:Arial,sans-serif;padding:25px;color:#333;max-width:600px;border:1px solid #e5e7eb;border-radius:16px;'>
                            <h2 style='color:#800000;'>Hello, {$finderName}!</h2>
                            <p><strong>{$ownerName}</strong> has uploaded the RM10 postage payment receipt for <strong>{$itemTitle}</strong>.</p>
                            <div style='background:#f0fdf4;border:1px solid #bbf7d0;border-radius:12px;padding:15px;margin:20px 0;'>
                                <p style='margin:0 0 6px;font-weight:bold;color:#166534;'>Ship to this address:</p>
                                <p style='margin:0;font-size:14px;'>{$address}</p>
                            </div>
                            <p>Please ship the item, then log in and click <strong>Mark as Returned / Shipped</strong>.</p>
                            <p>
                                <a href='" . url('/items') . "' style='background:#800000;color:#fff;padding:12px 24px;text-decoration:none;border-radius:8px;font-weight:bold;display:inline-block;'>
                                    Go to Items
                                </a>
                            </p>
                            <p style='color:#999;font-size:12px;margin-top:20px;'>Automated email — do not reply.</p>
                        </div>
                    ");

                if (file_exists($absPath)) {
                    $msg->attach($absPath, [
                        'as'   => 'receipt.' . pathinfo($absPath, PATHINFO_EXTENSION),
                        'mime' => mime_content_type($absPath),
                    ]);
                }
            });
        } catch (\Exception $e) {
            \Log::error('uploadReceipt email to Finder failed: ' . $e->getMessage());
        }

        return redirect('/items')->with('status', 'Payment submitted! The finder has been notified to ship your item.');
    }

    /*
    |--------------------------------------------------------------------------
    | APPOINTMENT — Amin sets date, time, location (Pickup only)
    | Triggered from items.blade when status = awaiting_appointment
    |--------------------------------------------------------------------------
    */

    public function storeAppointment(Request $request, $itemId)
    {
        $request->validate([
            'appointment_date'     => 'required|date|after:now',
            'appointment_location' => 'required|string|max:255',
        ]);

        $item = Item::findOrFail($itemId);

        $claim = Claim::where('item_id', $item->id)
                      ->where('status', 'approved')
                      ->latest()
                      ->firstOrFail();

        ['finder_user' => $finderUser, 'owner_user' => $ownerUser] = $this->resolveRoles($item, $claim);

        // Only Finder (Amin) sets appointment
        if (auth()->id() !== $finderUser->id) {
            return back()->with('error', 'Only the finder can set the appointment.');
        }

        $claim->update([
            'appointment_date'     => $request->appointment_date,
            'appointment_location' => $request->appointment_location,
        ]);

        $item->update(['status' => 'claimed']);

        // Email Azri: appointment confirmed, please show up
        try {
            $appDate    = \Carbon\Carbon::parse($request->appointment_date)->format('d M Y, h:i A');
            $appLoc     = $request->appointment_location;
            $ownerEmail = $ownerUser->email;
            $ownerName  = $ownerUser->name;
            $itemTitle  = $item->title;

            Mail::send([], [], function ($msg) use ($ownerEmail, $ownerName, $itemTitle, $appDate, $appLoc) {
                $msg->to($ownerEmail)
                    ->subject('[UTM FoundIt] Pickup Appointment Set for: ' . $itemTitle)
                    ->html("
                        <div style='font-family:Arial,sans-serif;padding:25px;color:#333;max-width:600px;border:1px solid #e5e7eb;border-radius:16px;'>
                            <h2 style='color:#15803d;'>Hello, {$ownerName}!</h2>
                            <p>Your pickup appointment for <strong>{$itemTitle}</strong> has been confirmed.</p>
                            <div style='background:#f0fdf4;border:1px solid #bbf7d0;border-radius:12px;padding:15px;margin:20px 0;'>
                                <p style='margin:0 0 8px;font-weight:bold;color:#166534;'>Appointment Details:</p>
                                <p style='margin:4px 0;'>📅 <strong>Date & Time:</strong> {$appDate}</p>
                                <p style='margin:4px 0;'>📍 <strong>Location:</strong> {$appLoc}</p>
                            </div>
                            <p>Please be on time. After collecting your item, log in and click <strong>Item Received</strong> to close the case.</p>
                            <p style='color:#999;font-size:12px;margin-top:20px;'>Automated email — do not reply.</p>
                        </div>
                    ");
            });
        } catch (\Exception $e) {
            \Log::error('storeAppointment email to Owner failed: ' . $e->getMessage());
        }

        return back()->with('status', 'Appointment set! ' . $ownerUser->name . ' has been notified.');
    }

    /*
    |--------------------------------------------------------------------------
    | TWO-STEP HANDOVER
    | Step 1 — Amin: Mark as Returned  → status: returned_by_finder
    | Step 2 — Azri: Item Received     → status: returned (Case Closed)
    |--------------------------------------------------------------------------
    */

    public function markReturnedByFinder($itemId)
    {
        $item  = Item::findOrFail($itemId);
        $claim = Claim::where('item_id', $item->id)
                      ->where('status', 'approved')
                      ->latest()
                      ->firstOrFail();

        ['finder_user' => $finderUser, 'owner_user' => $ownerUser] = $this->resolveRoles($item, $claim);

        if (auth()->id() !== $finderUser->id) {
            return back()->with('error', 'Only the finder can mark this step.');
        }

        if ($item->status !== 'claimed') {
            return back()->with('error', 'Item is not in the correct state for this action.');
        }

        $item->update(['status' => 'returned_by_finder']);

        // Email Azri: item handed over / shipped, please confirm receipt
        try {
            Mail::send([], [], function ($msg) use ($ownerUser, $item) {
                $msg->to($ownerUser->email)
                    ->subject('[UTM FoundIt] Your Item Has Been Handed Over — Please Confirm: ' . $item->title)
                    ->html("
                        <div style='font-family:Arial,sans-serif;padding:25px;color:#333;max-width:600px;border:1px solid #e5e7eb;border-radius:16px;'>
                            <h2 style='color:#800000;'>Hello, {$ownerUser->name}!</h2>
                            <p>The finder has marked <strong>{$item->title}</strong> as handed over / shipped.</p>
                            <p>Once you have physically received the item, please log in and click <strong>Item Received</strong> to officially close the case.</p>
                            <p>
                                <a href='" . url('/items') . "' style='background:#800000;color:#fff;padding:12px 24px;text-decoration:none;border-radius:8px;font-weight:bold;display:inline-block;'>
                                    Confirm Receipt
                                </a>
                            </p>
                            <p style='color:#999;font-size:12px;margin-top:20px;'>Automated email — do not reply.</p>
                        </div>
                    ");
            });
        } catch (\Exception $e) {
            \Log::error('markReturnedByFinder email failed: ' . $e->getMessage());
        }

        return back()->with('status', 'Item marked as handed over! Waiting for ' . $ownerUser->name . ' to confirm receipt.');
    }

    public function confirmItemReceived($itemId)
    {
        $item  = Item::findOrFail($itemId);
        $claim = Claim::where('item_id', $item->id)
                      ->where('status', 'approved')
                      ->latest()
                      ->firstOrFail();

        ['finder_user' => $finderUser, 'owner_user' => $ownerUser] = $this->resolveRoles($item, $claim);

        if (auth()->id() !== $ownerUser->id) {
            return back()->with('error', 'Only the item owner can confirm receipt.');
        }

        if ($item->status !== 'returned_by_finder') {
            return back()->with('error', 'Item has not been marked as handed over yet.');
        }

        $item->update(['status' => 'returned']);
        $claim->update(['status' => 'closed']);

        // Email Amin: case closed, thank you
        try {
            Mail::send([], [], function ($msg) use ($finderUser, $ownerUser, $item) {
                $msg->to($finderUser->email)
                    ->subject('[UTM FoundIt] Case Closed — Thank You! ' . $item->title)
                    ->html("
                        <div style='font-family:Arial,sans-serif;padding:25px;color:#333;max-width:600px;border:1px solid #e5e7eb;border-radius:16px;'>
                            <h2 style='color:#15803d;'>Hello, {$finderUser->name}!</h2>
                            <p><strong>{$ownerUser->name}</strong> has confirmed receipt of <strong>{$item->title}</strong>.</p>
                            <p>The case is now officially closed. Thank you for your honesty and for making UTM a better place! 🎉</p>
                            <p style='color:#999;font-size:12px;margin-top:20px;'>Automated email — do not reply.</p>
                        </div>
                    ");
            });
        } catch (\Exception $e) {
            \Log::error('confirmItemReceived email failed: ' . $e->getMessage());
        }

        return back()->with('status', 'Case closed! Thank you for using UTM FoundIt. 🎉');
    }

    /*
    |--------------------------------------------------------------------------
    | SCENARIO B — LOST POST (Owner-Finder) — untuk later
    |--------------------------------------------------------------------------
    */

    public function showFoundThisForm($id)
    {
        $item = Item::findOrFail($id);

        if ($item->type !== 'lost') {
            return back()->with('error', 'This action is only available on lost item posts.');
        }
        if ($item->user_id === auth()->id()) {
            return back()->with('error', 'You cannot report finding your own item.');
        }
        if ($item->status !== 'active') {
            return back()->with('error', 'This item is no longer available.');
        }

        return view('auth.found-this', compact('item'));
    }

    public function submitFoundThis(Request $request, $id)
    {
        $request->validate([
            'message'        => 'required|string|max:500',
            'contact'        => 'required|string|max:255',
            'proof_image'    => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'bank_name'      => 'nullable|string|max:100',
            'account_number' => 'nullable|string|max:50',
        ]);

        $item = Item::with('user')->findOrFail($id);

        $imagePath = $request->file('proof_image')->store('proofs', 'public');

        $claim = Claim::create([
            'item_id'        => $item->id,
            'user_id'        => auth()->id(),
            'message'        => $request->message,
            'contact'        => $request->contact,
            'proof_image'    => $imagePath,
            'status'         => 'pending',
            'bank_name'      => $request->bank_name,
            'account_number' => $request->account_number,
        ]);

        // Email Owner with proof
        try {
            $ownerEmail    = $item->user->email;
            $ownerName     = $item->user->name;
            $finderName    = auth()->user()->name;
            $finderContact = $request->contact;
            $itemTitle     = $item->title;
            $finderMsg     = $request->message;
            $absPath       = storage_path('app/public/' . $imagePath);

            Mail::send([], [], function ($message) use ($ownerEmail, $ownerName, $finderName, $finderContact, $itemTitle, $finderMsg, $absPath) {
                $message->to($ownerEmail)
                    ->subject('[UTM FoundIt] Someone Found Your Lost Item: ' . $itemTitle)
                    ->html("
                        <div style='font-family:Arial,sans-serif;padding:25px;color:#333;max-width:600px;border:1px solid #e5e7eb;border-radius:16px;'>
                            <h2 style='color:#800000;'>Hello, {$ownerName}!</h2>
                            <p><strong>{$finderName}</strong> reported they found your lost item: <strong>{$itemTitle}</strong>.</p>
                            <blockquote style='background:#fcf6f6;border-left:4px solid #800000;padding:12px;border-radius:8px;font-style:italic;color:#555;'>
                                \"{$finderMsg}\"
                            </blockquote>
                            <p><strong>Finder's Contact:</strong> {$finderContact}</p>
                            <p>The proof image is attached. Log in to review and approve the claim.</p>
                            <p>
                                <a href='" . url('/items') . "' style='background:#800000;color:#fff;padding:12px 24px;text-decoration:none;border-radius:8px;font-weight:bold;display:inline-block;'>
                                    Review on UTM FoundIt
                                </a>
                            </p>
                            <p style='color:#999;font-size:12px;margin-top:20px;'>Automated email — do not reply.</p>
                        </div>
                    ");

                if (file_exists($absPath)) {
                    $message->attach($absPath, [
                        'as'   => 'proof.' . pathinfo($absPath, PATHINFO_EXTENSION),
                        'mime' => mime_content_type($absPath),
                    ]);
                }
            });
        } catch (\Exception $e) {
            \Log::error('submitFoundThis email failed: ' . $e->getMessage());
        }

        return redirect('/items')->with('status', 'Notification sent! The owner has been emailed with your proof.');
    }

    public function approveClaim(Request $request, $claimId)
    {
        $claim = Claim::with(['item.user', 'user'])->findOrFail($claimId);
        $item  = $claim->item;

        if ($item->user_id !== auth()->id()) {
            return back()->with('error', 'Unauthorised action.');
        }

        $method = $request->input('handover_method');

        if (!in_array($method, ['pickup', 'delivery'])) {
            return back()->with('error', 'Please select a handover method before approving.');
        }

        $claim->update(['status' => 'approved']);

        ['finder_user' => $finderUser, 'owner_user' => $ownerUser] = $this->resolveRoles($item, $claim);

        if ($method === 'delivery') {
            $item->update(['status' => 'awaiting_payment']);

            try {
                Mail::to($ownerUser->email)->send(new ClaimStatusMail($claim, 'approved'));
            } catch (\Exception $e) {}

            return back()->with('status', 'Claim approved! Owner notified to complete the RM10 postage payment.');
        }

        $item->update(['status' => 'awaiting_appointment']);

        try {
            $finderEmail = $finderUser->email;
            $finderName  = $finderUser->name;
            $ownerName   = $ownerUser->name;
            $itemTitle   = $item->title;

            Mail::send([], [], function ($msg) use ($finderEmail, $finderName, $ownerName, $itemTitle) {
                $msg->to($finderEmail)
                    ->subject('[UTM FoundIt] Set Pickup Appointment for: ' . $itemTitle)
                    ->html("
                        <div style='font-family:Arial,sans-serif;padding:25px;color:#333;max-width:600px;border:1px solid #e5e7eb;border-radius:16px;'>
                            <h2 style='color:#800000;'>Hello, {$finderName}!</h2>
                            <p>The claim for <strong>{$itemTitle}</strong> by <strong>{$ownerName}</strong> has been approved via self-pickup.</p>
                            <p>Please log in and set the appointment date, time, and location.</p>
                            <p>
                                <a href='" . url('/items') . "' style='background:#800000;color:#fff;padding:12px 24px;text-decoration:none;border-radius:8px;font-weight:bold;display:inline-block;'>
                                    Set Appointment
                                </a>
                            </p>
                            <p style='color:#999;font-size:12px;margin-top:20px;'>Automated email — do not reply.</p>
                        </div>
                    ");
            });
        } catch (\Exception $e) {
            \Log::error('approveClaim pickup email failed: ' . $e->getMessage());
        }

        return back()->with('status', 'Claim approved! Finder notified to set the pickup appointment.');
    }

    public function rejectClaim($claimId)
    {
        $claim = Claim::with(['item', 'user'])->findOrFail($claimId);

        if ($claim->item->user_id !== auth()->id()) {
            return back()->with('error', 'Unauthorised action.');
        }

        $claim->update(['status' => 'rejected']);
        $claim->item->update(['status' => 'active']);

        try {
            Mail::to($claim->user->email)->send(new ClaimStatusMail($claim, 'rejected'));
        } catch (\Exception $e) {}

        return back()->with('status', 'Claim rejected. The item is now active again.');
    }

    /*
    |--------------------------------------------------------------------------
    | DASHBOARDS
    |--------------------------------------------------------------------------
    */

    public function finderClaims()
    {
        $items = Item::where('user_id', auth()->id())
                     ->with(['claims.user'])
                     ->orderBy('created_at', 'desc')
                     ->get();

        return view('auth.finder-claims', compact('items'));
    }

    public function myClaims()
    {
        $claims = Claim::with('item')
                       ->where('user_id', auth()->id())
                       ->orderBy('created_at', 'desc')
                       ->get();

        return view('auth.my-claims', compact('claims'));
    }
}