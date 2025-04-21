<?php

namespace App\Repositories\User;

use App\Contract\User\UserTransactionContract;
use App\Dto\Transaction\CreateUserTransactionDTO;
use App\Models\UserTransaction;

class UserTransactionRepository implements UserTransactionContract
{

    function createUserTransaction(CreateUserTransactionDTO $createUserTransactionDTO)
    {
        return UserTransaction::query()->create($createUserTransactionDTO->toArray());
    }

    function getTransactionByTransactionId(string $transactionId)
    {
        return UserTransaction::query()->where('is_successful', true)->where('transaction_id', $transactionId)->first();
    }
}
