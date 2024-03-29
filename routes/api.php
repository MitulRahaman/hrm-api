<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Attendance\AttendanceController;
use App\Http\Controllers\Requisition\RequisitionController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/login', [AuthController::class, 'authentication'])->name('login');

Route::group(['middleware'=> 'auth:api'], function() {
    Route::post('/clock_in', [AttendanceController::class, 'clockIn']);
    Route::post('/clock_out', [AttendanceController::class, 'clockOut']);
    Route::post('/requisition', [RequisitionController::class, 'requestRequisition']);
});
