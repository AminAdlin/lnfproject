<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Item;
use App\Models\Claim;
use App\Models\Report;
use App\Models\Dispute;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [

            'totalUsers' =>
                User::where('role', 'user')->count(),

            'totalPosts' => 
                Item::count(),

            'totalLost' =>
                Item::where('type','lost')->count(),

            'totalFound' =>
                Item::where('type','found')->count(),

            'totalClaimed' =>
                Claim::count(),

            'totalReports' =>
                Report::count(),

            'totalDisputes' =>
                Dispute::count(),

            'deletedPosts' => 
                Item::where('status', 'deleted')->count(),

            'recentItems' =>
                Item::latest()->take(10)->get(),
        ]);
    }
}
