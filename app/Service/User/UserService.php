<?php

namespace App\Service\User;

use App\Contract\User\UserContract;
use App\Dto\User\UserCardDetailDTO;

class UserService
{
    function __construct(
        protected UserContract $userRepository
    )
    {
    }

    function getSubscriptionCount()
    {
        $user = auth()->user();
        return $this->userRepository->getActiveSubscriptionPlanByUserId($user->id)->subscriptions->count();
    }

    function updateCardInfo($data): void
    {
        $user = auth()->user();
        $cardInfo = [
            'card_number' => $data['card_number'],
            'exp' => $data['expiry_date'],
            'cvv' => $data['cvv'],
            'name_on_the_card' => $data['name_on_card'],
            'billing_address' => $data['billing_address'],
        ];

        $this->userRepository->updateCardInfo($user->id, $cardInfo);

    }

    function getCardInfoByUserId($userId): UserCardDetailDTO
    {
        $userCard = $this->userRepository->cardInfoByUserId($userId);
        return new UserCardDetailDTO($userCard->card_number, $userCard->exp, $userCard->cvv, $userCard->name_on_the_card, $userCard->billing_address);
    }
}
