<?php

use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;

Route::post('do-payment', [PaymentController::class, 'doPayment']);
Route::post('refund', [PaymentController::class, 'refund']);
