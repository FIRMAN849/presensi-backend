<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\IzinController;
use App\Http\Controllers\API\JadwalController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\AbsensiController;


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




Route::post('login', [UserController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('user', [UserController::class, 'fetch']);
    Route::post('updateprofile/{id}', [UserController::class, 'update']);
    Route::post('updatepassword/{id}', [UserController::class, 'updatepassword']);
    Route::post('logout', [UserController::class, 'logout']);
    // Route::get('jadwal', [UserController::class, 'schedules']);

    Route::post('izin', [IzinController::class, 'create']);
    Route::get('izin/history/{id}', [IzinController::class, 'history']);

    Route::get('jadwal', [JadwalController::class, 'schedules']);
    
    Route::post('presensi', [AbsensiController::class, 'presensi']);
    Route::get('presensi/history/{id}', [AbsensiController::class, 'history']);
});