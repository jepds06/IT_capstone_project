<?php

use App\Http\Controllers\AdminDeliveryController;
use App\Http\Controllers\AdminOrderController;
use App\Http\Controllers\AdminPaymentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerOrderController;
use App\Http\Controllers\CustomerPaymentController;
use App\Http\Controllers\FinishedProductController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\PaymentMethodController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductionController;
use App\Http\Controllers\ProductionDetailController;
use App\Http\Controllers\ProductionMaterialController;
use App\Http\Controllers\ProductMaterialsController;
use App\Http\Controllers\QuotationController;
use App\Http\Controllers\QuotationDetailController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\SalesDeliveryController;
use App\Http\Controllers\SalesProductOrderController;
use App\Http\Controllers\SupplierMaterialController;
use App\Http\Controllers\UserAuthController;
use App\Http\Controllers\UserPrivilageController;
use App\Http\Controllers\UserRegController;
use App\Http\Controllers\UserTypeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//login/logout routes
Route::post('/login', [UserAuthController::class, 'login']);
Route::post('/logout', [UserAuthController::class, 'logout'])->middleware('auth:sanctum');

Route::middleware(['auth:sanctum'])->group(function(){
    //users route
    Route::prefix('users')->group(function(){
        Route::get('/', [UserRegController::class, 'index']);
        Route::get('/{userId}', [UserRegController::class, 'show']);
        Route::post('/', [UserRegController::class, 'store']);
        Route::put('/{userId}', [UserRegController::class, 'update']);
    });

    //userTypes route
    Route::prefix('userTypes')->group(function(){
        Route::get('/', [UserTypeController::class, 'index']);
        Route::get('/{userTypeId}', [UserTypeController::class, 'show']);
        Route::post('/', [UserTypeController::class, 'store']);
        Route::put('/{userTypeId}',[UserTypeController::class, 'update']);
    });

    //modules route
    Route::prefix('modules')->group(function(){
        Route::get('/', [ModuleController::class, 'index']);
        Route::get('/{moduleId}', [ModuleController::class, 'show']);
        Route::post('/', [ModuleController::class, 'store']);
        Route::put('/{moduleId}',[ModuleController::class, 'update']);
    });

    //UserPrivilage route
    Route::prefix('userPrivilage')->group(function(){
        Route::get('/', [UserPrivilageController::class, 'index']);
        Route::get('/{userPrivilageId}', [UserPrivilageController::class, 'show']);
        Route::post('/', [UserPrivilageController::class, 'store']);
        Route::put('/{userPrivilageId}', [UserPrivilageController::class, 'update']);
    });
    //productCategories route
    Route::prefix('productCategories')->group(function(){
        Route::get('/', [ProductCategoryController::class, 'index']);
        Route::get('/{prodCatId}', [ProductCategoryController::class, 'show']);
        Route::post('/', [ProductCategoryController::class, 'store']);
        Route::put('/{prodCatId}', [ProductCategoryController::class, 'update']);
    });

    //materials route
    Route::prefix('materials')->group(function(){
        Route::get('/', [MaterialController::class, 'index']);
        Route::get('/production/{productionID}', [MaterialController::class, 'indexByProductionID']);
        Route::get('/{materialId}', [MaterialController::class, 'show']);
        Route::post('/', [MaterialController::class, 'store']);
        Route::put('/{materialId}', [MaterialController::class, 'update']);
    });

    //products route
    Route::prefix('products')->group(function(){
        Route::get('/', [ProductController::class, 'index']);
        Route::get('/{productId}', [ProductController::class, 'show']);
        Route::post('/', [ProductController::class, 'store']);
        Route::post('/{productId}', [ProductController::class, 'update']);
    });

    //productMaterials route
    Route::prefix('productMaterials')->group(function(){
        Route::get('/', [ProductMaterialsController::class, 'index']);
        // Route::get('/{productMatsId}', [ProductMaterialsController::class, 'show']);
        Route::post('/', [ProductMaterialsController::class, 'store']);
        Route::put('/{productMatsId}', [ProductMaterialsController::class, 'update']);
        Route::get('/materials/{productID}', [ProductMaterialsController::class, 'showMaterialsByProductID']);
    });

    //supplierMaterials route
    Route::prefix('supplierMaterials')->group(function(){
        Route::get('/', [SupplierMaterialController::class, 'index']);
        Route::get('/{suppMtrlId}', [SupplierMaterialController::class, 'show']);
        Route::post('/', [SupplierMaterialController::class, 'store']);
        Route::put('/{suppMtrlId}', [SupplierMaterialController::class, 'update']);
    });

    //productions route
    Route::prefix('productions')->group(function(){
        Route::get('/', [ProductionController::class, 'index']);
        Route::get('/{productionId}', [ProductionController::class, 'show']);
        Route::post('/', [ProductionController::class, 'store']);
        Route::put('/{productionId}', [ProductionController::class, 'update']);
    });

    //productions details route
    Route::prefix('productionDetails')->group(function(){
        Route::get('/', [ProductionDetailController::class, 'index']);
        Route::get('/{prodtnDetailId}', [ProductionDetailController::class, 'show']);
        Route::get('/production/{productionID}', [ProductionDetailController::class, 'showByProductionID']);
        Route::post('/', [ProductionDetailController::class, 'store']);
        Route::put('/{prodtnDetailId}', [ProductionDetailController::class, 'update']);
    });

    //finished products route
    Route::prefix('finishedProducts')->group(function(){
        Route::get('/', [FinishedProductController::class, 'index']);
        Route::get('/{fnshProductId}', [FinishedProductController::class, 'show']);
        Route::post('/', [FinishedProductController::class, 'store']);
        Route::put('/{fnshProductId}', [FinishedProductController::class, 'update']);
    });

    //production materials route
    Route::prefix('productionMaterials')->group(function(){
        Route::get('/', [ProductionMaterialController::class, 'index']);
        Route::get('/{prodtnMtrlId}', [ProductionMaterialController::class, 'show']);
        Route::get('/productionDetails/{prodtnMtrlId}', [ProductionMaterialController::class, 'showProdDetailbyProdMatsID']);
        Route::post('/', [ProductionMaterialController::class, 'store']);
        Route::put('/{prodtnMtrlId}', [ProductionMaterialController::class, 'update']);
    });

    //quotations route
    Route::prefix('quotations')->group(function(){
        Route::get('/', [QuotationController::class, 'index']);
        Route::get('/{quoteId}', [QuotationController::class, 'show']);
        Route::post('/', [QuotationController::class, 'store']);
        Route::put('/{quoteId}', [QuotationController::class, 'update']);
    });

    //quotation details route
    Route::prefix('quotationDetails')->group(function(){
        Route::get('/', [QuotationDetailController::class, 'index']);
        Route::get('/quotation/{quotedID}', [QuotationDetailController::class, 'indexByQuotedID']);
        Route::get('/quotation', [QuotationDetailController::class, 'indexAll']);
        Route::get('/{qteDetailId}', [QuotationDetailController::class, 'show']);
        Route::post('/', [QuotationDetailController::class, 'store']);
        Route::put('/{qteDetailId}', [QuotationDetailController::class, 'update']);
        Route::delete('/{qteDetailId}', [QuotationDetailController::class, 'delete']);
    });

    //Admin Order route
    Route::prefix('adminOrders')->group(function(){
        Route::get('/', [AdminOrderController::class, 'index']);
        Route::get('/production/{productionID}', [AdminOrderController::class, 'indexByProductionID']);
        Route::get('/{adminOrderId}', [AdminOrderController::class, 'show']);
        Route::post('/', [AdminOrderController::class, 'store']);
        Route::put('/{adminOrderId}', [AdminOrderController::class, 'update']);
    });

    //admin delivery route
    Route::prefix('adminDeliveries')->group(function(){
        Route::get('/', [AdminDeliveryController::class, 'index']);
        Route::get('/{adminDlvrId}', [AdminDeliveryController::class, 'show']);
        Route::post('/', [AdminDeliveryController::class, 'store']);
        Route::put('/{adminDlvrId}', [AdminDeliveryController::class, 'update']);
    });

    //Admin Payment route
    Route::prefix('adminPayments')->group(function(){
        Route::get('/', [AdminPaymentController::class, 'index']);
        Route::get('/{adminPaymentId}', [AdminPaymentController::class, 'show']);
        Route::post('/', [AdminPaymentController::class, 'store']);
        Route::put('/{adminPaymentId}', [AdminPaymentController::class, 'update']);
    });

    //customer payment route
    Route::prefix('customerPayments')->group(function(){
        Route::get('/', [CustomerPaymentController::class, 'index']);
        Route::get('/{cstrPayId}', [CustomerPaymentController::class, 'show']);
        Route::post('/', [CustomerPaymentController::class, 'store']);
        Route::put('/{cstrPayId}', [CustomerPaymentController::class, 'update']);
    });

    //sales product order route
    Route::prefix('salesProductOrders')->group(function(){
        Route::get('/', [SalesProductOrderController::class, 'index']);
        Route::get('/{slsPrdOrdId}', [SalesProductOrderController::class, 'show']);
        Route::post('/', [SalesProductOrderController::class, 'store']);
        Route::put('/{slsPrdOrdId}', [SalesProductOrderController::class, 'update']);
    });

    //payment method route
    Route::prefix('paymentMethods')->group(function(){
        Route::get('/', [PaymentMethodController::class, 'index']);
        Route::get('/{payMethodId}', [PaymentMethodController::class, 'show']);
        Route::post('/', [PaymentMethodController::class, 'store']);
        Route::put('/{payMethodId}', [PaymentMethodController::class, 'update']);
    });

    //sales route
    Route::prefix('sales')->group(function(){
        Route::get('/', [SalesController::class, 'index']);
        Route::get('/user/{userID}', [SalesController::class, 'showByUserID']);
        Route::get('/{salesId}', [SalesController::class, 'show']);
        Route::post('/', [SalesController::class, 'store']);
        Route::put('/{salesId}', [SalesController::class, 'update']);
    });

    //sales delivery route
    Route::prefix('salesDeliveries')->group(function(){
        Route::get('/', [SalesDeliveryController::class, 'index']);
        Route::get('/{deliveryId}', [SalesDeliveryController::class, 'show']);
        Route::post('/', [SalesDeliveryController::class, 'store']);
        Route::put('/{deliveryId}', [SalesDeliveryController::class, 'update']);
    });
});