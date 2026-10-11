<?php

use App\Http\Controllers\PaypalWebhookController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Cashier\Http\Controllers\WebhookController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/stripe/webhook', [WebhookController::class, 'handleWebhook']);
Route::post('/paypal/webhook', [PaypalWebhookController::class, 'handleWebhook']);