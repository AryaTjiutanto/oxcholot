<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SubscriptionController;
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
});
