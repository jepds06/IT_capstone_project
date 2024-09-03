<?php

namespace App\Providers;

use App\Interface\Repository\AccountRepositoryInterface;
use App\Interface\Repository\AccountTypeRepositoryInterface;
use App\Interface\Repository\AdministratorRepositoryInterface;
use App\Interface\Service\AccountServiceInterface;
use App\Interface\Service\AccountTypeServiceInterface;
use App\Interface\Service\AdministratorServiceInterface;
use App\Repository\AccountRepository;
use App\Repository\AccountTypeRepository;
use App\Repository\AdministratorRepository;
use App\Service\AccountService;
use App\Service\AccountTypeService;
use App\Service\AdministratorService;
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

        //Service
        $this->app->bind(AccountServiceInterface::class, AccountService::class);
        $this->app->bind(AccountTypeServiceInterface::class, AccountTypeService::class);
        $this->app->bind(AdministratorServiceInterface::class, AdministratorService::class);

    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
