<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    public function showForgotForm()
    {
        return view('auth.forgot-password');    
    }

    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => [
                'required',
                'email',
                'regex:/^[a-zA-Z0-9._%+-]+@(utm\.my|graduate\.utm\.my|utmspace\.edu\.my)$/'
            ],
        ], [
            'email.regex' => 'Email must be @utm.my, @graduate.utm.my or @utmspace.edu.my',
        ]);

        $status = Password::sendResetLink($request->only('email'));

        return $status === Password::RESET_LINK_SENT
            ? back()->with('status', 'Reset link sent! Please check your email.')
            : back()->withErrors(['email' => 'We could not find a user with that email address.']);
    }
}