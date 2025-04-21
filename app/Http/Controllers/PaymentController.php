<?php

namespace App\Http\Controllers;

use App\Service\SubscriptionPlan\SubscriptionPlanService;
use App\Service\User\UserService;
use App\Service\UserSubscription\UserSubscriptionService;
use Illuminate\Http\Request;


class PaymentController extends Controller
{
    function __construct(
        protected UserService             $userService,
        protected SubscriptionPlanService $subscriptionPlanService,
        protected UserSubscriptionService $userSubscriptionService,
    )
    {
    }

    function subscribe($plan_id)
    {
        $count = $this->userService->getSubscriptionCount();
        if ($count > 0) {
            return redirect()->route('welcome')->with('error', 'You have already subscribed to a plan. Please cancel it first');
        }
        return view('modules.payment.index', compact('plan_id'));
    }

    public function doSubscribe(Request $request)
    {

        $request->validate([
            'card_number' => 'required|string|digits:16',
            'cvv' => 'required|string|digits:3',
            'expiry_date' => 'required|string',
            'name_on_card' => 'required|string|min:3|max:255',
            'billing_address' => 'required|string|min:3|max:255',
            'plan_id' => 'required|exists:subscription_plans,id',
        ]);


        try {
            $this->userSubscriptionService->subscribeUser($request);
            return redirect()->route('welcome')->with('success', 'You have successfully subscribed to a plan');

        }
        catch (\Exception $exception){
            return redirect()->route('welcome')->with('error', $exception->getMessage());
        }



    }
}
