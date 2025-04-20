<?php

namespace App\Http\Controllers;

use App\Repositories\SubscriptionPlans\SubscriptionPlanRepository;
use App\Service\SubscriptionPlan\SubscriptionPlanService;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    function __construct(
        protected SubscriptionPlanService $subscriptionPlanService
    )
    {
    }

    function index()
    {
        $plans = $this->subscriptionPlanService->getSubscriptionPlans();
        return view('welcome', compact('plans'));
    }
}
