<?php

namespace App\Repositories\UserSubscription;

use App\Contract\UserSubscription\UserSubscriptionContract;
use App\Models\SubscriptionUser;

class UserSubscriptionRepository implements UserSubscriptionContract
{

    function create($data)
    {
        return SubscriptionUser::query()->create($data);
    }

    function getUserSubscription($userId): \Illuminate\Database\Eloquent\Collection
    {
        return SubscriptionUser::query()->with('subscription_plans')->where('user_id', $userId)->orderBy('id', 'DESC')->get();
    }

    function getUserSubscriptionById($subscriptionId)
    {
        return SubscriptionUser::query()->where('is_active', true)->where('id', $subscriptionId)->first();
    }

    function cancelSubscription($subscriptionId): int
    {
        return SubscriptionUser::query()->where('is_active', true)->where('id', $subscriptionId)->update(['is_active' => false]);
    }

    function getRenewableSubscriptions(): \Illuminate\Database\Eloquent\Collection
    {
        return SubscriptionUser::query()
            ->with('subscription_plans')
            ->where('is_active', true)
            ->where('is_autorenew', true)
            ->orderBy('id', 'DESC')
            ->get();
    }

    function updateUserSubscription($userSubscriptionId,$expiresDate): int
    {
       return SubscriptionUser::query()
           ->where('is_active', true)
           ->where('id', $userSubscriptionId)
           ->update([
               'expires_at' => $expiresDate,
           ]);
    }
}
