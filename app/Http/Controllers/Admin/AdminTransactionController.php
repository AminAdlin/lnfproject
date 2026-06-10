<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Claim;
use Illuminate\Http\Request;

class AdminTransactionController extends Controller
{
    public function index()
    {
        $transactions = Claim::with([
            'item',
            'user'
        ])
        ->whereNotNull('payment_method')
        ->latest()
        ->paginate(20);

        return view(
            'admin.transactions.index',
            compact('transactions')
        );
    }
}
