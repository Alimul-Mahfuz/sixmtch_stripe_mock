<?php

namespace App\Http\Controllers\MockStrip;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PaymentController extends Controller
{

    /**
     * For failed payment use card_no: 1234 4568 1234 1121 1314
     * card_expiry: 05/27 and card_cvv: 4563
     *
     */


    function doPayment(Request $request): \Illuminate\Http\JsonResponse
    {
        $validation = Validator::make($request->all(), [
            'card_number' => 'required',
            'card_expiry' => 'required',
            'card_cvv' => 'required',
            'amount' => 'required',
        ]);
        if ($validation->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validation->errors()
            ]);
        }
        $status = $this->verifyPayment($request->input('card_number'), $request->input('card_expiry'), $request->input('card_cvv'));
        if ($status) {
            return response()->json([
                'success' => true,
                'transaction_id' => rand(12545, 999999) . "DBDCIDEKD",
                'type' => 'payment',
            ]);
        }
        return response()->json([
            'success' => false,
        ]);
    }


    /**
     * @param $cardNumber
     * @param $cardExpiry
     * @param $cardCvv
     * @return bool
     *
     * Simulate card verification form Bank
     */
    function verifyPayment($cardNumber, $cardExpiry, $cardCvv): bool
    {
        if ($cardNumber == "12344568123411211314") {
            return false;
        }
        return true;
    }

    function refund(Request $request): \Illuminate\Http\JsonResponse
    {
        $validation = Validator::make($request->all(), [
            'amount' => 'required',
            'transaction_id' => 'required',
        ]);

        if ($validation->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validation->errors()
            ]);
        }

        return response()->json([
            'success' => false,
//            'transaction_id' => rand(12545, 999999) . "IKDIEKD",
            'type' => 'refund',
        ]);
    }
}
