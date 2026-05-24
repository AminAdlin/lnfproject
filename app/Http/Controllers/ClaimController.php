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

        // Jika Self-pickup, terus set status item kepada 'claimed' (Pending Review)
        if ($request->delivery_method === 'self_pickup') {
            $item->update(['status' => 'claimed']);
            return redirect('/items')->with('status', 'Claim request (Self-Pickup) submitted successfully!');
        }

        // Jika delivery, bawa ke fasa payment dulu
        $item->update(['status' => 'awaiting_payment']);

        // Send notification email to the Finder
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
}