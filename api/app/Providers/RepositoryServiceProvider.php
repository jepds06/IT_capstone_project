<?php

namespace App\Providers;

use App\Interface\Repository\AccountRepositoryInterface;
use App\Interface\Repository\AccountTypeRepositoryInterface;
use App\Interface\Repository\AdministratorRepositoryInterface;
use App\Interface\Repository\CustomerRepositoryInterface;
use App\Interface\Repository\MaterialRepositoryInterface;
use App\Interface\Repository\ModuleRepositoryInterface;
use App\Interface\Repository\ProductCategoryRepositoryInterface;
use App\Interface\Repository\ProductMaterialsRepositoryInterface;
use App\Interface\Repository\ProductRepositoryInterface;
use App\Interface\Repository\SupplierMaterialRepositoryInterface;
use App\Interface\Repository\SupplierRepositoryInterface;
use App\Interface\Repository\UserAuthRepositoryInterface;
use App\Interface\Repository\UserPrivilageRepositoryInterface;
use App\Interface\Repository\UserRegRespositoryInterface;
use App\Interface\Repository\UserTypeRepositoryInterface;
use App\Interface\Service\AccountServiceInterface;
use App\Interface\Service\AccountTypeServiceInterface;
use App\Interface\Service\AdministratorServiceInterface;
use App\Interface\Service\CustomerServiceInterface;
use App\Interface\Service\MaterialServiceInterface;
use App\Interface\Service\ModuleServiceInterface;
use App\Interface\Service\ProductCategoryServiceInterface;
use App\Interface\Service\ProductMaterialServiceInterface;
use App\Interface\Service\ProductServiceInterface;
use App\Interface\Service\SupplierMaterialServiceInterface;
use App\Interface\Service\SupplierServiceInterface;
use App\Interface\Service\UserAuthServiceInterface;
use App\Interface\Service\UserPrivilageServiceInterface;
use App\Interface\Service\UserRegServiceInterface;
use App\Interface\Service\UserTypeServiceInterface;
use App\Repository\AccountRepository;
use App\Repository\AccountTypeRepository;
use App\Repository\AdministratorRepository;
use App\Repository\CustomerRepository;
use App\Repository\MaterialRepository;
use App\Repository\ModuleRepository;
use App\Repository\ProductCategoryRepository;
use App\Repository\ProductMaterialRepository;
use App\Repository\ProductRepository;
use App\Repository\SupplierMaterialRepository;
use App\Repository\SupplierRepository;
use App\Repository\UserAuthRepository;
use App\Repository\UserPrivilageRepository;
use App\Repository\UserRegRepository;
use App\Repository\UserTypeRepository;
use App\Service\AccountService;
use App\Service\AccountTypeService;
use App\Service\AdministratorService;
use App\Service\CustomerService;
use App\Service\MaterialService;
use App\Service\ModuleService;
use App\Service\ProductCategoryService;
use App\Service\ProductMaterialsService;
use App\Service\ProductService;
use App\Service\SupplierMaterialService;
use App\Service\SupplierService;
use App\Service\UserAuthService;
use App\Service\UserPrivilageService;
use App\Service\UserRegService;
use App\Service\UserTypeService;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //Repository
        // $this->app->bind(AccountRepositoryInterface::class, AccountRepository::class);
        // $this->app->bind(AccountTypeRepositoryInterface::class, AccountTypeRepository::class);
        // $this->app->bind(AdministratorRepositoryInterface:: class, AdministratorRepository::class);
        // $this->app->bind(CustomerRepositoryInterface::class, CustomerRepository::class);
        // $this->app->bind(SupplierRepositoryInterface::class, SupplierRepository::class);
        $this->app->bind(UserTypeRepositoryInterface::class, UserTypeRepository::class);
        $this->app->bind(UserAuthRepositoryInterface::class , UserAuthRepository::class);
        $this->app->bind(UserRegRespositoryInterface::class, UserRegRepository::class);
        $this->app->bind(ModuleRepositoryInterface::class, ModuleRepository::class);
        $this->app->bind(ProductCategoryRepositoryInterface::class, ProductCategoryRepository::class);
        $this->app->bind(MaterialRepositoryInterface::class, MaterialRepository::class);
        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
        $this->app->bind(ProductMaterialsRepositoryInterface::class, ProductMaterialRepository::class);
        $this->app->bind(SupplierMaterialRepositoryInterface::class, SupplierMaterialRepository::class);
        $this->app->bind(UserPrivilageRepositoryInterface::class, UserPrivilageRepository::class);

        //Service
        // $this->app->bind(AccountServiceInterface::class, AccountService::class);
        // $this->app->bind(AccountTypeServiceInterface::class, AccountTypeService::class);
        // $this->app->bind(AdministratorServiceInterface::class, AdministratorService::class);
        // $this->app->bind(CustomerServiceInterface::class, CustomerService::class);
        // $this->app->bind(SupplierServiceInterface::class, SupplierService::class);
        $this->app->bind(UserTypeServiceInterface::class, UserTypeService::class);
        $this->app->bind(UserAuthServiceInterface::class, UserAuthService::class);
        $this->app->bind(UserRegServiceInterface::class, UserRegService::class);
        $this->app->bind(ModuleServiceInterface::class, ModuleService::class);
        $this->app->bind(ProductCategoryServiceInterface::class, ProductCategoryService::class);
        $this->app->bind(MaterialServiceInterface::class, MaterialService::class);
        $this->app->bind(ProductServiceInterface::class, ProductService::class);
        $this->app->bind(ProductMaterialServiceInterface::class, ProductMaterialsService::class);
        $this->app->bind(SupplierMaterialServiceInterface::class, SupplierMaterialService::class);
        $this->app->bind(UserPrivilageServiceInterface::class, UserPrivilageService::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
