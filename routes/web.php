<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\RoleController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

Route::get('/', function () {
    return view('welcome');
});

// REGISTER
Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::post('/register', [App\Http\Controllers\AuthController::class, 'register']);

// LOGIN VIEW (if you use blade login page)
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

// Show verify page
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

// FIXED: correct signature for EmailVerificationRequest
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {

    $user = Auth::user();

    if ($user->hasVerifiedEmail()) {
        return redirect('/choose-role');
    }

    $user->markEmailAsVerified();

    return redirect('/choose-role');

})->middleware(['signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Illuminate\Http\Request $request) {
    if ($request->user()) {
        $request->user()->sendEmailVerificationNotification();
    }

    return back()->with('message', 'Verification link sent!');
})->middleware(['auth'])->name('verification.send');

Route::middleware('auth')->group(function () {

    Route::get('/choose-role', [RoleController::class, 'showChooseRole']);

    Route::post('/choose-role', [RoleController::class, 'saveRole']);
});

Route::get('/dashboard', function () {

    $user = auth()->user();

    if (!$user) {
        return redirect('/login');
    }

    if (!$user->role) {
        return redirect('/choose-role');
    }

    if ($user->role === 'claimant') {
        return redirect('/claimant/dashboard');
    }

    return redirect('/finder/dashboard');

})->middleware('auth');

Route::get('/claimant/dashboard', function () {
    return view('claimant.dashboard');
})->middleware('auth');

Route::get('/finder/dashboard', function () {
    return view('finder.dashboard');
})->middleware('auth');