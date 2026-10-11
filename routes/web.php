<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PaypalController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
})->name('homepage');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::post('/subscription/checkout', [SubscriptionController::class, 'checkout'])->name('subscription.checkout');
    Route::get('/subscription/checkout/cancel', [SubscriptionController::class, 'cancelCheckout'])->name('subscription.checkout.cancel');
    Route::post('/subscription/cancel', [SubscriptionController::class, 'cancel'])->name('subscription.cancel');
    Route::post('/subscription/resume', [SubscriptionController::class, 'resume'])->name('subscription.resume');
    Route::post('/subscription/swap', [SubscriptionController::class, 'swap'])->name('subscription.swap');

    Route::post('/paypal/payment', [PaypalController::class, 'handlePayment'])->name('paypal.payment');
    Route::get('/paypal/success', [PaypalController::class, 'success'])->name('paypal.success');
    Route::get('/paypal/cancel', [PaypalController::class, 'cancel'])->name('paypal.cancel');
});

Route::get('/market', [ProductController::class, 'index'])->name('product.index');

Route::get('/market/{product:slug}', [SubscriptionController::class, 'show'])->name('product.show');
