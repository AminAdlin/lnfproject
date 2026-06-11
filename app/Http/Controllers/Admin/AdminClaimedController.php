<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Claim;
use Illuminate\Http\Request;

class AdminClaimedController extends Controller
{
    public function index()
    {
        $claimed = Claim::with([
            'item',
            'user'
        ])
        ->whereIn('payment_method', ['fpx', 'bankin', 'selfpickup'])
        ->latest()
        ->paginate(20);

        return view(
            'admin.claimed.index',
            compact('claimed')
        );
    }
}
