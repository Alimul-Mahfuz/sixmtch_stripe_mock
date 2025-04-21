<?php

namespace App\Contract\User;

use App\Dto\Transaction\CreateUserTransactionDTO;

interface UserTransactionContract
{
    function createUserTransaction(CreateUserTransactionDTO $createUserTransactionDTO);
    function getTransactionByTransactionId(string $transactionId);

}
