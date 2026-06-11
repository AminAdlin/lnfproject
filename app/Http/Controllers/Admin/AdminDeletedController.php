<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Item;

class AdminDeletedController extends Controller
{
    public function index()
    {
        $deletedItems = Item::onlyTrashed()
            ->latest()
            ->get();

        return view('admin.deleted.index', compact('deletedItems'));
    }

    public function show($id)
    {
        $item = Item::onlyTrashed()->findOrFail($id);

        return view(
            'admin.deleted.show',
            compact('item')
        );
    }

    public function restore($id)
    {
        $item = Item::onlyTrashed()->findOrFail($id);

        $item->restore();

        return redirect()
            ->route('admin.deleted')
            ->with('success','Post restored successfully!');
    }
}
