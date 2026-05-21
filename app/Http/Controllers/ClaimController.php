<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Claim;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\ClaimNotificationMail;
use App\Mail\ClaimStatusMail;

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

    // Submit claim
    public function submitClaim(Request $request, $id)
    {
        $item = Item::with('user')->findOrFail($id);

        $request->validate([
            'answer'          => 'required|string',
            'delivery_method' => 'required|in:self_pickup,delivery',
        ]);

        if (!password_verify($request->answer, $item->security_answer)) {
            return back()->withErrors([
                'answer' => 'Your answer is incorrect. Please try again.',
            ])->withInput();
        }

        $claim = Claim::create([
            'item_id'         => $item->id,
            'user_id'         => auth()->id(),
            'answer'          => $request->answer,
            'delivery_method' => $request->delivery_method,
            'status'          => 'pending',
        ]);

        $item->update(['status' => 'claimed']);

        // Send email to finder
        try {
            Mail::to($item->user->email)->send(new ClaimNotificationMail($claim->load('item.user', 'user')));
        } catch (\Exception $e) {
            // Email failed but claim still submitted
        }

        return redirect('/items')->with('status', 'Claim submitted successfully! The finder has been notified.');
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

        // Send email to claimant
        try {
            Mail::to($claim->user->email)->send(new ClaimStatusMail($claim, 'approved'));
        } catch (\Exception $e) {}

        // If delivery redirect to payment
        if ($claim->delivery_method === 'delivery') {
            return redirect('/claims/' . $claim->id . '/payment')->with('status', 'Claim approved! Claimant needs to complete payment.');
        }

        return back()->with('status', 'Claim approved! The claimant has been notified.');
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

    // Show payment page
    public function showPayment($claimId)
    {
        $claim = Claim::with(['item.user', 'user'])->findOrFail($claimId);

        if ($claim->user_id !== auth()->id() && $claim->item->user_id !== auth()->id()) {
            return back()->with('error', 'Unauthorized action.');
        }

        return view('auth.payment', compact('claim'));
    }

    // Process payment
    public function processPayment(Request $request, $claimId)
    {
        $claim = Claim::with(['item', 'user'])->findOrFail($claimId);

        if ($claim->user_id !== auth()->id()) {
            return back()->with('error', 'Unauthorized action.');
        }

        $request->validate([
            'card_name'   => 'required|string',
            'card_number' => 'required|string|min:16|max:19',
            'expiry'      => 'required|string',
            'cvv'         => 'required|string|min:3|max:4',
        ]);

        // Simulate payment — create transaction
        \App\Models\Transaction::create([
            'claim_id'          => $claim->id,
            'user_id'           => auth()->id(),
            'amount'            => 5.00,
            'payment_status'    => 'paid',
            'payment_reference' => 'TXN-' . strtoupper(uniqid()),
        ]);

        return redirect('/my-claims')->with('status', 'Payment successful! The finder will arrange delivery soon.');
    }
}