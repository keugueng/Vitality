<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ConsultationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProController;
use App\Http\Controllers\ShopController;
use Illuminate\Support\Facades\Route;

/* ─── Locale Switch ─── */
Route::get('/set-locale/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'fr'])) {
        session(['locale' => $locale]);
        app()->setLocale($locale);
    }
    return redirect()->back();
})->name('locale.switch');

/* ─── Public Pages ─── */
Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/consultation', [PageController::class, 'consultation'])->name('consultation');
Route::get('/legal-notice', [PageController::class, 'legalNotice'])->name('legal-notice');
Route::get('/my-program', [PageController::class, 'myProgram'])->name('my-program');
Route::post('/consultation', [ConsultationController::class, 'store'])->name('consultation.store');

/* ─── Blog ─── */
Route::get('/blog', [PageController::class, 'blog'])->name('blog');
Route::get('/blog/{post:slug}', [PageController::class, 'blogShow'])->name('blog.show');

/* ─── Shop ─── */
Route::get('/shop', [ShopController::class, 'index'])->name('shop');
Route::get('/shop/{program:slug}', [ShopController::class, 'show'])->name('shop.show');

/* ─── Cart ─── */
Route::prefix('cart')->name('cart.')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::post('/add', [CartController::class, 'add'])->name('add');
    Route::post('/add-consultation', [CartController::class, 'addConsultation'])->name('add-consultation');
    Route::post('/add-subscription', [CartController::class, 'addSubscription'])->name('add-subscription');
    Route::post('/remove', [CartController::class, 'remove'])->name('remove');
    Route::post('/update', [CartController::class, 'update'])->name('update');
    Route::post('/clear', [CartController::class, 'clear'])->name('clear');
});

/* ─── Checkout ─── */
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
Route::post('/checkout', [CheckoutController::class, 'process'])->name('checkout.process');
Route::get('/checkout/success/{order}', [CheckoutController::class, 'success'])->name('checkout.success');

/* ─── Auth ─── */
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('password.request');
});
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

/* ─── Notifications ─── */
Route::middleware('auth')->prefix('notifications')->name('notifications.')->group(function () {
    Route::get('/', [NotificationController::class, 'index'])->name('index');
    Route::get('/count', [NotificationController::class, 'unreadCount'])->name('count');
    Route::post('/{id}/read', [NotificationController::class, 'markRead'])->name('read');
    Route::post('/read-all', [NotificationController::class, 'markAllRead'])->name('read-all');
});

/* ─── User Dashboard ─── */
Route::middleware('auth')->prefix('dashboard')->name('dashboard')->group(function () {
    Route::get('/', [DashboardController::class, 'index']);
    Route::get('/profile', [DashboardController::class, 'profile'])->name('.profile');
    Route::put('/profile', [DashboardController::class, 'updateProfile'])->name('.profile.update');
    Route::get('/orders', [DashboardController::class, 'orders'])->name('.orders');
});

/* ─── Subscriptions ─── */
Route::get('/subscribe', [SubscriptionController::class, 'index'])->name('subscribe');
Route::middleware('auth')->group(function () {
    Route::post('/subscribe', [SubscriptionController::class, 'store'])->name('subscribe.store');
    Route::post('/subscribe/cancel', [SubscriptionController::class, 'cancel'])->name('subscribe.cancel');
});

/* ─── PRO Space ─── */
Route::get('/pro', [ProController::class, 'index'])->name('pro');
Route::middleware(['auth'])->prefix('pro')->name('pro.')->group(function () {
    Route::get('/dashboard', [ProController::class, 'dashboard'])->name('dashboard');
    Route::get('/patients', [ProController::class, 'patients'])->name('patients');
    Route::get('/protocols', [ProController::class, 'protocols'])->name('protocols');
    Route::post('/patients', [ProController::class, 'storePatient'])->name('patients.store');
    Route::post('/protocols', [ProController::class, 'assignProtocol'])->name('protocols.assign');
    Route::put('/protocols/{protocol}', [ProController::class, 'updateProtocol'])->name('protocols.update');
    Route::delete('/patients/{patient}', [ProController::class, 'destroyPatient'])->name('patients.destroy');
});

/* ─── Admin Panel ─── */
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/analytics', [AdminController::class, 'analytics'])->name('analytics');

    Route::get('/programs', [AdminController::class, 'programs'])->name('programs');
    Route::post('/programs', [AdminController::class, 'storeProgram'])->name('programs.store');
    Route::put('/programs/{program}', [AdminController::class, 'updateProgram'])->name('programs.update');
    Route::delete('/programs/{program}', [AdminController::class, 'destroyProgram'])->name('programs.destroy');

    Route::get('/categories', [AdminController::class, 'categories'])->name('categories');
    Route::post('/categories', [AdminController::class, 'storeCategory'])->name('categories.store');
    Route::put('/categories/{category}', [AdminController::class, 'updateCategory'])->name('categories.update');
    Route::delete('/categories/{category}', [AdminController::class, 'destroyCategory'])->name('categories.destroy');

    Route::get('/orders', [AdminController::class, 'orders'])->name('orders');
    Route::get('/consultations', [AdminController::class, 'consultations'])->name('consultations');
    Route::put('/consultations/{consultation}', [AdminController::class, 'updateConsultation'])->name('consultations.update');

    Route::get('/blog', [AdminController::class, 'blogPosts'])->name('blog');
    Route::post('/blog', [AdminController::class, 'storeBlogPost'])->name('blog.store');
    Route::put('/blog/{post}', [AdminController::class, 'updateBlogPost'])->name('blog.update');
    Route::delete('/blog/{post}', [AdminController::class, 'destroyBlogPost'])->name('blog.destroy');

    Route::get('/testimonials', [AdminController::class, 'testimonials'])->name('testimonials');
    Route::post('/testimonials', [AdminController::class, 'storeTestimonial'])->name('testimonials.store');
    Route::delete('/testimonials/{testimonial}', [AdminController::class, 'destroyTestimonial'])->name('testimonials.destroy');

    Route::get('/notifications', [AdminController::class, 'notifications'])->name('notifications');
    Route::post('/notifications', [AdminController::class, 'sendNotification'])->name('notifications.send');
    Route::delete('/notifications/{notification}', [AdminController::class, 'deleteNotification'])->name('notifications.destroy');
    Route::get('/subscriptions', [AdminController::class, 'subscriptions'])->name('subscriptions');

    Route::get('/audio', [AdminController::class, 'audioFiles'])->name('audio');
    Route::post('/audio', [AdminController::class, 'storeAudioFile'])->name('audio.store');
    Route::put('/audio/{audioFile}', [AdminController::class, 'updateAudioFile'])->name('audio.update');
    Route::delete('/audio/{audioFile}', [AdminController::class, 'destroyAudioFile'])->name('audio.destroy');

    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::get('/symptom-stats', [AdminController::class, 'symptomStats'])->name('symptom-stats');
    Route::get('/admins', [AdminController::class, 'admins'])->name('admins');
    Route::get('/pricing', [AdminController::class, 'pricing'])->name('pricing');
    Route::get('/settings', [AdminController::class, 'settings'])->name('settings');
    Route::post('/settings', [AdminController::class, 'updateSettings'])->name('settings.update');
    Route::get('/payment-settings', [AdminController::class, 'paymentSettings'])->name('payment-settings');
    Route::post('/payment-settings', [AdminController::class, 'updatePaymentSettings'])->name('payment-settings.update');
});
