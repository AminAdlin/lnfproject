<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Claim;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class ClaimController extends Controller
{
    // Show claim form
    public function showClaimForm($id)
    {
        $item = Item::findOrFail($id);

        if ($item->type !== 'found') {
            return back()->with('error', 'This item cannot be claimed.');
        }

        if ($item->user_id === Auth::id()) {
            return back()->with('error', 'You cannot claim your own post.');
        }

        if ($item->status === 'returned') {
            return back()->with('error', 'This item has already been returned.');
        }

        $existingClaim = Claim::where('item_id', $id)
                              ->where('user_id', Auth::id())
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

        // Verify security answer
        if (!password_verify($request->answer, $item->security_answer)) {
            return back()->withErrors([
                'answer' => 'Your answer is incorrect. Please try again.',
            ])->withInput();
        }

        // Create claim
        $claim = Claim::create([
            'item_id'         => $item->id,
            'user_id'         => Auth::id(),
            'answer'          => $request->answer,
            'delivery_method' => $request->delivery_method,
            'status'          => 'pending',
        ]);

        // Update item status
        $item->update(['status' => 'claimed']);

        \App\Models\Notification::create([
            'item_id'     => $item->id,
            'sender_id'   => Auth::id(),
            'receiver_id' => $item->user_id,
            'message'     => Auth::user()->name . ' has claimed your item: ' . $item->title,
            'contact'     => Auth::user()->email,
            'is_read'     => false,
        ]);

            Mail::send(
                'auth.emails.claim-confirmed',
                [
                    'finderName'   => $item->user->name,
                    'itemName'     => $item->title,
                    'claimantName' => Auth::user()->name,
                ],
                function ($message) use ($item) {

                    $message->to($item->user->email)
                        ->subject('Item Claim Notification');

                }
            );

        return redirect('/items')->with('status', 'Claim submitted successfully! The finder has been notified.');
    }

    // My claims page
    public function myClaims()
    {
        $claims = Claim::with('item')
                       ->where('user_id', Auth::id())
                       ->orderBy('created_at', 'desc')
                       ->get();

        return view('auth.my-claims', compact('claims'));
    }
}