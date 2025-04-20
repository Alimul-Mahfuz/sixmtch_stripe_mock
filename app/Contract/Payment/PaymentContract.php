<?php

namespace App\Contract\Payment;

interface PaymentContract
{
    function initiatePayment();
    function reversePayment();
}
