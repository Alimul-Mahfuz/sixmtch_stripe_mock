<?php

namespace App\Contract\Payment;

interface PaymentContract
{
    function initiatePayment($card_number,$cvv,$exp,$name_on_card,$amount);
    function reversePayment($transaction_id,$amount);
}
