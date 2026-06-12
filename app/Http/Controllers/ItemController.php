<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Claim;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\ItemReturnedMail;

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
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string',
            'location' => 'required|string',
            'date_reported' => 'required|date',
            'contact' => 'required|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'security_question' => 'required|string',
            'security_answer' => 'required|string|regex:/^\S+$/|max:50',
            // Validation for finder's banking information
            'bank_name' => 'required|string|max:100',
            'bank_account' => 'required|string|max:50',
            'bank_qr' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('items', 'public');
        }

        $qrPath = null;
        if ($request->hasFile('bank_qr')) {
            $qrPath = $request->file('bank_qr')->store('bank_qrs', 'public');
        }

        Item::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'description' => $request->description,
            'category' => $request->category,
            'location' => $request->location,
            'date_reported' => $request->date_reported,
            'contact' => $request->contact,
            'image' => $imagePath,
            'type' => 'found',
            'status' => 'active',
            'security_question' => $request->security_question,
            'security_answer' => $request->security_answer,
            'bank_name' => $request->bank_name,
            'bank_account' => $request->bank_account,
            'bank_qr' => $qrPath,
        ]);

        return redirect('/dashboard')->with('status', 'Found item posted successfully!');
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

        return redirect('/items')->with('status', 'Lost item reported successfully!');
    }

    // Show All Items Page
    public function allItems(Request $request)
    {
        $query = Item::with('user')->orderBy('created_at', 'desc');

        if ($request->type) {
            $query->where('type', $request->type);
        }

        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('location', 'like', '%' . $request->search . '%')
                  ->orWhere('category', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        $items = $query->get();

        return view('auth.items', compact('items'));
    }

    // ==========================================
    // DOUBLE CONFIRMATION & DISPUTE SYSTEM
    // ==========================================

    // 1. FINDER: Mark item as Handed Over / Shipped
    public function markReturned($id)
    {
        $item = Item::findOrFail($id);

        // Pastikan hanya Finder (pemilik asal post) yang boleh tekan
        if ($item->user_id !== auth()->id()) {
            return back()->with('error', 'Authorized access only. You are not the finder of this item.');
        }

        // Tukar status item kepada 'returned_by_finder' (Menanti pengesahan Claimant)
        $item->status = 'returned_by_finder';
        $item->save();

        // Cari maklumat tuntutan (claim) yang telah di-approve sebelum ini untuk item tersebut
        $approvedClaim = $item->claims()
        ->where(function($query) {
        $query->where('status', 'approved')
              ->orWhere('status', 'paid');
    })
    ->first();

        // Jika ada tuntutan yang sah, hantar emel peringatan kepada Claimant tersebut
        if ($approvedClaim && $approvedClaim->user) {
            $claimantEmail = $approvedClaim->user->email;
            $claimantName = $approvedClaim->user->name;
            $itemTitle = $item->title;

            Mail::send([], [], function ($message) use ($claimantEmail, $claimantName, $itemTitle) {
                $message->to($claimantEmail)
                    ->subject('[UTM FoundIt] Have you received your item? 📦')
                    ->html("
                        <div style='font-family: Arial, sans-serif; padding: 20px; color: #333;'>
                            <h2 style='color: #7f1d1d;'>Hello, {$claimantName}!</h2>
                            <p>The finder has marked your item <strong>{$itemTitle}</strong> as successfully handed over or posted.</p>
                            <p><strong>What should you do next?</strong></p>
                            <p>If you have safely received your item, please log into <strong>UTM FoundIt</strong>, navigate to the original item post, and click the <strong>'Item Received'</strong> button to officially close this case.</p>
                            <p style='color: #666; font-size: 12px; margin-top: 20px;'>*This is an automated system email, please do not reply directly.</p>
                        </div>
                    ");
            });
        }

        return back()->with('status', 'Item marked as returned! An verification email has been sent to the claimant.');
    }

    // 2. CLAIMANT: Mark item as Received (Case Closed)
    public function markReceived($id)
    {
        $item = Item::findOrFail($id);
        
        // Pastikan user semasa ialah Claimant yang mempunyai rekod claim bertaraf approved/paid bagi item ini
        $isApprovedClaimant = $item->claims()
                                   ->where('user_id', auth()->id())
                                   ->whereIn('status', ['approved', 'paid'])
                                   ->exists();

        if (!$isApprovedClaimant) {
            return back()->with('error', 'Unauthorized action. Only the approved claimant can confirm receipt.');
        }

        // Tukar status item kepada 'returned' (Case Closed)
        $item->status = 'returned';
        $item->save();

        return back()->with('status', 'Case Closed! Thank you for using UTM FoundIt.');
    }

    // 3. CLAIMANT: File an Official Incident Report / Dispute
    public function reportDispute(Request $request, $id)
    {
        $request->validate([
            'dispute_reason' => 'required|string|max:500'
        ]);

        $item = Item::findOrFail($id);
        $claim = Claim::where('item_id', $item->id)->where('user_id', Auth::id())->first();

        if (!$claim) {
            return back()->with('error', 'Unauthorized action.');
        }

        // Lock item state into an unresolved dispute status flag
        $item->update([
            'is_disputed' => true,
            'dispute_reason' => $request->dispute_reason,
            'status' => 'disputed'
        ]);

        // Send an urgent dispute caution email warning straight to the Finder
        try {
            $finderEmail = $item->user->email;
            Mail::send('emails.dispute-alert', ['item' => $item, 'reason' => $request->dispute_reason], function($message) use ($finderEmail) {
                $message->to($finderEmail)->subject('ALERT: A Dispute Has Been Opened For Your Posted Item - UTM FoundIt');
            });
        } catch (\Exception $e) {}

        return back()->with('status', 'Dispute report submitted. The administration team will review this transaction state shortly.');
    }

    // Delete own item
public function deleteItem($id)
{
    // Cari item, kalau tak jumpa dia akan return error 404
    $item = Item::findOrFail($id);

    // Sekat kalau orang lain cuba ceroboh delete guna post request ghaib
    if (auth()->id() !== $item->user_id) {
        return back()->with('error', 'Unauthorized action.');
    }


    $item->delete(); 

    return back()->with('status', 'Post removed successfully from the feed!');
}

    public function showReportLostForm()
{

    return view('auth.report-lost'); 
}

public function submitAddress(Request $request, $id)
{
    $item = Item::findOrFail($id);
    if (auth()->id() !== $item->user_id) { abort(403); }

    $item->update([
        'delivery_address' => $request->delivery_address,
        'status' => 'awaiting_delivery' // Tukar status supaya Finder boleh nampak alamat & butang tracking
    ]);

    return back()->with('status', 'Address updated! Finder has been notified to ship the item.');
}

public function submitTracking(Request $request, $id)
{
    $item = Item::findOrFail($id);
    
    // Pastikan user adalah finder yang telah di-approve
    $isApproved = $item->claims()->where('user_id', auth()->id())->where('status', 'approved')->exists();
    if (!$isApproved) { abort(403); }

    $item->update([
        'tracking_number' => $request->tracking_number,
        'status' => 'returned_by_finder' // Tukar ke status sedia ada kau supaya Owner boleh klik "Item Received"
    ]);

    return back()->with('status', 'Tracking info submitted successfully! Case pending Owner confirmation.');
}
}