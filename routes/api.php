<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\AccountTypeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductMaterialsController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\SupplierMaterialController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//accounts route
Route::prefix('accounts')->group(function(){
    Route::get('/', [AccountController::class, 'index']);
    Route::get('/{accountId}', [AccountController::class, 'show']);
    Route::post('/', [AccountController::class, 'store']);
    Route::put('/{accountId}', [AccountController::class, 'update']);
    Route::delete('/{accountId}', [AccountController::class, 'destroy']);
});

//accountTypes route
Route::prefix('accountTypes')->group(function(){
    Route::get('/', [AccountTypeController::class, 'index']);
    Route::get('/{accountTypeId}', [AccountTypeController::class, 'show']);
    Route::post('/', [AccountTypeController::class, 'store']);
    Route::put('/{accountTypeId}',[AccountTypeController::class, 'update']);
});

//administrators route
Route::prefix('administrators')->group(function(){
    Route::get('/', [AdminController::class, 'index']);
    Route::get('/{adminId}', [AdminController::class, 'show']);
    Route::post('/', [AdminController::class, 'store']);
    Route::put('/{adminId}', [AdminController::class, 'update']);
    Route::delete('/{adminId}', [AdminController::class, 'destroy']);
});

//customers route
Route::prefix('customers')->group(function(){
    Route::get('/', [CustomerController::class, 'index']);
    Route::get('/{cstrId}', [CustomerController::class, 'show']);
    Route::post('/', [CustomerController::class, 'store']);
    Route::put('/{cstrId}', [CustomerController::class, 'update']);
    Route::delete('/{cstrId}', [CustomerController::class, 'destroy']);
});

//suppliers route
Route::prefix('suppliers')->group(function(){
    Route::get('/', [SupplierController::class, 'index']);
    Route::get('/{supplierId}', [SupplierController::class, 'show']);
    Route::post('/', [SupplierController::class, 'store']);
    Route::put('/{supplierId}', [SupplierController::class, 'update']);
    Route::delete('/{supplierId}', [SupplierController::class, 'destroy']);
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
    Route::get('/{materialId}', [MaterialController::class, 'show']);
    Route::post('/', [MaterialController::class, 'store']);
    Route::put('/{materialId}', [MaterialController::class, 'update']);
});

//products route
Route::prefix('products')->group(function(){
    Route::get('/', [ProductController::class, 'index']);
    Route::get('/{productId}', [ProductController::class, 'show']);
    Route::post('/', [ProductController::class, 'store']);
    Route::put('/{productId}', [ProductController::class, 'update']);
    Route::delete('/{productId}', [ProductController::class, 'destroy']);
});

//productMaterials route
Route::prefix('productMaterials')->group(function(){
    Route::get('/', [ProductMaterialsController::class, 'index']);
    Route::get('/{productMatsId}', [ProductMaterialsController::class, 'show']);
    Route::post('/', [ProductMaterialsController::class, 'store']);
    Route::put('/{productMatsId}', [ProductMaterialsController::class, 'update']);
});

//supplierMaterials route
Route::prefix('supplierMaterials')->group(function(){
    Route::get('/', [SupplierMaterialController::class, 'index']);
    Route::get('/{suppMtrlId}', [SupplierMaterialController::class, 'show']);
    Route::post('/', [SupplierMaterialController::class, 'store']);
    Route::put('/{suppMtrlId}', [SupplierMaterialController::class, 'update']);
});
