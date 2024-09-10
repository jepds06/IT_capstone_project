<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\AccountTypeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\SupplierController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('accounts')->group(function(){
    Route::get('/', [AccountController::class, 'index']);
    Route::get('/{accountId}', [AccountController::class, 'show']);
    Route::post('/', [AccountController::class, 'store']);
    Route::put('/{accountId}', [AccountController::class, 'update']);
    Route::delete('/{accountId}', [AccountController::class, 'destroy']);
});

Route::prefix('account')->group(function(){
    Route::post('/register', [AuthController::class, 'register']);
});

Route::prefix('accountTypes')->group(function(){
    Route::get('/', [AccountTypeController::class, 'index']);
    Route::get('/{accountTypeId}', [AccountTypeController::class, 'show']);
    Route::post('/', [AccountTypeController::class, 'store']);
    Route::put('/{accountTypeId}',[AccountTypeController::class, 'update']);
});

Route::prefix('administrators')->group(function(){
    Route::get('/', [AdminController::class, 'index']);
    Route::get('/{adminId}', [AdminController::class, 'show']);
    Route::post('/', [AdminController::class, 'store']);
    Route::put('/{adminId}', [AdminController::class, 'update']);
    Route::delete('/{adminId}', [AdminController::class, 'destroy']);
});

Route::prefix('customers')->group(function(){
    Route::get('/', [CustomerController::class, 'index']);
    Route::get('/{cstrId}', [CustomerController::class, 'show']);
    Route::post('/', [CustomerController::class, 'store']);
    Route::put('/{cstrId}', [CustomerController::class, 'update']);
    Route::delete('/{cstrId}', [CustomerController::class, 'destroy']);
});

Route::prefix('suppliers')->group(function(){
    Route::get('/', [SupplierController::class, 'index']);
    Route::get('/{supplierId}', [SupplierController::class, 'show']);
    Route::post('/', [SupplierController::class, 'store']);
    Route::put('/{supplierId}', [SupplierController::class, 'update']);
    Route::delete('/{supplierId}', [SupplierController::class, 'destroy']);
});

Route::prefix('productCategories')->group(function(){
    Route::get('/', [ProductCategoryController::class, 'index']);
    Route::get('/{prodCatId}', [ProductCategoryController::class, 'show']);
    Route::post('/', [ProductCategoryController::class, 'store']);
    Route::put('/{prodCatId}', [ProductCategoryController::class, 'update']);
});

Route::prefix('materials')->group(function(){
    Route::get('/', [MaterialController::class, 'index']);
    Route::get('/{materialId}', [MaterialController::class, 'show']);
    Route::post('/', [MaterialController::class, 'store']);
    Route::put('/{materialId}', [MaterialController::class, 'update']);
});
