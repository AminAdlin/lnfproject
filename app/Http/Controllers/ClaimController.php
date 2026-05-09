<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Claim;
use Illuminate\Support\Facades\Auth;

class ClaimController extends Controller
{
    // Show claim form
    public function showClaimForm($id)
    {
        $item = Item::findOrFail($id);

        // Only found items can be claimed
        if ($item->type !== 'found') {
            return back()->with('error', 'This item cannot be claimed.');
        }

        // Cannot claim own item
        if ($item->user_id === auth()->id()) {
            return back()->with('error', 'You cannot claim your own post.');
        }

        // Cannot claim already returned item
        if ($item->status === 'returned') {
            return back()->with('error', 'This item has already been returned.');
        }

        // Check if already claimed by this user
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
        $item = Item::findOrFail($id);

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
        Claim::create([
            'item_id'         => $item->id,
            'user_id'         => auth()->id(),
            'answer'          => $request->answer,
            'delivery_method' => $request->delivery_method,
            'status'          => 'pending',
        ]);

        // Update item status to claimed
        $item->update(['status' => 'claimed']);

        return redirect('/items')->with('status', 'Claim submitted successfully! The finder will be notified.');
    }

    // My claims page
    public function myClaims()
    {
        $claims = Claim::with('item')
                       ->where('user_id', auth()->id())
                       ->orderBy('created_at', 'desc')
                       ->get();

        return view('auth.my-claims', compact('claims'));
    }
}