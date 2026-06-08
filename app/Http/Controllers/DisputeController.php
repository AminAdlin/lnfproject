<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Claim;
use App\Models\Dispute;
use Illuminate\Support\Facades\Mail;

class DisputeController extends Controller
{
    public function store(Request $request, $itemId)
    {
        $request->validate([
            'reason'  => 'required|in:item_not_received,fake_receipt',
            'message' => 'nullable|string|max:1000',
        ]);

        $item  = Item::with('user')->findOrFail($itemId);
        $claim = Claim::where('item_id', $itemId)
                      ->where('status', 'approved')
                      ->latest()
                      ->firstOrFail();

        // Resolve roles
        $finderUser = $item->type === 'found' ? $item->user : $claim->user;
        $ownerUser  = $item->type === 'found' ? $claim->user : $item->user;
        $currentId  = auth()->id();

        // Validate who can raise which dispute
        if ($request->reason === 'item_not_received') {
            // Only Owner/Claimant can raise this
            if ($currentId !== $ownerUser->id) {
                return back()->with('error', 'Only the item owner can raise this dispute.');
            }
            if ($item->status !== 'returned_by_finder') {
                return back()->with('error', 'This dispute can only be raised after the finder marks the item as returned.');
            }
        }

        if ($request->reason === 'fake_receipt') {
            // Only Finder can raise this
            if ($currentId !== $finderUser->id) {
                return back()->with('error', 'Only the finder can raise this dispute.');
            }
            if ($item->status !== 'claimed') {
                return back()->with('error', 'This dispute can only be raised after payment is submitted.');
            }
        }

        // Prevent duplicate dispute
        if (Dispute::where('item_id', $itemId)->where('status', 'open')->exists()) {
            return back()->with('error', 'A dispute is already open for this item.');
        }

        Dispute::create([
            'item_id'   => $itemId,
            'claim_id'  => $claim->id,
            'raised_by' => auth()->id(),
            'reason'    => $request->reason,
            'message'   => $request->message,
            'status'    => 'open',
        ]);

        // Freeze item
        $item->update(['status' => 'disputed']);

        // Email admin
        try {
            $adminEmail   = env('ADMIN_EMAIL', 'admin@utmfoundit.com');
            $raiserName   = auth()->user()->name;
            $itemTitle    = $item->title;
            $reason       = $request->reason === 'item_not_received'
                            ? 'Item Not Received (Finder marked returned but item did not arrive)'
                            : 'Fake Receipt (Owner submitted fraudulent payment proof)';
            $message      = $request->message ?? 'No additional details provided.';

            Mail::send([], [], function ($msg) use ($adminEmail, $raiserName, $itemTitle, $reason, $message, $item, $finderUser, $ownerUser) {
                $msg->to($adminEmail)
                    ->subject('[UTM FoundIt] Dispute Raised: ' . $itemTitle)
                    ->html("
                        <div style='font-family:Arial,sans-serif;padding:25px;color:#333;max-width:600px;border:1px solid #e5e7eb;border-radius:16px;'>
                            <h2 style='color:#800000;'>⚠️ Dispute Raised</h2>
                            <div style='background:#fff5f5;border:1px solid #fecaca;border-radius:12px;padding:15px;margin:15px 0;'>
                                <p style='margin:4px 0;'><strong>Item:</strong> {$itemTitle}</p>
                                <p style='margin:4px 0;'><strong>Finder:</strong> {$finderUser->name} ({$finderUser->email})</p>
                                <p style='margin:4px 0;'><strong>Owner:</strong> {$ownerUser->name} ({$ownerUser->email})</p>
                                <p style='margin:4px 0;'><strong>Raised by:</strong> {$raiserName}</p>
                                <p style='margin:4px 0;'><strong>Reason:</strong> {$reason}</p>
                            </div>
                            <div style='background:#f9fafb;border:1px solid #e5e7eb;border-radius:12px;padding:15px;margin:15px 0;'>
                                <p style='margin:0 0 6px;font-weight:bold;color:#555;'>Details:</p>
                                <p style='margin:0;font-style:italic;color:#666;'>{$message}</p>
                            </div>
                            <p style='color:#dc2626;font-weight:bold;'>The item has been frozen pending investigation. Please review and resolve via the admin panel or contact both parties directly.</p>
                            <p style='color:#999;font-size:12px;margin-top:20px;'>Automated email — do not reply.</p>
                        </div>
                    ");
            });
        } catch (\Exception $e) {
            \Log::error('Dispute email to admin failed: ' . $e->getMessage());
        }

        // Email both parties
        try {
            $otherUser  = ($currentId === $ownerUser->id) ? $finderUser : $ownerUser;
            $raiserName = auth()->user()->name;
            $itemTitle  = $item->title;

            Mail::send([], [], function ($msg) use ($otherUser, $raiserName, $itemTitle) {
                $msg->to($otherUser->email)
                    ->subject('[UTM FoundIt] A Dispute Has Been Raised: ' . $itemTitle)
                    ->html("
                        <div style='font-family:Arial,sans-serif;padding:25px;color:#333;max-width:600px;border:1px solid #e5e7eb;border-radius:16px;'>
                            <h2 style='color:#800000;'>⚠️ Dispute Notice</h2>
                            <p>Hello {$otherUser->name},</p>
                            <p><strong>{$raiserName}</strong> has raised a dispute regarding <strong>{$itemTitle}</strong>.</p>
                            <p>The item has been temporarily frozen. Our team has been notified and will investigate.</p>
                            <p>If you have any evidence or information to provide, please contact the UTM FoundIt admin team directly via your UTM email.</p>
                            <p style='color:#999;font-size:12px;margin-top:20px;'>Automated email — do not reply.</p>
                        </div>
                    ");
            });
        } catch (\Exception $e) {
            \Log::error('Dispute email to other party failed: ' . $e->getMessage());
        }

        return back()->with('status', 'Dispute raised. Our team has been notified and both parties have been informed. The item is now frozen pending investigation.');
    }
}