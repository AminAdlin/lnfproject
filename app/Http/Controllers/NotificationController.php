<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    // Show I Found This form
    public function showFoundThisForm($id)
    {
        $item = Item::findOrFail($id);

        // Only lost items
        if ($item->type !== 'lost') {
            return back()->with('error', 'This action is not available.');
        }

        // Cannot notify own item
        if ($item->user_id === Auth::id()) {
            return back()->with('error', 'This is your own post.');
        }

        return view('auth.found-this', compact('item'));
    }

    // Submit I Found This
    public function submitFoundThis(Request $request, $id)
    {
        $item = Item::findOrFail($id);

        $request->validate([
            'message' => 'required|string|max:500',
            'contact' => 'required|string|max:255',
        ]);

        Notification::create([
            'item_id'     => $item->id,
            'sender_id'   => Auth::id(),
            'receiver_id' => $item->user_id,
            'message'     => $request->message,
            'contact'     => $request->contact,
            'is_read'     => false,
        ]);

        return redirect('/items')->with('status', 'The owner has been notified successfully!');
    }

    // My Notifications
    public function myNotifications()
    {
        $notifications = Notification::with(['item', 'sender'])
                                     ->where('receiver_id', Auth::id())
                                     ->orderBy('created_at', 'desc')
                                     ->get();

        // Mark all as read
        Notification::where('receiver_id', Auth::id())
                    ->where('is_read', false)
                    ->update(['is_read' => true]);

        return view('auth.notifications', compact('notifications'));
    }

    // Count unread notifications
    public static function unreadCount()
    {
        return Notification::where('receiver_id', Auth::id())
                           ->where('is_read', false)
                           ->count();
    }
}