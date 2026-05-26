<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ClaimController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfileController;

// ==========================================
// LANDING PAGE
// ==========================================
Route::get('/', function () {
    return view('welcome');
});

// ==========================================
// AUTHENTICATION SUITE (Guest & Auth)
// ==========================================
// Register
Route::get('/register', function () {
    return view('auth.register');
})->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// Login
Route::get('/login', function () {
    return view('auth.login');
})->name('login');
Route::post('/login', [LoginController::class, 'login']);

// Logout
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Forgot / Reset Password
Route::get('/forgot-password', [ForgotPasswordController::class, 'showForgotForm'])->name('password.request');
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLink'])->name('password.email');
Route::get('/reset-password/{token}', [ResetController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [ResetController::class, 'resetPassword'])->name('password.update');

// Email Verification
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function ($id, $hash) {
    $user = \App\Models\User::findOrFail($id);

    if (!hash_equals((string) $hash, sha1($user->getEmailForVerification()))) {
        abort(403);
    }

    if (!$user->hasVerifiedEmail()) {
        $user->markEmailAsVerified();
    }

    return view('auth.verified-success');
})->middleware('signed')->name('verification.verify');

Route::get('/email/verified-success', function () {
    return view('auth.verified-success');
})->middleware('auth');

Route::post('/email/verification-notification', function (Request $request) {
    if ($request->user()) {
        $request->user()->sendEmailVerificationNotification();
    }
    return back()->with('message', 'Verification link sent!');
})->middleware(['auth'])->name('verification.send');


// ==========================================
// CORE APPLICATION ROUTES (Protected by 'auth')
// ==========================================
Route::middleware(['auth'])->group(function () {

    // 1. Dashboard Dashboard
    Route::get('/dashboard', function () {
        $totalLost    = \App\Models\Item::where('type', 'lost')->where('status', 'active')->count();
        $totalFound   = \App\Models\Item::where('type', 'found')->where('status', 'active')->count();
        $totalClaimed = \App\Models\Item::where('status', 'claimed')->orWhere('status', 'returned')->count();
        $recentItems  = \App\Models\Item::with('user')->orderBy('created_at', 'desc')->take(5)->get();
        $unreadCount  = \App\Models\Notification::where('receiver_id', auth()->id())->where('is_read', false)->count();
        return view('auth.dashboard', compact('totalLost', 'totalFound', 'totalClaimed', 'recentItems', 'unreadCount'));
    });

// 2. Item Management (Lost & Found)
    Route::get('/items', [ItemController::class, 'allItems']);
    Route::get('/post-found', [ItemController::class, 'showPostFoundForm']);
    Route::post('/post-found', [ItemController::class, 'storeFound']);
    Route::get('/report-lost', [ItemController::class, 'showReportLostForm']);
    Route::post('/report-lost', [ItemController::class, 'storeLost']);
    Route::post('/items/{id}/appointment', [\App\Http\Controllers\ClaimController::class, 'storeAppointment'])->name('items.appointment');

    Route::delete('/items/{id}', [ItemController::class, 'deleteItem'])->name('item.delete');
    
    // KAWALAN UTAMAl DOUBLE CONFIRMATION FLOW
    Route::post('/items/{id}/returned', [ItemController::class, 'markReturned'])->name('items.returned');
    Route::post('/items/{id}/received', [ItemController::class, 'markReceived'])->name('items.received');
    Route::post('/items/{id}/dispute', [ItemController::class, 'reportDispute']);
    // 3. Claim Processing & Security Verification
    Route::get('/items/{id}/claim', [ClaimController::class, 'showClaimForm']);
    Route::post('/items/{id}/check-answer', [ClaimController::class, 'checkSecurityAnswer']); // AJAX Security Check
    Route::post('/items/{id}/claim', [ClaimController::class, 'submitClaim']);
    Route::get('/my-claims', [ClaimController::class, 'myClaims']);

    // 4. Finder Claims Inbox (Reviewing Received Claims)
    Route::get('/finder-claims', [ClaimController::class, 'finderClaims'])->name('claims.inbox');
    Route::post('/claims/{id}/approve', [ClaimController::class, 'approveClaim'])->name('claims.approve');
    Route::post('/claims/{id}/reject', [ClaimController::class, 'rejectClaim'])->name('claims.reject');

    // 5. Payment / Delivery Bank Receipt Upload
    Route::get('/claims/{id}/payment', [ClaimController::class, 'showPayment'])->name('claim.payment');
    Route::post('/claims/{id}/payment', [ClaimController::class, 'processPayment']);

    // 6. "I Found This" Interactive Notifications
    Route::get('/items/{id}/found-this', [NotificationController::class, 'showFoundThisForm']);
    Route::post('/items/{id}/found-this', [NotificationController::class, 'submitFoundThis']);
    Route::get('/notifications', [NotificationController::class, 'myNotifications']);

    // 7. User Profile Management
    Route::get('/profile', [ProfileController::class, 'showProfile']);
    Route::post('/profile/update', [ProfileController::class, 'updateProfile']);
    Route::post('/profile/password', [ProfileController::class, 'updatePassword']);

    // 8. Finder to Owner Logic
    Route::get('/items/{id}/found-this', [\App\Http\Controllers\ClaimController::class, 'showFoundThisForm'])->name('items.found-this');
    Route::post('/items/{id}/found-this', [\App\Http\Controllers\ClaimController::class, 'submitFoundThis']);
    Route::post('/claims/{id}/approve', [ClaimController::class, 'approve'])->middleware('auth');
    Route::post('/claims/{id}/reject', [ClaimController::class, 'reject'])->middleware('auth');
    Route::post('/items/{id}/submit-address', [ItemController::class, 'submitAddress'])->middleware('auth');
    Route::post('/items/{id}/submit-tracking', [ItemController::class, 'submitTracking'])->middleware('auth');
});