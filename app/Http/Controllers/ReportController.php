<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Report;
use Illuminate\Support\Facades\Mail;

class ReportController extends Controller
{
    public function store(Request $request, $itemId)
    {
        $request->validate([
            'reason'  => 'required|in:fake_suspicious,already_resolved,spam_duplicate,inappropriate,other',
            'message' => 'nullable|string|max:500',
        ]);

        $item = Item::with('user')->findOrFail($itemId);

        // Prevent self-reporting
        if ($item->user_id === auth()->id()) {
            return back()->with('error', 'You cannot report your own post.');
        }

        // Prevent duplicate report from same user
        if (Report::where('item_id', $itemId)->where('user_id', auth()->id())->exists()) {
            return back()->with('error', 'You have already reported this post.');
        }

        $report = Report::create([
            'item_id' => $itemId,
            'user_id' => auth()->id(),
            'reason'  => $request->reason,
            'message' => $request->message,
        ]);

        // Email admin
        try {
            $adminEmail   = config('mail.admin_email', env('ADMIN_EMAIL', 'admin@utmfoundit.com'));
            $reporterName = auth()->user()->name;
            $itemTitle    = $item->title;
            $itemOwner    = $item->user->name;
            $reason       = match($request->reason) {
                'fake_suspicious'  => 'Fake / Suspicious Post',
                'already_resolved' => 'Already Resolved',
                'spam_duplicate'   => 'Spam / Duplicate',
                'inappropriate'    => 'Inappropriate Content',
                'other'            => 'Other',
            };
            $message = $request->message ?? 'No additional details provided.';

            Mail::send([], [], function ($msg) use ($adminEmail, $reporterName, $itemTitle, $itemOwner, $reason, $message, $item) {
                $msg->to($adminEmail)
                    ->subject('[UTM FoundIt] Post Reported: ' . $itemTitle)
                    ->html("
                        <div style='font-family:Arial,sans-serif;padding:25px;color:#333;max-width:600px;border:1px solid #e5e7eb;border-radius:16px;'>
                            <h2 style='color:#800000;'>⚠️ Post Report Received</h2>
                            <div style='background:#fff5f5;border:1px solid #fecaca;border-radius:12px;padding:15px;margin:15px 0;'>
                                <p style='margin:4px 0;'><strong>Item:</strong> {$itemTitle}</p>
                                <p style='margin:4px 0;'><strong>Posted by:</strong> {$itemOwner}</p>
                                <p style='margin:4px 0;'><strong>Reported by:</strong> {$reporterName}</p>
                                <p style='margin:4px 0;'><strong>Reason:</strong> {$reason}</p>
                            </div>
                            <div style='background:#f9fafb;border:1px solid #e5e7eb;border-radius:12px;padding:15px;margin:15px 0;'>
                                <p style='margin:0 0 6px;font-weight:bold;color:#555;'>Additional Details:</p>
                                <p style='margin:0;font-style:italic;color:#666;'>{$message}</p>
                            </div>
                            <p>
                                <a href='" . url('/items') . "' style='background:#800000;color:#fff;padding:12px 24px;text-decoration:none;border-radius:8px;font-weight:bold;display:inline-block;'>
                                    View on UTM FoundIt
                                </a>
                            </p>
                            <p style='color:#999;font-size:12px;margin-top:20px;'>Automated email — do not reply.</p>
                        </div>
                    ");
            });
        } catch (\Exception $e) {
            \Log::error('Report email to admin failed: ' . $e->getMessage());
        }

        return back()->with('status', 'Report submitted. Our team will review it shortly.');
    }
}