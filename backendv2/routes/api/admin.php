<?php

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
Route::get('position/list', [App\Http\Controllers\PositionController::class, 'getProfiles']);
Route::post('position/create', [App\Http\Controllers\PositionController::class, 'createProfile']);
Route::post('position/update/{id}', [App\Http\Controllers\PositionController::class, 'updateProfile']);
Route::delete('position/delete/{id}', [App\Http\Controllers\PositionController::class, 'deleteProfile']);

Route::get('users/list', [App\Http\Controllers\UserController::class, 'showProfileData']);

});

