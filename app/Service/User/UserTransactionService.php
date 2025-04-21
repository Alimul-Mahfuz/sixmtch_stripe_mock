<?php

namespace App\Service\User;

use App\Contract\User\UserTransactionContract;
use App\Dto\Transaction\CreateUserTransactionDTO;

class UserTransactionService
{
    function __construct(
        protected UserTransactionContract $userTransactionRepository
    )
    {
    }

    function create(CreateUserTransactionDTO $createUserTransactionDTO)
    {
        return $this->userTransactionRepository->createUserTransaction($createUserTransactionDTO);
    }

    function getTransactionByTransactionId(string $transactionId)
    {
        return $this->userTransactionRepository->getTransactionByTransactionId($transactionId);
    }
}
