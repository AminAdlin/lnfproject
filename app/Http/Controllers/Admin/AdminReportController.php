<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
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

        $claim = Claim::where('item_id', $report->item_id)->first();

        return view('admin.reports.review', compact('report', 'claim'));
    }

    /**
     * MARK AS REVIEWED
     * - spam/fake → finish
     * - security_answer → open modal
     */
    public function markReviewed($id)
    {
        $report = Report::findOrFail($id);

        $report->update([
            'status' => 'reviewed'
        ]);

        return back()->with('success', 'Report marked as reviewed');
    }

    /**
     * FINAL DECISION (security only)
     */
    public function decide(Request $request, $id)
    {
        $report = Report::findOrFail($id);

        if ($report->type !== 'security_answer') {
            return response()->json([
                'success' => false,
                'message' => 'Invalid report type'
            ], 403);
        }

        $claim = Claim::where('item_id', $report->item_id)->first();
        $item  = Item::findOrFail($report->item_id);

        if ($request->decision === 'approve') {

            $item->update([
                'status' => 'claimed',
                'user_id' => $claim->user_id
            ]);

            $claim->update([
                'status' => 'approved'
            ]);

        } else {

            $claim->update([
                'status' => 'rejected'
            ]);
        }

        $report->update([
            'status' => 'resolved'
        ]);

        return response()->json([
            'success' => true
        ]);
    }
}