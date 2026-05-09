<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ClaimController;
use App\Http\Controllers\NotificationController;
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
    $totalLost    = \App\Models\Item::where('type', 'lost')->where('status', 'active')->count();
    $totalFound   = \App\Models\Item::where('type', 'found')->where('status', 'active')->count();
    $totalClaimed = \App\Models\Item::where('status', 'claimed')->orWhere('status', 'returned')->count();
    $recentItems  = \App\Models\Item::with('user')->orderBy('created_at', 'desc')->take(5)->get();
    $unreadCount  = \App\Models\Notification::where('receiver_id', auth()->id())->where('is_read', false)->count();

    return view('auth.dashboard', compact('totalLost', 'totalFound', 'totalClaimed', 'recentItems', 'unreadCount'));
})->middleware('auth');

// FOUND ITEM
Route::get('/post-found', [ItemController::class, 'showPostFoundForm'])->middleware('auth');
Route::post('/post-found', [ItemController::class, 'storeFound'])->middleware('auth');

// LOST ITEM
Route::get('/report-lost', [ItemController::class, 'showReportLostForm'])->middleware('auth');
Route::post('/report-lost', [ItemController::class, 'storeLost'])->middleware('auth');

// ALL ITEMS PAGE
Route::get('/items', [ItemController::class, 'allItems'])->middleware('auth');

// MARK AS RETURNED
Route::post('/items/{id}/returned', [ItemController::class, 'markReturned'])->middleware('auth');

// DELETE ITEM
Route::delete('/items/{id}', [ItemController::class, 'deleteItem'])->middleware('auth');

// CLAIM
Route::get('/items/{id}/claim', [ClaimController::class, 'showClaimForm'])->middleware('auth');
Route::post('/items/{id}/claim', [ClaimController::class, 'submitClaim'])->middleware('auth');
Route::get('/my-claims', [ClaimController::class, 'myClaims'])->middleware('auth');

// I FOUND THIS
Route::get('/items/{id}/found-this', [NotificationController::class, 'showFoundThisForm'])->middleware('auth');
Route::post('/items/{id}/found-this', [NotificationController::class, 'submitFoundThis'])->middleware('auth');
Route::get('/notifications', [NotificationController::class, 'myNotifications'])->middleware('auth');