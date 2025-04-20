<?php

namespace App\Contract\SubscriptionPlan;

interface SubscriptionPlanContract
{
    function getAllPlans();

    function getPlanById($planId);


}
