<?php

namespace App\Contract\UserSubscription;

use App\Models\SubscriptionPlan;

interface UserSubscriptionContract
{
    function create($data);

}
