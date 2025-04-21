<?php

use App\Http\Controllers\MockStrip\PaymentController;
use App\Http\Middleware\StripeMock\AccessTokenVerificationMiddleware;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::post('do-payment', [PaymentController::class, 'doPayment']);
    Route::post('refund', [PaymentController::class, 'refund']);
})->middleware(['api']);
