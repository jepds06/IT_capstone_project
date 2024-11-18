<?php

namespace App\Providers;

use App\Interface\Repository\AccountRepositoryInterface;
use App\Interface\Repository\AccountTypeRepositoryInterface;
use App\Interface\Repository\AdminDeliveryRepositoryInterface;
use App\Interface\Repository\AdministratorRepositoryInterface;
use App\Interface\Repository\AdminOrderRepositoryInterface;
use App\Interface\Repository\AdminPaymentRepositoryInterface;
use App\Interface\Repository\CustomerOrderRepositoryInterface;
use App\Interface\Repository\CustomerPaymentRepositoryInterface;
use App\Interface\Repository\CustomerRepositoryInterface;
use App\Interface\Repository\FinishedProductRepositoryInterface;
use App\Interface\Repository\MaterialRepositoryInterface;
use App\Interface\Repository\ModuleRepositoryInterface;
use App\Interface\Repository\PaymentMethodRepositoryInterface;
use App\Interface\Repository\ProductCategoryRepositoryInterface;
use App\Interface\Repository\ProductionDetailRepositoryInterface;
use App\Interface\Repository\ProductionMaterialRepositoryInterface;
use App\Interface\Repository\ProductionRepositoryInterface;
use App\Interface\Repository\ProductMaterialsRepositoryInterface;
use App\Interface\Repository\ProductRepositoryInterface;
use App\Interface\Repository\QuotationDetailRepositoryInterface;
use App\Interface\Repository\QuotationRepositoryInterface;
use App\Interface\Repository\SalesDeliveryRepositoryInterface;
use App\Interface\Repository\SalesProdOrderRepositoryInterface;
use App\Interface\Repository\SalesRepositoryInterface;
use App\Interface\Repository\SupplierMaterialRepositoryInterface;
use App\Interface\Repository\SupplierRepositoryInterface;
use App\Interface\Repository\UserAuthRepositoryInterface;
use App\Interface\Repository\UserPrivilageRepositoryInterface;
use App\Interface\Repository\UserRegRepositoryInterface;
use App\Interface\Repository\UserTypeRepositoryInterface;
use App\Interface\Service\AccountServiceInterface;
use App\Interface\Service\AccountTypeServiceInterface;
use App\Interface\Service\AdminDeliveryServiceInterface;
use App\Interface\Service\AdministratorServiceInterface;
use App\Interface\Service\AdminOrderServiceInterface;
use App\Interface\Service\AdminPaymentServiceInterface;
use App\Interface\Service\CustomerOrderServiceInterface;
use App\Interface\Service\CustomerPaymentServiceInterface;
use App\Interface\Service\CustomerServiceInterface;
use App\Interface\Service\FinishedProductServiceInterface;
use App\Interface\Service\MaterialServiceInterface;
use App\Interface\Service\ModuleServiceInterface;
use App\Interface\Service\PaymentMethodServiceInterface;
use App\Interface\Service\ProductCategoryServiceInterface;
use App\Interface\Service\ProductionDetailServiceInterface;
use App\Interface\Service\ProductionMaterialServiceInterface;
use App\Interface\Service\ProductionServiceInterface;
use App\Interface\Service\ProductMaterialServiceInterface;
use App\Interface\Service\ProductServiceInterface;
use App\Interface\Service\QuotationDetailServiceInterface;
use App\Interface\Service\QuotationServiceInterface;
use App\Interface\Service\SalesDeliveryServiceInterface;
use App\Interface\Service\SalesPrdOrdServiceInterface;
use App\Interface\Service\SalesServiceInterface;
use App\Interface\Service\SupplierMaterialServiceInterface;
use App\Interface\Service\SupplierServiceInterface;
use App\Interface\Service\UserAuthServiceInterface;
use App\Interface\Service\UserPrivilageServiceInterface;
use App\Interface\Service\UserRegServiceInterface;
use App\Interface\Service\UserTypeServiceInterface;
use App\Repository\AccountRepository;
use App\Repository\AccountTypeRepository;
use App\Repository\AdminDeliveryRepository;
use App\Repository\AdministratorRepository;
use App\Repository\AdminOrderRepository;
use App\Repository\AdminPaymentRepository;
use App\Repository\CustomerOrderRepository;
use App\Repository\CustomerPaymentRepository;
use App\Repository\CustomerRepository;
use App\Repository\FinishedProductRepository;
use App\Repository\MaterialRepository;
use App\Repository\ModuleRepository;
use App\Repository\PaymentMethodRepository;
use App\Repository\ProductCategoryRepository;
use App\Repository\ProductionDetailRepository;
use App\Repository\ProductionMaterialRepository;
use App\Repository\ProductionRepository;
use App\Repository\ProductMaterialRepository;
use App\Repository\ProductRepository;
use App\Repository\QuotationDetailRepository;
use App\Repository\QuotationRepository;
use App\Repository\SalesDeliveryRepository;
use App\Repository\SalesProdOrderRepository;
use App\Repository\SalesRepository;
use App\Repository\SupplierMaterialRepository;
use App\Repository\SupplierRepository;
use App\Repository\UserAuthRepository;
use App\Repository\UserPrivilageRepository;
use App\Repository\UserRegRepository;
use App\Repository\UserTypeRepository;
use App\Service\AccountService;
use App\Service\AccountTypeService;
use App\Service\AdminDeliveryService;
use App\Service\AdministratorService;
use App\Service\AdminOrderService;
use App\Service\AdminPaymentService;
use App\Service\CustomerOrderService;
use App\Service\CustomerPaymentService;
use App\Service\CustomerService;
use App\Service\FinishedProductService;
use App\Service\MaterialService;
use App\Service\ModuleService;
use App\Service\PaymentMethodService;
use App\Service\ProductCategoryService;
use App\Service\ProductionDetailService;
use App\Service\ProductionMaterialService;
use App\Service\ProductionService;
use App\Service\ProductMaterialsService;
use App\Service\ProductService;
use App\Service\QuotationDetailService;
use App\Service\QuotationService;
use App\Service\SalesDeliveryService;
use App\Service\SalesPrdOrderService;
use App\Service\SalesService;
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
        $this->app->bind(UserRegRepositoryInterface::class, UserRegRepository::class);
        $this->app->bind(ModuleRepositoryInterface::class, ModuleRepository::class);
        $this->app->bind(ProductCategoryRepositoryInterface::class, ProductCategoryRepository::class);
        $this->app->bind(MaterialRepositoryInterface::class, MaterialRepository::class);
        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
        $this->app->bind(ProductMaterialsRepositoryInterface::class, ProductMaterialRepository::class);
        $this->app->bind(SupplierMaterialRepositoryInterface::class, SupplierMaterialRepository::class);
        $this->app->bind(UserPrivilageRepositoryInterface::class, UserPrivilageRepository::class);
        $this->app->bind(ProductionRepositoryInterface::class, ProductionRepository::class);
        $this->app->bind(ProductionDetailRepositoryInterface::class, ProductionDetailRepository::class);
        $this->app->bind(ProductionMaterialRepositoryInterface::class, ProductionMaterialRepository::class);
        $this->app->bind(QuotationRepositoryInterface::class, QuotationRepository::class);
        $this->app->bind(QuotationDetailRepositoryInterface::class, QuotationDetailRepository::class);
        $this->app->bind(FinishedProductRepositoryInterface::class, FinishedProductRepository::class);
        $this->app->bind(PaymentMethodRepositoryInterface::class, PaymentMethodRepository::class);
        $this->app->bind(AdminOrderRepositoryInterface::class, AdminOrderRepository::class);
        $this->app->bind(AdminPaymentRepositoryInterface::class, AdminPaymentRepository::class);
        $this->app->bind(AdminDeliveryRepositoryInterface::class, AdminDeliveryRepository::class);
        $this->app->bind(CustomerPaymentRepositoryInterface::class, CustomerPaymentRepository::class);
        $this->app->bind(SalesProdOrderRepositoryInterface::class, SalesProdOrderRepository::class);
        $this->app->bind(SalesRepositoryInterface::class, SalesRepository::class);
        $this->app->bind(SalesDeliveryRepositoryInterface::class, SalesDeliveryRepository::class);

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
        $this->app->bind(ProductionServiceInterface::class, ProductionService::class);
        $this->app->bind(ProductionDetailServiceInterface::class, ProductionDetailService::class);
        $this->app->bind(ProductionMaterialServiceInterface::class, ProductionMaterialService::class);
        $this->app->bind(QuotationServiceInterface::class, QuotationService::class);
        $this->app->bind(QuotationDetailServiceInterface::class, QuotationDetailService::class);
        $this->app->bind(FinishedProductServiceInterface::class, FinishedProductService::class);
        $this->app->bind(PaymentMethodServiceInterface::class, PaymentMethodService::class);
        $this->app->bind(AdminOrderServiceInterface::class, AdminOrderService::class);
        $this->app->bind(AdminPaymentServiceInterface::class, AdminPaymentService::class);
        $this->app->bind(AdminDeliveryServiceInterface::class, AdminDeliveryService::class);
        $this->app->bind(CustomerPaymentServiceInterface::class, CustomerPaymentService::class);
        $this->app->bind(SalesPrdOrdServiceInterface::class, SalesPrdOrderService::class);
        $this->app->bind(SalesServiceInterface::class, SalesService::class);
        $this->app->bind(SalesDeliveryServiceInterface::class, SalesDeliveryService::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
