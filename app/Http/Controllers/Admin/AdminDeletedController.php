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
}
