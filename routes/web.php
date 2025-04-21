<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [WelcomeController::class, 'index'])->name('welcome');

Route::middleware('guest')->group(function () {
    Route::get('auth', [AuthenticationController::class, 'login'])->name('login');
    Route::post('auth', [AuthenticationController::class, 'doLogin'])->name('do_login');
});

Route::middleware('auth')->group(function () {
    Route::post('logout', [AuthenticationController::class, 'logout'])->name('logout');
    Route::prefix('module')->group(function () {
        Route::prefix('subscriptions')->group(function () {
            Route::get('/', [SubscriptionController::class, 'index'])->name('subscriptions.index');
            Route::post('cancel', [SubscriptionController::class, 'cancel'])->name('subscriptions.cancel');
        });
        Route::prefix('payment')->group(function () {
            Route::get('subscribe/{plan_id}', [PaymentController::class, 'subscribe'])->name('payment.subscribe');
            Route::post('do_subscribe', [PaymentController::class, 'doSubscribe'])->name('do_subscribe');
        });
    });

});
