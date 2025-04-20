<?php

namespace App\Service\SubscriptionPlan;

use App\Contract\SubscriptionPlan\SubscriptionPlanContract;
use App\Models\SubscriptionPlan;

class SubscriptionPlanService
{
    function __construct(protected SubscriptionPlanContract $subscriptionPlanRepository)
    {

    }

    function getSubscriptionPlans()
    {
        return $this->subscriptionPlanRepository->getAllPlans();
    }

    function getSubscriptionPlanById($planId)
    {
        return $this->subscriptionPlanRepository->getPlanById($planId);
    }
}
