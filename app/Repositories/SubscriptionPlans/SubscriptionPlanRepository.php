<?php

namespace App\Repositories\SubscriptionPlans;

use App\Contract\SubscriptionPlan\SubscriptionPlanContract;
use App\Models\SubscriptionPlan;

class SubscriptionPlanRepository implements SubscriptionPlanContract
{

    function getAllPlans(): \Illuminate\Database\Eloquent\Collection
    {
        return SubscriptionPlan::all();
    }

    function getPlanById($planId)
    {
       return SubscriptionPlan::query()->findOrFail($planId);
    }
}
