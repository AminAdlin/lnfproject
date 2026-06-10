<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;

        $users = User::where('role', 'user')
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'LIKE', "%{$search}%")
                      ->orWhere('student_id', 'LIKE', "%{$search}%");
                });
            })
            ->paginate(10);
        return view('admin.users', compact('users'));
}

    public function show($id)
    {
        $user = User::with([
            'items',
            'claims'
        ])->findOrFail($id);

        return view('admin.users.show', compact('user'));
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete(); // soft delete

        return redirect()->back()
            ->with('success', 'User deleted successfully');
    }

    public function ban($id)
    {
        $user = User::findOrFail($id);

        $user->is_banned = true;
        $user->save();

        return back()->with('success', 'User has been banned');
    }

    public function unban($id)
    {
        $user = User::findOrFail($id);

        $user->is_banned = false;
        $user->save();

        return back()->with('success', 'User has been unbanned');
    }
}