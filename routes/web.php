<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmailVerificationController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Vendor\DashboardController as VendorDashboard;
use App\Http\Controllers\Customer\DashboardController as CustomerDashboard;

Route::get('/', function () {
    return view('home');
});

// Guest routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    
    // Password Reset Routes
    Route::get('/forgot-password', [\App\Http\Controllers\PasswordResetController::class, 'showForgotForm'])->name('password.request');
    Route::post('/forgot-password', [\App\Http\Controllers\PasswordResetController::class, 'sendResetLink'])->name('password.email');
    Route::get('/reset-password/{token}', [\App\Http\Controllers\PasswordResetController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [\App\Http\Controllers\PasswordResetController::class, 'resetPassword'])->name('password.update');
});

// Authenticated routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // Email Verification Routes
    Route::get('/email/verify', [EmailVerificationController::class, 'notice'])->name('verification.notice');
    Route::get('/email/verify/{id}/{hash}', [EmailVerificationController::class, 'verify'])->middleware('signed')->name('verification.verify');
    Route::post('/email/verification-notification', [EmailVerificationController::class, 'resend'])->name('verification.send');
    
    // Admin routes
    Route::middleware(['role:admin', 'verified'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');
        Route::get('/customers', [AdminDashboard::class, 'customers'])->name('customers');
        Route::get('/vendors', [AdminDashboard::class, 'vendors'])->name('vendors');
        Route::delete('/users/{id}', [AdminDashboard::class, 'deleteUser'])->name('users.delete');
        Route::post('/users/{id}/toggle-status', [AdminDashboard::class, 'toggleUserStatus'])->name('users.toggle');
    });
    
    // Vendor routes
    Route::middleware(['role:vendor', 'verified'])->prefix('vendor')->name('vendor.')->group(function () {
        Route::get('/dashboard', [VendorDashboard::class, 'index'])->name('dashboard');
    });
    
    // Customer routes
    Route::middleware(['role:customer', 'verified'])->prefix('customer')->name('customer.')->group(function () {
        Route::get('/dashboard', [CustomerDashboard::class, 'index'])->name('dashboard');
    });
});

