<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dispute;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class AdminDisputeController extends Controller
{
    public function index()
    {
        $disputes = Dispute::with(['item', 'claim', 'reporter'])
            ->latest()
            ->paginate(20);

        return view('admin.disputes.index', compact('disputes'));
    }

    public function show($id)
    {
        $disputes = Dispute::with(['item', 'claim', 'reporter'])
            ->findOrFail($id);

        return view('admin.disputes.show', compact('dispute'));
    }

    /**
     * Resolve dispute → close case
     * Regardless of reason, admin resolving = case closed
     */
    public function resolve(Request $request, $id)
    {
        $dispute = Dispute::with(['item', 'claim.user', 'item.user'])->findOrFail($id);
        $item    = $dispute->item;
        $claim   = $dispute->claim;

        // Mark dispute as resolved
        $dispute->update(['status' => 'resolved']);

        // Close the case — item returned, claim closed
        if ($item) {
            $item->update(['status' => 'returned']);
        }

        if ($claim) {
            $claim->update(['status' => 'closed']);
        }

        // Email both parties
        try {
            $finderUser = $item->type === 'found' ? $item->user : $claim->user;
            $ownerUser  = $item->type === 'found' ? $claim->user : $item->user;

            // Email Finder
            Mail::send([], [], function ($msg) use ($finderUser, $ownerUser, $item) {
                $msg->to($finderUser->email)
                    ->subject('[UTM FoundIt] Dispute Resolved — Case Closed: ' . $item->title)
                    ->html("
                        <div style='font-family:Arial,sans-serif;padding:25px;color:#333;max-width:600px;border:1px solid #e5e7eb;border-radius:16px;'>
                            <h2 style='color:#800000;'>Hello, {$finderUser->name}!</h2>
                            <p>The dispute for <strong>{$item->title}</strong> has been reviewed and resolved by our admin team.</p>
                            <p>The case is now officially closed.</p>
                            <p style='color:#999;font-size:12px;margin-top:20px;'>Automated email — do not reply.</p>
                        </div>
                    ");
            });

            // Email Owner
            Mail::send([], [], function ($msg) use ($ownerUser, $finderUser, $item) {
                $msg->to($ownerUser->email)
                    ->subject('[UTM FoundIt] Dispute Resolved — Case Closed: ' . $item->title)
                    ->html("
                        <div style='font-family:Arial,sans-serif;padding:25px;color:#333;max-width:600px;border:1px solid #e5e7eb;border-radius:16px;'>
                            <h2 style='color:#800000;'>Hello, {$ownerUser->name}!</h2>
                            <p>The dispute for <strong>{$item->title}</strong> has been reviewed and resolved by our admin team.</p>
                            <p>The case is now officially closed.</p>
                            <p style='color:#999;font-size:12px;margin-top:20px;'>Automated email — do not reply.</p>
                        </div>
                    ");
            });
        } catch (\Exception $e) {
            \Log::error('Dispute resolve email failed: ' . $e->getMessage());
        }

        return redirect()
            ->route('admin.disputes.index')
            ->with('success', 'Dispute resolved and case closed successfully.');
    }
}