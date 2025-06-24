<?php

use App\Http\Controllers\FilesController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Livewire\User\Create;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->get('/', function () {
    return view('welcome');
})->name('index');

// Route::get('user/create', [UserController::class, 'create']);
Route::middleware('auth')->controller(UserController::class)->prefix('user')->group(function() {
    Route::get('', 'index')->name('user.index');
    Route::get('create', 'create')->name('user.create');
    Route::get('edit/{id}', 'edit')->name('user.edit');
});

Route::controller(LoginController::class)->prefix('auth')->group(function() {
    Route::get('login', 'index')->name('auth.index');
    Route::post('login', 'login')->name('auth.login');
    Route::delete('logout', 'logout')->name('auth.logout')->middleware('auth');
});

Route::middleware('auth')->controller(ProductController::class)->prefix('products')->group(function(){
    Route::get('', 'index')->name('products.index');
    Route::get('create', 'create')->name('products.create');
    Route::get('edit/{product}', 'edit')->name('products.edit');
});

Route::middleware('auth')->controller(FilesController::class)->prefix('files')->group(function(){
    Route::get('', 'index')->name('files.index');
});