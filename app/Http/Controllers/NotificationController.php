<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Claim;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function myNotifications()
    {
        // Get all "I Found This" submissions for Owner's lost posts
        $notifications = Claim::with(['item', 'user'])
            ->whereHas('item', function ($q) {
                $q->where('type', 'lost')
                  ->where('user_id', auth()->id());
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return view('auth.notifications', compact('notifications'));
    }
}