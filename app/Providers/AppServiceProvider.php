<?php

namespace App\Providers;

use App\Events\TaskCreateEvent;
use App\Events\TaskModificationEvent;
use App\Listeners\NotifyUserListener;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Event::listen(TaskCreateEvent::class,NotifyUserListener::class);
        Event::listen(TaskModificationEvent::class,NotifyUserListener::class);

        Paginator::useBootstrap();
    }
}
