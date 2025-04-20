<?php

namespace App\Service\UserSubscription;

use App\Contract\UserSubscription\UserSubscriptionContract;
use App\Service\SubscriptionPlan\SubscriptionPlanService;
use App\Service\User\UserService;
use Illuminate\Http\Request;

class UserSubscriptionService
{
    function __construct(
        protected UserService $userService,
        protected SubscriptionPlanService $subscriptionPlanService,
        protected UserSubscriptionContract $userSubscriptionRepository,
    )
    {
    }

    function subscribeUser(Request $request){
        $user=auth()->user();
        $subscription=$this->subscriptionPlanService->getSubscriptionPlanById($request->input('plan_id'));
        if($subscription->is_auto_renewable){
            $this->userService->updateCardInfo($request->all());
        }
        $user_subscription=[
            'subscription_plan_id'=>$subscription->id,
            'user_id'=>$user->id,
            'is_active'=>true,
            'expires_at'=>now()->addDays($subscription->duration)->toDateTimeString(),
            'transaction_id'=>rand(1,10000),
            'is_autorenew'=>$subscription->is_auto_renewable,
        ];
        $this->userSubscriptionRepository->create($user_subscription);

    }
}
