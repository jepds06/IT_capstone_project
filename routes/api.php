<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\AccountTypeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('accounts')->group(function(){
    Route::get('/', [AccountController::class, 'index']);
    Route::get('/{accountId}', [AccountController::class, 'show']);
    Route::post('/', [AccountController::class, 'store']);
    Route::put('/{accountId}', [AccountController::class, 'update']);
    Route::delete('/{accountId}', [AccountController::class, 'destroy']);
});

Route::prefix('account_types')->group(function(){
    Route::get('/', [AccountTypeController::class, 'index']);
    Route::get('/{accountTypeId}', [AccountTypeController::class, 'show']);
    Route::post('/', [AccountTypeController::class, 'store']);
    Route::put('/{accountTypeId}',[AccountTypeController::class, 'update']);
});

