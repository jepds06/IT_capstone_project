<?php

namespace App\Providers;

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

        //Service
        $this->app->bind(AccountServiceInterface::class, AccountService::class);
        $this->app->bind(AccountTypeServiceInterface::class, AccountTypeService::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
