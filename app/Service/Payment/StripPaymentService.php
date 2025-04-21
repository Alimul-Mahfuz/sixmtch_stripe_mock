<?php

namespace App\Service\Payment;

use App\Contract\Payment\PaymentContract;
use App\Http\Controllers\MockStrip\PaymentController;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Request;

class StripPaymentService implements PaymentContract
{

    /**
     * @throws ConnectionException
     */

    function initiatePayment($card_number, $cvv, $exp, $name_on_card, $amount)
    {
        $fakeRequest = Request::create('/api/mock-payment', 'POST', [
            'card_number' => $card_number,
            'card_expiry' => $exp,
            'card_cvv' => $cvv,
            'name_on_card' => $name_on_card,
            'amount' => $amount,
        ]);

        $controller = app(PaymentController::class);
        $response = $controller->doPayment($fakeRequest);

        return $response->getContent();
    }

    function reversePayment($transaction_id, $amount)
    {
        $fakeRequest = Request::create('/api/mock-payment', 'POST', [
            'transaction_id' => $transaction_id,
            'amount' => $amount,
        ]);
        $controller = app(PaymentController::class);
        $response = $controller->refund($fakeRequest);
        return $response->getContent();
    }
}
