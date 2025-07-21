<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ObatController;
use App\Http\Controllers\PasienController;
use App\Http\Controllers\KunjunganController;
use App\Http\Controllers\ResepController;

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected Routes
Route::middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('home');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Obat Routes
    Route::resource('obat', ObatController::class);
    
    // Pasien Routes
    Route::resource('pasien', PasienController::class);
    
    // Kunjungan Routes
    Route::resource('kunjungan', KunjunganController::class);
    
    // Resep Routes
    Route::resource('resep', ResepController::class);
    Route::get('/resep/obat/{id}', [ResepController::class, 'getObat'])->name('resep.getObat');
});

// Redirect root to dashboard if authenticated
Route::get('/', function () {
    return redirect()->route('dashboard');
});
