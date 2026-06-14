<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\Report;
use App\Models\Item;
use App\Models\Claim;

class AdminReportController extends Controller
{
    public function index()
    {
        $reports = Report::with(['item', 'user'])
            ->latest()
            ->paginate(20);

        return view('admin.reports.index', compact('reports'));
    }

    public function review($id)
    {
        $report = Report::with(['item', 'user'])->findOrFail($id);
        $claim  = Claim::where('item_id', $report->item_id)->first();

        return view('admin.reports.review', compact('report', 'claim'));
    }

    public function markReviewed($id)
    {
        $report = Report::findOrFail($id);
        $report->update(['status' => 'reviewed']);

        return back()->with('success', 'Report marked as reviewed');
    }

    public function decide(Request $request, $id)
    {
        $report = Report::findOrFail($id);
        $item   = Item::findOrFail($report->item_id);
        $claim  = Claim::where('item_id', $report->item_id)
                       ->where('user_id', $report->user_id)
                       ->latest()
                       ->first();

        if ($request->decision === 'approve') {

            // Unlock claim attempts
            \App\Models\ClaimAttempt::where('item_id', $report->item_id)
                ->where('user_id', $report->user_id)
                ->update(['locked' => false, 'attempts' => 0]);

            // Auto-approve claim if exists
            if ($claim) {
                $claim->update(['status' => 'approved']);
                if ($claim->delivery_method === 'delivery') {
                    $item->update(['status' => 'awaiting_payment']);
                } else {
                    $item->update(['status' => 'awaiting_appointment']);
                }
            }

            // Email user to claim again
            try {
                $user = \App\Models\User::findOrFail($report->user_id);

                Mail::send([], [], function ($msg) use ($user, $item) {
                    $msg->to($user->email)
                        ->subject('[UTM FoundIt] Your Report Has Been Approved — Please Claim Again')
                        ->html("
                            <div style='font-family:Arial,sans-serif;padding:25px;color:#333;max-width:600px;border:1px solid #e5e7eb;border-radius:16px;'>
                                <h2 style='color:#800000;'>Hello, {$user->name}!</h2>
                                <p>Your report regarding the security answer for <strong>{$item->title}</strong> has been reviewed and approved by our admin team.</p>
                                <p>You may now proceed to claim the item again.</p>
                                <p>
                                    <a href='" . url('/items/' . $item->id . '/claim') . "' style='background:#800000;color:#fff;padding:12px 24px;text-decoration:none;border-radius:8px;font-weight:bold;display:inline-block;'>
                                        Claim Item Now
                                    </a>
                                </p>
                                <p style='color:#999;font-size:12px;margin-top:20px;'>Automated email — do not reply.</p>
                            </div>
                        ");
                });
            } catch (\Exception $e) {
                \Log::error('Admin approve report email failed: ' . $e->getMessage());
            }

        } else {
            // Reject
            if ($claim) {
                $claim->update(['status' => 'rejected']);
            }
            $item->update(['status' => 'active']);
        }

        $report->update(['status' => 'dismissed']);

        return redirect()->route('admin.reports.index')->with('success', 'Report has been resolved successfully.');
    }
}