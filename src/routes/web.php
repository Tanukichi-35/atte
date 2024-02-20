<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\RestController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::middleware('auth')->group(function () {
Route::middleware('verified')->group(function () {
    Route::get('/', [AuthController::class, 'index']);
});

Route::middleware('auth')->group(function () {
    Route::get('/attendance', [AuthController::class, 'attendance']);
});

Route::middleware('auth')->group(function () {
    Route::get('/attendance/previous/{date}', [AuthController::class, 'attendancePrevious']);
});

Route::middleware('auth')->group(function () {
    Route::get('/attendance/next/{date}', [AuthController::class, 'attendanceNext']);
});

Route::middleware('auth')->group(function () {
    Route::get('/user', [AuthController::class, 'user']);
});

Route::middleware('auth')->group(function () {
    Route::get('/user/{id}', [AuthController::class, 'userAttendance']);
});

Route::post('/work-start', [
    AttendanceController::class, 'workStart'
]);

Route::post('/work-end', [
    AttendanceController::class, 'workEnd'
]);

Route::post('/break-start', [
    RestController::class, 'breakStart'
]);

Route::post('/break-end', [
    RestController::class, 'breakEnd'
]);
