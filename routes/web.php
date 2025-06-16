<?php

use App\Http\Controllers\UserController;
use App\Livewire\User\Create;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('index');

Route::get('user/create', [UserController::class, 'create']);
