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
}
