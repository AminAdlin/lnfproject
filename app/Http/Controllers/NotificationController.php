<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Notification as AppNotification;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function showFoundThisForm($id)
    {
        $item = Item::findOrFail($id);

        if ($item->type !== 'lost') {
            return back()->with('error', 'This action is not available.');
        }

        if ($item->user_id === auth()->id()) {
            return back()->with('error', 'This is your own post.');
        }

        return view('auth.found-this', compact('item'));
    }

    public function submitFoundThis(Request $request, $id)
    {
        $item = Item::findOrFail($id);

        $request->validate([
            'message' => 'required|string|max:500',
            'contact' => 'required|string|max:255',
        ]);

        AppNotification::create([
            'item_id'     => $item->id,
            'sender_id'   => auth()->id(),
            'receiver_id' => $item->user_id,
            'message'     => $request->message,
            'contact'     => $request->contact,
            'is_read'     => false,
        ]);

        return redirect('/items')->with('status', 'The owner has been notified successfully!');
    }

    public function myNotifications()
    {
        $notifications = AppNotification::with(['item', 'sender'])
                                        ->where('receiver_id', auth()->id())
                                        ->orderBy('created_at', 'desc')
                                        ->get();

        AppNotification::where('receiver_id', auth()->id())
                       ->where('is_read', false)
                       ->update(['is_read' => true]);

        return view('auth.notifications', compact('notifications'));
    }
}