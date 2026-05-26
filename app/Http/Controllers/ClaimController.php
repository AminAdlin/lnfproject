<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Claim;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\ClaimNotificationMail;
use App\Mail\ClaimStatusMail;
use App\Mail\PaymentReceiptMail;

class ClaimController extends Controller
{
    // Show claim form
    public function showClaimForm($id)
    {
        $item = Item::findOrFail($id);

        if ($item->type !== 'found') {
            return back()->with('error', 'This item cannot be claimed.');
        }

        if ($item->user_id === auth()->id()) {
            return back()->with('error', 'You cannot claim your own post.');
        }

        if ($item->status === 'returned') {
            return back()->with('error', 'This item has already been returned.');
        }

        $existingClaim = Claim::where('item_id', $id)
                              ->where('user_id', auth()->id())
                              ->first();

        if ($existingClaim) {
            return back()->with('error', 'You have already submitted a claim for this item.');
        }

        return view('auth.claim', compact('item'));
    }

    // AJAX Check Security Answer
    public function checkSecurityAnswer(Request $request, $id)
    {
        $item = Item::findOrFail($id);
        
        if (password_verify($request->answer, $item->security_answer)) {
            return response()->json(['success' => true]);
        }
        
        return response()->json(['success' => false, 'message' => 'Incorrect answer. Please try again.']);
    }

    // Submit claim
    public function submitClaim(Request $request, $id)
    {
        $item = Item::with('user')->findOrFail($id);
        $request->validate([
            'answer' => 'required|string',
            'delivery_method' => 'required|in:self_pickup,delivery',
        ]);

        if (!password_verify($request->answer, $item->security_answer)) {
            return back()->withErrors(['answer' => 'Invalid security answer.'])->withInput();
        }

        $claim = Claim::create([
            'item_id' => $item->id,
            'user_id' => auth()->id(),
            'answer' => $request->answer,
            'delivery_method' => $request->delivery_method,
            'status' => 'pending',
        ]);

        // =========================================================================
        // JIKA SELF-PICKUP: Hantar Emel Temu Janji Ke Finder & Set Status 'claimed'
        // =========================================================================
        if ($request->delivery_method === 'self_pickup') {
            $item->update(['status' => 'awaiting_appointment']);

            // Ambil data untuk dihantar dalam emel
            $finderEmail = $item->user->email;
            $finderName = $item->user->name;
            $claimantName = auth()->user()->name;
            $itemTitle = $item->title;
            $itemUrl = url('/items/');

            try {
                Mail::send([], [], function ($message) use ($finderEmail, $finderName, $claimantName, $itemTitle, $itemUrl) {
                    $message->to($finderEmail)
                        ->subject('[UTM FoundIt] 📅 Action Required: Set Pickup Appointment for ' . $itemTitle)
                        ->html("
                            <div style='font-family: Arial, sans-serif; padding: 25px; color: #333; max-width: 600px; border: 1px solid #e5e7eb; border-radius: 16px;'>
                                <h2 style='color: #800000; margin-bottom: 20px;'>Hello, {$finderName}!</h2>
                                <p>Good news! <strong>{$claimantName}</strong> has successfully answered your security question and claimed the item you found: <strong>{$itemTitle}</strong>.</p>
                                
                                <p>Since the claimant selected <strong>🏃 Self Pickup</strong> as their recovery method, you are required to arrange the handover.</p>
                                
                                <div style='background-color: #fef2f2; border: 1px solid #fee2e2; border-radius: 12px; padding: 15px; margin: 20px 0;'>
                                    <p style='margin: 0; font-weight: bold; color: #991b1b;'>What should you do next?</p>
                                    <p style='margin: 5px 0 0 0; font-size: 14px; color: #7f1d1d;'>Please log into <strong>UTM FoundIt</strong>, navigate to your original post, and coordinate with the claimant to set up the appointment date, time, and location.</p>
                                </div>

                                <p style='margin-top: 30px; margin-bottom: 30px;'>
                                    <a href='{$itemUrl}' style='background-color: #800000; color: white; padding: 12px 24px; text-decoration: none; border-radius: 8px; font-weight: bold; display: inline-block;'>
                                        Go to Original Post
                                    </a>
                                </p>

                                <hr style='border: 0; border-top: 1px solid #e5e7eb; margin-top: 20px;'>
                                <p style='color: #666; font-size: 12px; margin-top: 20px;'>*This is an automated system email from UTM FoundIt. Please do not reply directly to this message.</p>
                            </div>
                        ");
                });
            } catch (\Exception $e) {
                \Log::error("Gagal hantar email appointment ke Finder: " . $e->getMessage());
            }

            return redirect('/items')->with('status', 'Claim request (Self-Pickup) submitted successfully! Finder has been notified via email to set an appointment.');
        }

        // Jika delivery, bawa ke fasa payment dulu
        $item->update(['status' => 'awaiting_payment']);

        // Send notification email to the Finder (Untuk kes delivery)
        try {
            Mail::to($item->user->email)->send(new ClaimNotificationMail($claim));
        } catch (\Exception $e) {}

        return redirect()->route('claim.payment', $claim->id);
    }

    // My claims page (claimant)
    public function myClaims()
    {
        $claims = Claim::with('item')
                       ->where('user_id', auth()->id())
                       ->orderBy('created_at', 'desc')
                       ->get();

        return view('auth.my-claims', compact('claims'));
    }

    // Finder's claims inbox
    public function finderClaims()
    {
        $items = Item::with(['claims.user'])
                     ->where('user_id', auth()->id())
                     ->where('type', 'found')
                     ->orderBy('created_at', 'desc')
                     ->get();

        return view('auth.finder-claims', compact('items'));
    }

    // Approve claim
    public function approveClaim($claimId)
    {
        $claim = Claim::with(['item', 'user'])->findOrFail($claimId);

        if ($claim->item->user_id !== auth()->id()) {
            return back()->with('error', 'Unauthorized action.');
        }

        $claim->update(['status' => 'approved']);
        
        // Jika kaedah ialah self-pickup, boleh terus buka butang serah
        if ($claim->delivery_method === 'self_pickup') {
            $claim->item->update(['status' => 'claimed']); 
        } else {
            $claim->item->update(['status' => 'awaiting_payment']);
        }

        // Send email to claimant
        try {
            Mail::to($claim->user->email)->send(new ClaimStatusMail($claim, 'approved'));
        } catch (\Exception $e) {}

        return back()->with('status', 'Claim approved successfully! The claimant has been notified.');
    }

    // Reject claim
    public function rejectClaim($claimId)
    {
        $claim = Claim::with(['item', 'user'])->findOrFail($claimId);

        if ($claim->item->user_id !== auth()->id()) {
            return back()->with('error', 'Unauthorized action.');
        }

        $claim->update(['status' => 'rejected']);
        $claim->item->update(['status' => 'active']);

        // Send email to claimant
        try {
            Mail::to($claim->user->email)->send(new ClaimStatusMail($claim, 'rejected'));
        } catch (\Exception $e) {}

        return back()->with('status', 'Claim rejected. The item is now active again.');
    }

    // Show payment page (Only for the matching claimant)
    public function showPayment($claimId)
    {
        $claim = Claim::with('item.user')->findOrFail($claimId);
        
        if ($claim->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('auth.payment', compact('claim'));
    }

    // Process payment (Upload Bank Receipt)
    public function processPayment(Request $request, $id)
    {
        $request->validate([
            'shipping_address' => 'required|string',
            'receipt_file' => 'required|image|mimes:jpeg,png,jpg,pdf|max:2048',
        ]);

        // 1. TERUS LOAD skali dengan hubungan Item dan User (Finder) di awal query
        $claim = Claim::with(['item.user', 'user'])->findOrFail($id);

        if ($request->hasFile('receipt_file')) {
            $path = $request->file('receipt_file')->store('receipts', 'public');
            
            // 2. Kemas kini rekod claim
            $claim->update([
                'payment_receipt' => $path,
                'status' => 'paid'
            ]);

            // Status item dipaksa menjadi 'claimed' supaya Finder nampak di UI
            $claim->item->update([
                'status' => 'claimed' 
            ]);

            // 3. Ambil emel Finder secara direct daripada object yang dah di-load tadi
            $finderEmail = $claim->item->user->email ?? null; 

            if ($finderEmail) {
                try {
                    // Hantar mailable object. 
                    // Pastikan dalam __construct() PaymentReceiptMail kau ada terima variable $claim dan $address!
                    Mail::to($finderEmail)->send(new PaymentReceiptMail($claim, $request->shipping_address));
                } catch (\Exception $e) {
                    // Jika sangkut, check log dekat storage/logs/laravel.log untuk tengok ralat SMTP
                    \Log::error("Gagal hantar email resit ke Finder: " . $e->getMessage());
                }
            }
        }

        return redirect('/dashboard')->with('status', 'Payment submitted and Finder notified!');
    }

    // Finder save appointment details & send email to claimant
    public function storeAppointment(Request $request, $itemId)
    {
        $request->validate([
            'appointment_date' => 'required|date|after:now',
            'appointment_location' => 'required|string|max:255',
        ]);

        $item = Item::findOrFail($itemId);

        if ($item->user_id !== auth()->id()) {
            return back()->with('error', 'Unauthorized action.');
        }

        // Cari claim yang bertaraf pending bagi item ini
        $claim = Claim::where('item_id', $item->id)->where('status', 'pending')->first();

        if (!$claim) {
            return back()->with('error', 'No active claim found for this item.');
        }

        // Simpan data ke dalam table claims dan up status ke approved
        $claim->update([
            'appointment_date' => $request->appointment_date,
            'appointment_location' => $request->appointment_location,
            'status' => 'approved'
        ]);

        // Tukar status item kepada 'claimed' supaya Finder boleh tekan 'Mark as Returned' lepas ni
        $item->update(['status' => 'claimed']);

        // Hantar emel butiran appointment kepada Claimant
        try {
            $claimantEmail = $claim->user->email;
            $claimantName = $claim->user->name;
            $itemTitle = $item->title;
            $appDate = \Carbon\Carbon::parse($request->appointment_date)->format('d-m-Y (h:i A)');
            $appLoc = $request->appointment_location;

            Mail::send([], [], function ($message) use ($claimantEmail, $claimantName, $itemTitle, $appDate, $appLoc) {
                $message->to($claimantEmail)
                    ->subject('[UTM FoundIt] 🗓️ Appointment Confirmed for Your Claim!')
                    ->html("
                        <div style='font-family: Arial, sans-serif; padding: 25px; color: #333; max-width: 600px; border: 1px solid #e5e7eb; border-radius: 16px;'>
                            <h2 style='color: #15803d; margin-bottom: 20px;'>Hello, {$claimantName}!</h2>
                            <p>The finder has set a pickup appointment for your claimed item: <strong>{$itemTitle}</strong>.</p>
                            
                            <div style='background-color: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 12px; padding: 15px; margin: 20px 0;'>
                                <p style='margin: 0 0 8px 0; font-weight: bold; color: #166534;'>📍 Appointment Details:</p>
                                <p style='margin: 4px 0; font-size: 14px;'><strong>Date & Time:</strong> {$appDate}</p>
                                <p style='margin: 4px 0; font-size: 14px;'><strong>Location:</strong> {$appLoc}</p>
                            </div>

                            <p>Please meet the finder at the designated time and place. Once you have successfully received your item, remember to log in and confirm receipt!</p>
                            <hr style='border: 0; border-top: 1px solid #e5e7eb; margin-top: 20px;'>
                            <p style='color: #666; font-size: 12px; margin-top: 20px;'>*This is an automated system email from UTM FoundIt. Please do not reply directly.</p>
                        </div>
                    ");
            });
        } catch (\Exception $e) {
            \Log::error("Gagal hantar email appointment detail ke Claimant: " . $e->getMessage());
        }

        return back()->with('status', 'Appointment successfully scheduled! Claimant has been notified via email.');
    }
}