<?php

namespace App\Providers;

use App\Models\User;
use App\Policies\UserPolicy;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Events\CustomerQueue\CustomerQueued;
use App\Listeners\CustomerQueue\HandleCustomerQueued;
use Illuminate\Support\Facades\Event;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void {}

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::policy(User::class, UserPolicy::class);

        // Register the domain listener that reacts to customer queue changes.
        // Keep this active even if the realtime broadcast event remains commented out,
        // because this listener is the place where you can later add event-log inserts
        // and dispatch the UI-facing CustomerListUpdated event.
        Event::listen(CustomerQueued::class, HandleCustomerQueued::class);
    }
}
