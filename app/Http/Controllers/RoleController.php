<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function showChooseRole()
    {
        return view('auth.choose-role');
    }

    public function save(Request $request)
    {
        $request->validate([
            'role' => 'required|in:finder,claimant'
        ]);

        $user = Auth::user();

        $user->role = $request->role;
        $user->save();

        return redirect('/dashboard');
    }
}