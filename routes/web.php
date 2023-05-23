<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\IzinController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\MapelController;
use App\Http\Controllers\SiswaController;

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



/* Route::get('/', function () {
    return view('aku');
}); */

Route::get('/', [LoginController::class, 'index'])->name('login');
Route::post('/', [LoginController::class, 'authenticate']);
Route::post('/logout', [LoginController::class, 'logout']);

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth');
Route::resource('/user', UserController::class)->middleware('auth');
Route::resource('/siswa', SiswaController::class)->middleware('auth');
Route::resource('/kelas', KelasController::class)->middleware('auth');
Route::get('/kelas/siswa/{id}', [KelasController::class, 'siswa'])->name('kelas.siswa')->middleware('auth');
Route::get('/kelas/jadwal/{id}', [KelasController::class, 'jadwal'])->name('kelas.jadwal')->middleware('auth');
Route::resource('/mapel', MapelController::class)->middleware('auth');
Route::resource('/guru', GuruController::class)->middleware('auth');
Route::resource('/jadwal', JadwalController::class)->middleware('auth');
Route::resource('/izin', IzinController::class)->middleware('auth');
