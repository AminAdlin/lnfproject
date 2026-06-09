<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::query()

            ->when(
                $request->student_id,
                fn($q) =>
                    $q->where(
                        'student_id',
                        'LIKE',
                        '%'.$request->student_id.'%'
                    )
            )

            ->when(
                $request->email,
                fn($q) =>
                    $q->where(
                        'email',
                        'LIKE',
                        '%'.$request->email.'%'
                    )
            )

            ->paginate(20);

        return view(
            'admin.users.index',
            compact('users')
        );
    }

    public function show($id)
    {
        $user = User::with([
            'items',
            'claims'
        ])->findOrFail($id);

        return view(
            'admin.users.show',
            compact('user')
        );
    }
}
