<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dispute;
use Illuminate\Http\Request;

class AdminDisputeController extends Controller
{
    public function index()
    {
        $disputes = Dispute::with([
            'item',
            'claim'
        ])
        ->latest()
        ->paginate(20);

        return view(
            'admin.disputes.index',
            compact('disputes')
        );
    }

    public function show($id)
    {
        $dispute = Dispute::with([
            'item.user',
            'claim.user'
        ])
        ->findOrFail($id);

        return view(
            'admin.disputes.show',
            compact('dispute')
        );
    }

    public function resolve(Request $request,$id)
    {
        $dispute = Dispute::findOrFail($id);

        $dispute->update([
            'status'=>'resolved',
            'decision'=>$request->decision,
            'admin_note'=>$request->admin_note,
            'resolved_by'=>auth()->id(),
            'resolved_at'=>now()
        ]);

        return back();
    }
}
