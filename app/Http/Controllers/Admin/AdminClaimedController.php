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
    ])->latest()->paginate(10);

    return view('admin.claimed.index', compact('claimed'));
}

public function show($id)
{
    $claim = Claim::with([
        'item',
        'user',
        'transaction'
    ])->findOrFail($id);

    return view('admin.claimed.show', compact('claim'));
}
}
