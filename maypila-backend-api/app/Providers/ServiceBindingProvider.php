<?php

namespace App\Providers;

use App\Services\CompanyService\CompanyService;
use App\Services\Customer\CustomerService;
use App\Services\QueueSession\QueueSessionService;
use App\Services\UserService\UserService;
use Illuminate\Support\ServiceProvider;

class ServiceBindingProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //todojeph: create an authService, this will have inteface because I will try to have diffenrent implementation for authentication

        //Concrete implementation of classes here
        //I am registering these guys as scoped for now, since i plan to implement caching and I want predictable lifecycle
        $this->app->scoped(UserService::class, UserService::class);
        $this->app->scoped(QueueSessionService::class, QueueSessionService::class);
        $this->app->scoped(CompanyService::class, CompanyService::class);
        $this->app->scoped(CustomerService::class, CustomerService::class);
    }
}