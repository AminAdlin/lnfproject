<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view('auth.dashboard', [
            'totalLost' => 0,
            'totalFound' => 0,
            'totalClaimed' => 0,
            'recentItems' => collect([])
        ]);
    }
}