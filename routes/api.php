<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::controller(LoginController::class)->prefix('auth')->group(function() {
    Route::get('/user', function (Request $request) {
        return $request->user();
    })->middleware('auth:sanctum');

    Route::post('/login', [LoginController::class, 'apiLogin']);

    Route::delete('/logout', [LoginController::class, 'revokeToken'])->middleware('auth:sanctum');
});

Route::controller(ProductController::class)->prefix('products')->group(function(){
    Route::get('list', 'find');
    Route::get('show/{slug}', 'findOne');
});
