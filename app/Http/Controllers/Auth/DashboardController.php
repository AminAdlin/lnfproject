<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Notification;

class DashboardController extends Controller
{
    public function index()
    {
        $totalLost    = Item::where('type', 'lost')->where('status', 'active')->count();
        $totalFound   = Item::where('type', 'found')->where('status', 'active')->count();
        $totalClaimed = Item::where('status', 'claimed')->orWhere('status', 'returned')->count();
        $recentItems  = Item::with('user')->orderBy('created_at', 'desc')->take(5)->get();
        $unreadCount  = Notification::where('receiver_id', auth()->id())->where('is_read', false)->count();

        return view('auth.dashboard', compact(
            'totalLost', 'totalFound', 'totalClaimed', 'recentItems', 'unreadCount'
        ));
    }
}