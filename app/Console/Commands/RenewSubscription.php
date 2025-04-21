<?php

namespace App\Console\Commands;

use App\Service\UserSubscription\UserSubscriptionService;
use Illuminate\Console\Command;
use Illuminate\Contracts\Container\BindingResolutionException;

class RenewSubscription extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:renew-subscription';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     * @throws BindingResolutionException
     */
    public function handle()
    {
        $userSubscriptionService=app()->make(UserSubscriptionService::class);
        $userSubscriptionService->renewSubscription();
    }
}
