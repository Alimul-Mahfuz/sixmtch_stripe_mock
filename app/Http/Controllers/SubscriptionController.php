<?php

namespace App\Http\Controllers;

use App\Service\UserSubscription\UserSubscriptionService;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    function __construct(
        protected UserSubscriptionService $userSubscriptionService
    )
    {
    }

    function index()
    {
        $subscriptions = $this->userSubscriptionService->getUserSubscriptions();
        return view('modules.subscriptions.index', compact('subscriptions'));
    }

    function cancel(Request $request)
    {
        $request->validate([
            'user_subscription_id' => 'required|exists:subscription_users,id'
        ]);

        $response = $this->userSubscriptionService->cancelSubscription($request->input('user_subscription_id'));
        if ($response['success']) {
            return redirect()->route('subscriptions.index')->with('success', $response['message']);
        }
        return redirect()->route('subscriptions.index')->with('error', $response['message']);


    }
}
