<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductMaterialsController;
use App\Http\Controllers\SupplierMaterialController;
use App\Http\Controllers\UserAuthController;
use App\Http\Controllers\UserRegController;
use App\Http\Controllers\UserTypeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//userTypes route
Route::prefix('userTypes')->group(function(){
    Route::get('/', [UserTypeController::class, 'index']);
    Route::get('/{userTypeId}', [UserTypeController::class, 'show']);
    Route::post('/', [UserTypeController::class, 'store']);
    Route::put('/{userTypeId}',[UserTypeController::class, 'update']);
});

//users route
Route::prefix('users')->group(function(){
    Route::get('/', [UserRegController::class, 'index']);
    Route::get('/{userid}', [UserRegController::class, 'show']);
    Route::post('/', [UserRegController::class, 'store']);
    Route::put('/{userid}', [UserRegController::class, 'update']);
});

//modules route
Route::prefix('modules')->group(function(){
    Route::get('/', [ModuleController::class, 'index']);
    Route::get('/{moduleId}', [ModuleController::class, 'show']);
    Route::post('/', [ModuleController::class, 'store']);
    Route::put('/{moduleId}',[ModuleController::class, 'update']);
});

//register route
Route::prefix('account')->group(function(){
    Route::post('/register', [AuthController::class, 'register']);
});

//login/logout routes
Route::post('/login', [UserAuthController::class, 'login']);
Route::post('/logout', [UserAuthController::class, 'logout'])->middleware('auth:sanctum');

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
