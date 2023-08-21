<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth:sanctum'])->group(function () {

// ---------------- DEPARTMENTS URL's ---------------- //
Route::get('departments/list', [App\Http\Controllers\DepartmentsController::class, 'getDepartments']);
Route::post('departments/create', [App\Http\Controllers\DepartmentsController::class, 'createDepartment']);
Route::post('departments/update/{id}', [App\Http\Controllers\DepartmentsController::class, 'updateDepartment']);
Route::delete('departments/delete/{id}', [App\Http\Controllers\DepartmentsController::class, 'deleteDepartment']);

// ---------------- CORES URL's ---------------- //
Route::get('cores/list', [App\Http\Controllers\CoresController::class, 'getCores']);
Route::post('cores/create', [App\Http\Controllers\CoresController::class, 'createCore']);
Route::post('cores/update/{id}', [App\Http\Controllers\CoresController::class, 'updateCore']);
Route::delete('cores/delete/{id}', [App\Http\Controllers\CoresController::class, 'deleteCore']);

// ---------------- PROFILES URL's ---------------- //
Route::get('profile/list', [App\Http\Controllers\ProfileController::class, 'getProfiles']);
Route::post('profile/create', [App\Http\Controllers\ProfileController::class, 'createProfile']);
Route::post('profile/update/{id}', [App\Http\Controllers\ProfileController::class, 'updateProfile']);
Route::delete('profile/delete/{id}', [App\Http\Controllers\ProfileController::class, 'deleteProfile']);


});

