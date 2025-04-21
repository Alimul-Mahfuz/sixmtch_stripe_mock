<?php

namespace App\Service\UserSubscription;

use App\Contract\Payment\PaymentContract;
use App\Contract\UserSubscription\UserSubscriptionContract;
use App\Dto\Transaction\CreateUserTransactionDTO;
use App\Dto\User\UserCardDetailDTO;
use App\Service\SubscriptionPlan\SubscriptionPlanService;
use App\Service\User\UserService;
use App\Service\User\UserTransactionService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use function Symfony\Component\Translation\t;

class UserSubscriptionService
{
    function __construct(
        protected UserService              $userService,
        protected SubscriptionPlanService  $subscriptionPlanService,
        protected UserSubscriptionContract $userSubscriptionRepository,
        protected PaymentContract          $paymentContract,
        protected UserTransactionService   $userTransactionService
    )
    {
    }

    /**
     * @throws Exception
     */
    function subscribeUser(Request $request): void
    {
        $user = auth()->user();
        $subscription = $this->subscriptionPlanService->getSubscriptionPlanById($request->input('plan_id'));
        if ($subscription->is_auto_renewable) {
            $this->userService->updateCardInfo($request->all());
        }

        $card_number = $request['card_number'];
        $exp = $request['expiry_date'];
        $cvv = $request['cvv'];
        $name_on_the_card = $request['name_on_card'];
        $amount = floatval($subscription->price);

        $response = $this->paymentContract->initiatePayment($card_number, $cvv, $exp, $name_on_the_card, $amount);
        $response = json_decode($response, true);
        if ($response['success']) {
            DB::beginTransaction();

            try {
                $user_subscription = [
                    'subscription_plan_id' => $subscription->id,
                    'user_id' => $user->id,
                    'is_active' => true,
                    'expires_at' => now()->addDays($subscription->duration)->toDateTimeString(),
                    'transaction_id' => $response['transaction_id'],
                    'is_autorenew' => $subscription->is_auto_renewable,
                ];

                $transactionDTO = new CreateUserTransactionDTO($user->id, $response['transaction_id'], $subscription->id, 'forward', $amount, true);
                $this->userTransactionService->create($transactionDTO);
                $this->userSubscriptionRepository->create($user_subscription);
                DB::commit();

            } catch (Exception $e) {
                DB::rollBack();
                throw $e;
            }
        } else {
            throw new Exception('Something went wrong');
        }


    }

    /**
     * @throws Exception
     */
    function planSubscriber($userSubscriptionId, $planId, $userId, UserCardDetailDTO $userCardDetailDTO): void
    {
        $subscription = $this->subscriptionPlanService->getSubscriptionPlanById($planId);
        $amount = intval($subscription->price);
        $response = $this->paymentContract->initiatePayment($userCardDetailDTO->card_number, $userCardDetailDTO->cvv, $userCardDetailDTO->exp, $userCardDetailDTO->name_on_the_card, $amount);
        $response = json_decode($response, true);
        if ($response['success']) {
            DB::beginTransaction();
            try {
                $newExpiresAt = now()->addDays($subscription->duration)->toDateTimeString();
                $transactionDTO = new CreateUserTransactionDTO($userId, $response['transaction_id'], $subscription->id, 'forward', $amount, true);
                $this->userTransactionService->create($transactionDTO);
                $this->userSubscriptionRepository->updateUserSubscription($userSubscriptionId, $newExpiresAt);
                DB::commit();

            } catch (Exception $e) {
                DB::rollBack();
                throw $e;
            }
        } else {
            throw new Exception('Something went wrong');
        }

    }

    function getUserSubscriptions()
    {
        $user = auth()->user();
        return $this->userSubscriptionRepository->getUserSubscription($user->id);

    }

    function checkForRefund($subscriptionId): bool
    {
        $subscriptionId = intval($subscriptionId);
        $userSubscription = $this->userSubscriptionRepository->getUserSubscriptionById($subscriptionId);
        $planGracePeriodDays = $userSubscription->subscription_plans->grace_period;
        $subscriptionGracePeriodEndDate = $userSubscription->created_at->addDays($planGracePeriodDays);
        if (now()->lessThanOrEqualTo($subscriptionGracePeriodEndDate)) {
            return true;
        }
        return false;
    }

    function cancelSubscription($subscriptionId): array
    {
        $user = auth()->user();
        $subscriptionId = intval($subscriptionId);
        $userSubscription = $this->userSubscriptionRepository->getUserSubscriptionById($subscriptionId);
        $transaction = $this->userTransactionService->getTransactionByTransactionId($userSubscription->transaction_id);
        $amount = floatval($transaction->amount);
        try {
            DB::beginTransaction();
            if ($this->checkForRefund($subscriptionId)) {
                $transaction_id = $userSubscription->transaction_id;
                $response = $this->paymentContract->reversePayment($transaction_id, $amount);
                $response = json_decode($response, true);
                if ($response['success']) {
                    $transactionDTO = new CreateUserTransactionDTO($user->id, $response['transaction_id'], $userSubscription->subscription_plans->id, 'reversed', $amount, true);
                    $this->userTransactionService->create($transactionDTO);
                    $this->userSubscriptionRepository->cancelSubscription($subscriptionId);
                    DB::commit();
                    return [
                        'success' => true,
                        'message' => 'Subscription cancelled with full refund',
                    ];
                } else {
                    throw new Exception('Something went wrong');
                }
            } else {
                $this->userSubscriptionRepository->cancelSubscription($subscriptionId);
                DB::commit();
                return [
                    'success' => false,
                    'message' => 'Subscription cancelled without refund',
                ];
            }
        } catch (Exception $e) {
            DB::rollBack();
            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }

    /**
     * @throws Exception
     */
    function renewSubscription()
    {
        $renewableSubscriptions = $this->userSubscriptionRepository->getRenewableSubscriptions();

        foreach ($renewableSubscriptions as $subscription) {
            $expiresAt = Carbon::parse($subscription->expires_at);
            if (now()->greaterThan($expiresAt)) {
                $userCardInfo = $this->userService->getCardInfoByUserId($subscription->user_id);
                $this->planSubscriber(
                    $subscription->id,
                    $subscription->subscription_plan_id,
                    $subscription->user_id,
                    $userCardInfo
                );
            }
        }
    }

}
