<?php

namespace App\Repositories\User;

use App\Contract\User\UserContract;
use App\Models\User;

class UserRepository implements UserContract
{

    function getUserById($id)
    {
        // TODO: Implement getUserById() method.
    }

    function getActiveSubscriptionPlanByUserId($userId)
    {
        return User::query()->with(['subscriptions' => function ($query) {
            $query->where('expired_at', '>=', now()->toDateTimeString())
                ->where('is_active', true);
        }])->where('id', $userId)
            ->first();
    }

    function updateCardInfo($userId, $cardInfo)
    {
        return User::query()->where('id', $userId)->update($cardInfo);
    }

    function cardInfoByUserId($userId){
        return User::query()
            ->select('card_number','name_on_the_card','exp','billing_address','cvv')
            ->where('id', $userId)
            ->first();
    }
}
