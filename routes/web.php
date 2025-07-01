<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\SekolahController;
use App\Http\Controllers\AdminAssignVendorController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public routes
Route::get('/', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('forgot-password');
Route::post('/forgot-password', [AuthController::class, 'forgotPassword'])->name('forgot-password.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected routes
Route::middleware(['auth'])->group(function () {
    Route::get('/home', [PenggunaController::class, 'home'])->name('home');
});

// Admin routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/first-page', [AdminController::class, 'firstPage'])->name('first-page');
    Route::get('/penghantaran', [AdminController::class, 'penghantaran'])->name('penghantaran');
    Route::get('/dalam-proses', [AdminController::class, 'dalamProses'])->name('dalam-proses');
    Route::get('/selesai', [AdminController::class, 'selesai'])->name('selesai');
    Route::get('/senarai-pengguna', [AdminController::class, 'senaraiPengguna'])->name('senarai-pengguna');
    Route::get('/senarai-vendor', [AdminController::class, 'senaraiVendor'])->name('senarai-vendor');
    Route::get('/statistik', [AdminController::class, 'statistik'])->name('statistik');
    
    // Assign vendor routes
    Route::get('/assign-vendor/{penghantaran}', [AdminAssignVendorController::class, 'showAssignForm'])->name('assign-vendor.form');
    Route::post('/assign-vendor', [AdminAssignVendorController::class, 'assignVendor'])->name('assign-vendor');
    
    // Penghantaran management
    Route::put('/penghantaran/{penghantaran}', [AdminController::class, 'updatePenghantaran'])->name('update-penghantaran');
    Route::delete('/penghantaran/{penghantaran}', [AdminController::class, 'deletePenghantaran'])->name('delete-penghantaran');
});

// Vendor routes
Route::middleware(['auth', 'vendor'])->prefix('vendor')->name('vendor.')->group(function () {
    Route::get('/dashboard', [VendorController::class, 'dashboard'])->name('dashboard');
    Route::get('/first-page', [VendorController::class, 'firstPage'])->name('first-page');
    Route::get('/penghantaran', [VendorController::class, 'penghantaran'])->name('penghantaran');
    Route::get('/kutipan', [VendorController::class, 'kutipan'])->name('kutipan');
    Route::put('/penghantaran/{penghantaran}', [VendorController::class, 'updatePenghantaran'])->name('update-penghantaran');
});

// Pengguna routes
Route::middleware(['auth', 'pengguna'])->prefix('pengguna')->name('pengguna.')->group(function () {
    Route::get('/dashboard', [PenggunaController::class, 'dashboard'])->name('dashboard');
    Route::get('/penghantaran', [PenggunaController::class, 'penghantaran'])->name('penghantaran');
    Route::get('/recycle-info', [PenggunaController::class, 'recycleInfo'])->name('recycle-info');
    Route::get('/home', [PenggunaController::class, 'home'])->name('home');
    Route::get('/program', [PenggunaController::class, 'program'])->name('program');
    Route::get('/lokasi', [PenggunaController::class, 'lokasi'])->name('lokasi');
    Route::get('/first-page', [PenggunaController::class, 'firstPage'])->name('first-page');
});

// Sekolah routes
Route::middleware(['auth', 'sekolah'])->prefix('sekolah')->name('sekolah.')->group(function () {
    Route::get('/dashboard', [SekolahController::class, 'dashboard'])->name('dashboard');
    Route::get('/penghantaran', [SekolahController::class, 'penghantaran'])->name('penghantaran');
    Route::get('/first-page', [SekolahController::class, 'firstPage'])->name('first-page');
}); 