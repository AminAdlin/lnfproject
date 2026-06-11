<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dispute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\FakeReceiptWarningMail;
use App\Mail\ItemNotReceivedMail;

class AdminDisputeController extends Controller
{
    public function index()
    {
        $disputes = Dispute::with([
            'item',
            'claim',
            'reporter'
        ])
        ->latest()
        ->paginate(20);

        return view(
            'admin.disputes.index', compact('disputes'));
    }

    public function show($id)
    {
        $dispute = Dispute::with([
            'item',
            'claim',
            'reporter'
        ])
        ->findOrFail($id);

        return view(
            'admin.disputes.show',
            compact('dispute')
        );
    }

    public function resolve($id)
    {

        $dispute = Dispute::with(['item', 'claim.user', 'item.user'])->findOrFail($id);

        $dispute->update([
            'status' => 'resolved'
        ]);

        if ($dispute->type === 'fake_receipt') {

        // 🚨 send warning to CLAIMANT
        if ($dispute->claim && $dispute->claim->user) {
            Mail::to($dispute->claim->user->email)
                ->send(new \App\Mail\FakeReceiptWarningMail($dispute));
        }

    } elseif ($dispute->type === 'item_not_received') {

        // 🚨 send to FINDER
        if ($dispute->item && $dispute->item->user) {
            Mail::to($dispute->item->user->email)
                ->send(new \App\Mail\ItemNotReceivedMail($dispute));
        }
    }

        return redirect()
        ->route('admin.disputes.index')
        ->with('success', 'Dispute resolved successfully.');
    }
}