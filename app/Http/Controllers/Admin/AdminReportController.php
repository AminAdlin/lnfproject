<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminReportController extends Controller
{
    public function index()
    {
        $reports = Report::with([
            'item',
            'user'
        ])
        ->latest()
        ->paginate(20);

        return view(
            'admin.reports.index',
            compact('reports')
        );
    }

    public function review($id)
    {
        $report = Report::findOrFail($id);

        $report->update([
            'status' => 'reviewed',
            'reviewed_by' => auth()->id(),
            'reviewed_at' => now()
        ]);

        return back();
    }
}
