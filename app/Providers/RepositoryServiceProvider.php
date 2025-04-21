<?php

namespace App\Providers;

use App\Contract\SubscriptionPlan\SubscriptionPlanContract;
use App\Contract\User\UserContract;
use App\Contract\User\UserTransactionContract;
use App\Contract\UserSubscription\UserSubscriptionContract;
use App\Repositories\SubscriptionPlans\SubscriptionPlanRepository;
use App\Repositories\User\UserRepository;
use App\Repositories\User\UserTransactionRepository;
use App\Repositories\UserSubscription\UserSubscriptionRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(SubscriptionPlanContract::class, SubscriptionPlanRepository::class);
        $this->app->singleton(UserContract::class, UserRepository::class);
        $this->app->singleton(UserSubscriptionContract::class, UserSubscriptionRepository::class);
        $this->app->singleton(UserTransactionContract::class, UserTransactionRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
