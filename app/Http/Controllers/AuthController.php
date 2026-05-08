<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'unique:users',
                'regex:/^[a-zA-Z0-9._%+-]+@(utm\.my|graduate\.utm\.my|utmspace\.edu\.my)$/'
            ],

            'password' => [
                'required',
                'string',
                'min:8',
                'max:16',
                'confirmed',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).+$/'
            ],
        ], [
            'email.regex' => 'Email must be @utm.my or @graduate.utm.my',
            'password.regex' => 'Password must include uppercase, lowercase, number and special character',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect('/email/verify');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {

            $user = Auth::user();

            

            // 3. redirect to dashboard
            return redirect($this->redirectToDashboard($user->role));
        }

        return back()->withErrors([
            'email' => 'Invalid login credentials'
        ]);
    }

    private function redirectToDashboard($role)
{
    if ($role === 'claimant') {
        return '/claimant/dashboard';
    }

    return '/finder/dashboard';
}
}