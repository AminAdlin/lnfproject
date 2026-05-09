<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ItemController extends Controller
{
    // Show Post Found Item form
    public function showPostFoundForm()
    {
        return view('auth.post-found');
    }

    // Store Found Item
    public function storeFound(Request $request)
    {
        $request->validate([
            'title'             => 'required|string|max:255',
            'description'       => 'required|string',
            'category'          => 'required|string',
            'location'          => 'required|string',
            'date_reported'     => 'required|date',
            'contact'           => 'required|string',
            'image'             => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'security_question' => 'required|string',
            'security_answer'   => 'required|string',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('items', 'public');
        }

        Item::create([
            'user_id'           => Auth::id(),
            'title'             => $request->title,
            'description'       => $request->description,
            'category'          => $request->category,
            'location'          => $request->location,
            'date_reported'     => $request->date_reported,
            'contact'           => $request->contact,
            'image'             => $imagePath,
            'type'              => 'found',
            'status'            => 'active',
            'security_question' => $request->security_question,
            'security_answer'   => bcrypt($request->security_answer),
        ]);

        return redirect('/dashboard')->with('status', 'Found item posted successfully!');
    }

    // Show Report Lost Item form
    public function showReportLostForm()
    {
        return view('auth.report-lost');
    }

    // Store Lost Item
    public function storeLost(Request $request)
    {
        $request->validate([
            'title'         => 'required|string|max:255',
            'description'   => 'required|string',
            'category'      => 'required|string',
            'location'      => 'required|string',
            'date_reported' => 'required|date',
            'contact'       => 'required|string',
            'image'         => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('items', 'public');
        }

        Item::create([
            'user_id'       => Auth::id(),
            'title'         => $request->title,
            'description'   => $request->description,
            'category'      => $request->category,
            'location'      => $request->location,
            'date_reported' => $request->date_reported,
            'contact'       => $request->contact,
            'image'         => $imagePath,
            'type'          => 'lost',
            'status'        => 'active',
        ]);

        return redirect('/dashboard')->with('status', 'Lost item reported successfully!');
    }

    // Show Found Items Page
    public function foundPage()
    {
        $items = Item::where('type', 'found')
                     ->orderBy('created_at', 'desc')
                     ->get();

        return view('auth.found-page', compact('items'));
    }

    // Show Lost Items Page
    public function lostPage()
    {
        $items = Item::where('type', 'lost')
                     ->orderBy('created_at', 'desc')
                     ->get();

        return view('auth.lost-page', compact('items'));
    }

    // Mark item as Returned
    public function markReturned($id)
    {
        $item = Item::findOrFail($id);

        if ($item->user_id !== auth()->id()) {
            return back()->with('error', 'Unauthorized action.');
        }

        $item->update(['status' => 'returned']);

        return back()->with('status', 'Item marked as returned successfully!');
    }
}