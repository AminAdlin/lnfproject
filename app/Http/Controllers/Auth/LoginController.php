<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => [
                'required',
                'email',
                function ($attribute, $value, $fail) {
                    if ($value === 'adminfoundit3@gmail.com') {
                        return;
                    }

        if (
            !str_ends_with($value, '@utm.my') &&
            !str_ends_with($value, '@graduate.utm.my') &&
            !str_ends_with($value, '@utmspace.edu.my')
        ) {
            $fail('Email must be @utm.my, @graduate.utm.my or @utmspace.edu.my');
        }
    }
],
            'password' => 'required|string',
        ]);

        $credentials = $request->only('email', 'password');
        $remember = $request->boolean('remember');

        if (!Auth::attempt($credentials, $remember)) {
            throw ValidationException::withMessages([
                'email' => 'These credentials do not match our records.',
            ]);
        }

        if (!Auth::user()->hasVerifiedEmail()) {
            Auth::logout();
            return back()->withErrors([
            'email' => 'Please verify your email before login.',
        ]);
    }
    
        $request->session()->regenerate();

        if (Auth::user()->role === 'admin') {
            return redirect('/admin/dashboard');
        }

        return redirect()->intended('/dashboard');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}