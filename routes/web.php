<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\GuruController;

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
Route::post('/login/proses', [LoginController::class, 'prosesLogin'])->name('login-proses');

Route::group(['middleware' => ['auth']], function() {
    Route::get('/', [DashboardController::class, 'index']);
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/load-guru', [DashboardController::class, 'loadGuru'])->name('dashboard.load-guru');
    Route::get('/dashboard/load-siswa', [DashboardController::class, 'loadSiswa'])->name('dashboard.load-siswa');
    
    Route::get('/kelas', [KelasController::class, 'index'])->name('kelas');
    Route::get('/kelas/load-data', [KelasController::class, 'loadData'])->name('kelas.load-data');
    Route::get('/kelas/get-data', [KelasController::class, 'getData'])->name('kelas.get-data');
    Route::post('/kelas/action-data', [KelasController::class, 'actionData'])->name('kelas.action-data');
    Route::delete('/kelas/delete-data', [KelasController::class, 'deleteData'])->name('kelas.delete-data');

    Route::get('/siswa', [SiswaController::class, 'index'])->name('siswa');
    Route::get('/siswa/load-data', [SiswaController::class, 'loadData'])->name('siswa.load-data');
    Route::get('/siswa/get-data', [SiswaController::class, 'getData'])->name('siswa.get-data');
    Route::post('/siswa/action-data', [SiswaController::class, 'actionData'])->name('siswa.action-data');
    Route::delete('/siswa/delete-data', [SiswaController::class, 'deleteData'])->name('siswa.delete-data');

    Route::get('/guru', [guruController::class, 'index'])->name('guru');
    Route::get('/guru/load-data', [guruController::class, 'loadData'])->name('guru.load-data');
    Route::get('/guru/get-data', [guruController::class, 'getData'])->name('guru.get-data');
    Route::post('/guru/action-data', [guruController::class, 'actionData'])->name('guru.action-data');
    Route::delete('/guru/delete-data', [guruController::class, 'deleteData'])->name('guru.delete-data');
});