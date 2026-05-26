<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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

        DB::table('notifications')->insert([
            'item_id'     => $item->id,
            'sender_id'   => auth()->id(),
            'receiver_id' => $item->user_id,
            'message'     => $request->message,
            'contact'     => $request->contact,
            'is_read'     => false,
            'created_at'  => now(),
            'updated_at'  => now(),
        ]);

        return redirect('/items')->with('status', 'The owner has been notified successfully!');
    }

    public function myNotifications()
    {
        $notifications = DB::table('notifications')
                           ->join('items', 'notifications.item_id', '=', 'items.id')
                           ->join('users', 'notifications.sender_id', '=', 'users.id')
                           ->where('notifications.receiver_id', auth()->id())
                           ->orderBy('notifications.created_at', 'desc')
                           ->select(
                               'notifications.*',
                               'items.title as item_title',
                               'users.name as sender_name'
                           )
                           ->get();

        // Mark all as read
        DB::table('notifications')
          ->where('receiver_id', auth()->id())
          ->where('is_read', false)
          ->update(['is_read' => true]);

        return view('auth.notifications', compact('notifications'));
    }
}