<?php

namespace App\Providers;

use App\Services\CompanyService\CompanyService;
use App\Services\CompanyService\ICompanyService;
use App\Services\Customer\CustomerService;
use App\Services\Customer\ICustomerService;
use App\Services\QueueSession\QueueSessionService;
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
        $this->app->scoped(ICompanyService::class, CompanyService::class);
        $this->app->scoped(ICustomerService::class, CustomerService::class);
        $this->app->scoped(IUserService::class, UserService::class);

        //Concrete implementation of classes here
        $this->app->scoped(QueueSessionService::class, QueueSessionService::class);
    }
}