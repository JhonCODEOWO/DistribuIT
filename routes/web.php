<?php

use App\Http\Controllers\UserController;
use App\Livewire\User\Create;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('index');

// Route::get('user/create', [UserController::class, 'create']);
Route::controller(UserController::class)->prefix('user')->group(function() {
    Route::get('', 'index')->name('user.index');
    Route::get('create', 'create')->name('user.create');
    Route::get('edit/{id}', 'edit')->name('user.edit');
});
