<?php

namespace App\Providers;

use App\Services\CompanyService\CompanyService;
use App\Services\CompanyService\ICompanyService;
use App\Services\Customer\CustomerService;
use App\Services\Customer\ICustomerService;
use App\Services\UserService\IUserService;
use App\Services\UserService\UserService;
use Illuminate\Support\ServiceProvider;

class ServiceBindingProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ICompanyService::class, CompanyService::class);
        $this->app->bind(ICustomerService::class, CustomerService::class);
        $this->app->bind(IUserService::class, UserService::class);
    }
}