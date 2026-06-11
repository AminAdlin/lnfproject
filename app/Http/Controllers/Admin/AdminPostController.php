<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Item;
use Illuminate\Http\Request;

class AdminPostController extends Controller {

public function index(Request $request)
{
    $type = $request->type; // all | lost | found

    $posts = Item::with('user');

    // FILTER LOGIC
    if ($type == 'lost') {
        $posts->where('type', 'lost');
    }

    if ($type == 'found') {
        $posts->where('type', 'found');
    }

    $posts = $posts->latest()->paginate(20);

    // STATS
    $totalAll = Item::count();
    $totalLost = Item::where('type', 'lost')->count();
    $totalFound = Item::where('type', 'found')->count();

    return view('admin.posts.index', compact(
        'posts',
        'totalAll',
        'totalLost',
        'totalFound',
        'type'
    ));
}

    public function show($id)
    {
        $post = Item::with('user')->findOrFail($id);

        return view('admin.posts.show', compact('post'));
    }

    public function toggleStatus($id)
    {
        return back()->with('status', 'Post status updated successfully.');
    }

    public function delete($id)
    {
        $post = Item::findOrFail($id);

        $post->deleted_by = auth()->user()->name;
        $post->save();

        $post->delete();

        return redirect()
            ->route('admin.posts')
            ->with('success', 'Post deleted successfully!'
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
