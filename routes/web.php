<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

Route::get('/', function () {
    return view('welcome');
});

// REGISTER
Route::get('/register', function () {
    return view('auth.register');
})->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// LOGIN
Route::get('/login', function () {
    return view('auth.login');
})->name('login');
Route::post('/login', [LoginController::class, 'login']);

// LOGOUT
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// FORGOT PASSWORD
Route::get('/forgot-password', [ForgotPasswordController::class, 'showForgotForm'])->name('password.request');
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLink'])->name('password.email');
Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [ResetPasswordController::class, 'resetPassword'])->name('password.update');

// EMAIL VERIFICATION
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $user = Auth::user();
    if ($user->hasVerifiedEmail()) {
        return redirect('/dashboard');
    }
    $user->markEmailAsVerified();
    return redirect('/dashboard');
})->middleware(['signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    if ($request->user()) {
        $request->user()->sendEmailVerificationNotification();
    }
    return back()->with('message', 'Verification link sent!');
})->middleware(['auth'])->name('verification.send');

// DASHBOARD
Route::get('/dashboard', function () {
    return view('auth.dashboard', [
        'totalLost' => 0,
        'totalFound' => 0,
        'totalClaimed' => 0,
        'recentItems' => collect([]),
    ]);
})->middleware('auth');