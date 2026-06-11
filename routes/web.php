<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ClaimController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\DisputeController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminPostController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminReportController;
use App\Http\Controllers\Admin\AdminDisputeController;
use App\Http\Controllers\Admin\AdminClaimedController;
use App\Http\Controllers\Admin\AdminDeletedController;

// ── Landing ───────────────────────────────────────────────────────────────────
Route::get('/', fn() => view('welcome'));

// ── Auth (guest) ──────────────────────────────────────────────────────────────
Route::get('/register',  fn() => view('auth.register'))->name('register');
Route::post('/register', [RegisterController::class, 'register']);

Route::get('/login',  fn() => view('auth.login'))->name('login');
Route::post('/login', [LoginController::class, 'login']);

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/forgot-password',  [ForgotPasswordController::class, 'showForgotForm'])->name('password.request');
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLink'])->name('password.email');
Route::get('/reset-password/{token}', [ResetController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password',        [ResetController::class, 'resetPassword'])->name('password.update');

// Email verification
Route::get('/email/verify', fn() => view('auth.verify-email'))->middleware('auth')->name('verification.notice');

// TOYYIB
Route::post('/claims/{id}/payment/callback', [PaymentController::class, 'callback'])->name('payment.callback');

Route::get('/email/verify/{id}/{hash}', function ($id, $hash) {
    $user = \App\Models\User::findOrFail($id);
    if (!hash_equals((string) $hash, sha1($user->getEmailForVerification()))) abort(403);
    if (!$user->hasVerifiedEmail()) $user->markEmailAsVerified();
    return view('auth.verified-success');
})->middleware('signed')->name('verification.verify');

Route::get('/email/verified-success', fn() => view('auth.verified-success'))->middleware('auth');

Route::post('/email/verification-notification', function (Request $request) {
    if ($request->user()) $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Verification link sent!');
})->middleware('auth')->name('verification.send');

// ── Protected ─────────────────────────────────────────────────────────────────
Route::middleware('auth')->group(function () {

    // Dashboard
    Route::get('/dashboard', function () {
        $totalLost    = \App\Models\Item::where('type', 'lost')->where('status', 'active')->count();
        $totalFound   = \App\Models\Item::where('type', 'found')->where('status', 'active')->count();
        $totalClaimed = \App\Models\Item::whereIn('status', ['claimed', 'returned'])->count();
        $recentItems  = \App\Models\Item::with('user')->latest()->take(5)->get();
        $unreadCount  = \App\Models\Notification::where('receiver_id', auth()->id())->where('is_read', false)->count();
        return view('auth.dashboard', compact('totalLost', 'totalFound', 'totalClaimed', 'recentItems', 'unreadCount'));
    });

    // Items
    Route::get('/items',       [ItemController::class, 'allItems']);
    Route::get('/post-found',  [ItemController::class, 'showPostFoundForm']);
    Route::post('/post-found', [ItemController::class, 'storeFound']);
    Route::get('/report-lost', [ItemController::class, 'showReportLostForm']);
    Route::post('/report-lost',[ItemController::class, 'storeLost']);
    Route::delete('/items/{id}', [ItemController::class, 'deleteItem'])->name('item.delete');

    // ── SCENARIO A — Found Post (Amin found → Azri claims) ───────────────────
    // 1. Owmer views claim form
    Route::get('/items/{id}/claim', [ClaimController::class, 'showClaimForm']);
    // 2. AJAX security answer check
    Route::post('/items/{id}/check-answer', [ClaimController::class, 'checkSecurityAnswer']);
    // 3. Owner submits claim (auto-approved, redirects to payment OR sends pickup email)
    Route::post('/items/{id}/claim', [ClaimController::class, 'submitClaim']);

    // 4. Delivery: Owner views payment page
    Route::get('/claims/{id}/payment', [ClaimController::class, 'showPayment'])->name('claim.payment');
    // 5. Delivery: Owner uploads receipt → emails Amin
    Route::post('/claims/{id}/upload-receipt', [ClaimController::class, 'uploadReceipt'])->name('claims.uploadReceipt');

    // 6. Pickup: Finder sets appointment → emails Azri
    Route::post('/items/{id}/appointment', [ClaimController::class, 'storeAppointment'])->name('items.appointment');

    // 7. Finder marks item as returned/shipped
    Route::post('/items/{id}/returned', [ClaimController::class, 'markReturnedByFinder'])->name('items.markReturned');
    // 8. Owner confirms receipt → Case Closed
    Route::post('/items/{id}/received', [ClaimController::class, 'confirmItemReceived'])->name('items.confirmReceived');

    // Dispute
    Route::post('/items/{id}/dispute', [DisputeController::class, 'store'])->name('items.dispute');

    // ── SCENARIO B — Lost Post (Azri lost → Amin found it) ───────────────────
    // Amin submits "I Found This" with proof image
    Route::get('/items/{id}/found-this',  [ClaimController::class, 'showFoundThisForm'])->name('items.found-this');
    Route::post('/items/{id}/found-this', [ClaimController::class, 'submitFoundThis']);
    // Azri (post owner) approves/rejects Amin's claim
    Route::post('/claims/{id}/approve', [ClaimController::class, 'approveClaim'])->name('claims.approve');
    Route::post('/claims/{id}/reject',  [ClaimController::class, 'rejectClaim'])->name('claims.reject');

    // ── Dashboards ────────────────────────────────────────────────────────────
    Route::get('/finder-claims', [ClaimController::class, 'finderClaims'])->name('claims.inbox');
    Route::get('/my-claims',     [ClaimController::class, 'myClaims']);

    // Notifications (owner's inbox for Scenario B "I Found This" messages)
    Route::get('/notifications', [NotificationController::class, 'myNotifications']);

    // Profile
    Route::get('/profile',          [ProfileController::class, 'showProfile']);
    Route::post('/profile/update',  [ProfileController::class, 'updateProfile']);
    Route::post('/profile/password',[ProfileController::class, 'updatePassword']);

    // REPORT
    Route::post('/items/{id}/report', [ReportController::class, 'store'])->name('items.report');

    // TOYYIB 
    Route::post('/claims/{id}/pay-online', [PaymentController::class, 'createBill'])->name('payment.create');
    Route::get('/claims/{id}/payment/return', [PaymentController::class, 'returnUrl'])->name('payment.return');

    // REPORT DISPUTE
    Route::post('/items/{id}/dispute', [DisputeController::class, 'store'])->name('items.dispute');

    // ── Admin Routes ──────────────────────────────────────────────
    Route::middleware(['auth', 'admin'])
        ->prefix('admin')
        ->group(function () {

        Route::get('/dashboard', [AdminDashboardController::class, 'index'])
            ->name('admin.dashboard');

        // Posts Management
        Route::get('/posts', [AdminPostController::class, 'index'])
            ->name('admin.posts');

        Route::get('/posts/{id}', [AdminPostController::class, 'show'])
            ->name('admin.posts.show');

        Route::post('/posts/{id}/delete', [AdminPostController::class, 'delete'])
            ->name('admin.posts.delete');

        Route::post('/posts/{id}/toggle-status', [AdminPostController::class, 'toggleStatus'])
            ->name('admin.posts.toggle');

        Route::delete('/posts/{id}/force', [AdminPostController::class, 'superDelete'])
            ->name('admin.posts.forceDelete');

        // USERS 
        Route::get('/users', [AdminUserController::class, 'index'])
            ->name('admin.users');

        Route::get('/users/{id}', [AdminUserController::class, 'show'])
            ->name('admin.users.show');

        Route::delete('/users/{id}', [AdminUserController::class, 'destroy'])
            ->name('admin.users.delete');

        Route::get('/users/{id}/ban', [AdminUserController::class, 'ban'])
            ->name('admin.users.ban');

        Route::get('/users/{id}/unban', [AdminUserController::class, 'unban'])
            ->name('admin.users.unban');

        // REPORTS
        Route::get('/reports', [AdminReportController::class, 'index']);

        Route::post('/reports/{id}/review', [AdminReportController::class, 'review']);

        // DISPUTES
        Route::get('/disputes', [AdminDisputeController::class, 'index']);

        Route::get('/disputes/{id}', [AdminDisputeController::class, 'show']);

        Route::post('/disputes/{id}/resolve', [AdminDisputeController::class, 'resolve']);

        Route::get('/claimed', [AdminClaimedController::class, 'index'])
            ->name('admin.claimed');

        Route::get('/deleted', [AdminDeletedController::class, 'index'])
            ->name('admin.deleted');
    });
});