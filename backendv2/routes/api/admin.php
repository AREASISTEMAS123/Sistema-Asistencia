<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Password\ChangeController;

Route::middleware(['auth:sanctum'])->group(function () {
// ---------------- PASSWORD URL's ---------------- //
Route::post('changePassword', ChangeController::class)->name('changePassword');

// ---------------- DEPARTMENTS URL's ---------------- //
Route::get('departments/list', [App\Http\Controllers\DepartmentsController::class, 'getDepartments']);
Route::post('departments/create', [App\Http\Controllers\DepartmentsController::class, 'createDepartment']);
Route::put('departments/update/{id}', [App\Http\Controllers\DepartmentsController::class, 'updateDepartment']);
Route::delete('departments/delete/{id}', [App\Http\Controllers\DepartmentsController::class, 'deleteDepartment']);

// ---------------- CORES URL's ---------------- //
Route::get('cores/list', [App\Http\Controllers\CoresController::class, 'getCores']);
Route::post('cores/create', [App\Http\Controllers\CoresController::class, 'createCore']);
Route::put('cores/update/{id}', [App\Http\Controllers\CoresController::class, 'updateCore']);
Route::delete('cores/delete/{id}', [App\Http\Controllers\CoresController::class, 'deleteCore']);

// ---------------- POSITIONS URL's ---------------- //
Route::get('position/list', [App\Http\Controllers\PositionController::class, 'getProfiles']);
Route::post('position/create', [App\Http\Controllers\PositionController::class, 'createProfile']);
Route::put('position/update/{id}', [App\Http\Controllers\PositionController::class, 'updateProfile']);
Route::delete('position/delete/{id}', [App\Http\Controllers\PositionController::class, 'deleteProfile']);

// ---------------- JUSTIFICATIONS URL's ---------------- //
Route::get('justification/list', [App\Http\Controllers\JustificationController::class, 'getJustifications']);
Route::post('justification/create', [App\Http\Controllers\JustificationController::class, 'createJustifications']);
Route::delete('justification/delete/{id}', [App\Http\Controllers\JustificationController::class, '']);

Route::post('justification/accept/{id}', [App\Http\Controllers\JustificationController::class, 'acceptJustifications']);
Route::post('justification/decline/{id}', [App\Http\Controllers\JustificationController::class, 'declineJustifications']);

// ---------------- USERS URL´s ---------------------- //
Route::get('users', [App\Http\Controllers\UserController::class, 'index']);
Route::get('users/{id}', [App\Http\Controllers\UserController::class, 'show']);
Route::put('users/{id}/update', [App\Http\Controllers\UserController::class, 'update']);

// ---------------- BIRTHDAYS URL's ---------------- //
Route::get('/birthday/details', [\App\Http\Controllers\BirthdayController::class, 'detailsbirthdayMonth']);
Route::get('/birthday/nextBirthday', [\App\Http\Controllers\BirthdayController::class, 'getUpcomingBirthdaysWithUsers']);

// ---------------- ATTENDANCES URL's --------------- //
Route::post('attendance/index', [App\Http\Controllers\AttendanceController::class, 'index']);
Route::post('attendance/create', [App\Http\Controllers\AttendanceController::class, 'createAttendance']);
});

