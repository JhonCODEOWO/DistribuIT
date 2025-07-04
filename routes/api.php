<?php

use App\Http\Controllers\LoginController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::controller(LoginController::class)->prefix('auth')->group(function() {
    Route::get('/user', function (Request $request) {
        return $request->user();
    })->middleware('auth:sanctum');

    Route::post('/login', [LoginController::class, 'apiLogin']);

    Route::delete('/logout', [LoginController::class, 'revokeToken'])->middleware('auth:sanctum');
});

//Renovar token
Route::post('/tokens/create', function (Request $request) {
    $token = $request->user()->createToken($request->token_name);
    return ['token' => $token->plainTextToken];
})->middleware('auth:sanctum');
