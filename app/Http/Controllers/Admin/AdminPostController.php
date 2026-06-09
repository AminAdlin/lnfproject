<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Item;
use Illuminate\Http\Request;

class AdminPostController extends Controller
{
    public function index()
    {
        $items = Item::with('user')
                    ->latest()
                    ->paginate(20);

        return view('admin.posts.index', compact('items'));
    }

    public function delete($id)
    {
        $item = Item::findOrFail($id);

        $item->delete();

        return back()->with(
            'status',
            'Post deleted successfully.'
        );
    }

    public function superDelete($id)
    {
        $item = Item::withTrashed()
                    ->findOrFail($id);

        $item->forceDelete();

        return back()->with(
            'status',
            'Post permanently deleted.'
        );
    }
}
