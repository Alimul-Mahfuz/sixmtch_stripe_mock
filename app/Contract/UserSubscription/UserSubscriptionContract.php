<?php

namespace App\Contract\UserSubscription;

use App\Models\SubscriptionPlan;

interface UserSubscriptionContract
{
    function create($data);

    function getUserSubscription($userId);

    function getUserSubscriptionById($subscriptionId);

    function cancelSubscription($subscriptionId);

    function getRenewableSubscriptions();

    function updateUserSubscription($userSubscriptionId, $expiresDate);

}
