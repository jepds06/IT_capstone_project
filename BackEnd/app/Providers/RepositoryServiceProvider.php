<?php

namespace App\Providers;

use App\Interface\Repository\AccountRepositoryInterface;
use App\Interface\Repository\AccountTypeRepositoryInterface;
use App\Interface\Repository\AdministratorRepositoryInterface;
use App\Interface\Repository\CustomerRepositoryInterface;
use App\Interface\Repository\SupplierRepositoryInterface;
use App\Interface\Service\AccountServiceInterface;
use App\Interface\Service\AccountTypeServiceInterface;
use App\Interface\Service\AdministratorServiceInterface;
use App\Interface\Service\CustomerServiceInterface;
use App\Interface\Service\SupplierServiceInterface;
use App\Repository\AccountRepository;
use App\Repository\AccountTypeRepository;
use App\Repository\AdministratorRepository;
use App\Repository\CustomerRepository;
use App\Repository\SupplierRepository;
use App\Service\AccountService;
use App\Service\AccountTypeService;
use App\Service\AdministratorService;
use App\Service\CustomerService;
use App\Service\SupplierService;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //Repository
        $this->app->bind(AccountRepositoryInterface::class, AccountRepository::class);
        $this->app->bind(AccountTypeRepositoryInterface::class, AccountTypeRepository::class);
        $this->app->bind(AdministratorRepositoryInterface:: class, AdministratorRepository::class);
        $this->app->bind(CustomerRepositoryInterface::class, CustomerRepository::class);
        $this->app->bind(SupplierRepositoryInterface::class, SupplierRepository::class);

        //Service
        $this->app->bind(AccountServiceInterface::class, AccountService::class);
        $this->app->bind(AccountTypeServiceInterface::class, AccountTypeService::class);
        $this->app->bind(AdministratorServiceInterface::class, AdministratorService::class);
        $this->app->bind(CustomerServiceInterface::class, CustomerService::class);
        $this->app->bind(SupplierServiceInterface::class, SupplierService::class);

    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
