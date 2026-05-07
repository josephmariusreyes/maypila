<?php

namespace App\Providers;

use App\Models\User;
use App\Policies\UserPolicy;
use App\Services\CompanyService\CompanyService;
use App\Services\CompanyService\ICompanyService;
use Illuminate\Support\ServiceProvider;
use App\Services\UserService\IUserService;
use App\Services\UserService\UserService;
use Illuminate\Support\Facades\Gate;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //jephtodo > Have a separate provider for this
        //We want to keepp the AppServiceProvider for global services
        $this->app->bind(ICompanyService::class, CompanyService::class);
        $this->app->bind(IUserService::class, UserService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::policy(User::class, UserPolicy::class);

    }
}
