<?php

namespace App\Contract\User;

use App\Models\SubscriptionPlan;

interface UserContract
{
    function getUserById($id);

    function getActiveSubscriptionPlanByUserId($userId);

    function updateCardInfo($userId, $cardInfo);
}
