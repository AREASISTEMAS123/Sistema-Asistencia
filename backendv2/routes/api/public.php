<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Route;

Route::post('register', [RegisterController::class, 'register'])->name('register');
Route::post('login', LoginController::class)->name('login');
