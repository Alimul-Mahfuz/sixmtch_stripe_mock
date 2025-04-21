<?php

namespace App\Dto\Transaction;

class CreateUserTransactionDTO
{
    public function __construct(
        public int $user_id,
        public string $transaction_id,
        public int $subscription_id,
        public string $payment_type,
        public float $amount,
        public bool $is_successful
    ) {}

    function toArray(): array{
        return [
            'user_id' => $this->user_id,
            'transaction_id' => $this->transaction_id,
            'subscription_id' => $this->subscription_id,
            'payment_type' => $this->payment_type,
            'amount' => $this->amount,
            'is_successful' => $this->is_successful,
        ];
    }

}
