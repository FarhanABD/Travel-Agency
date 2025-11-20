<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('admin')->group(function () {
    
    Route::get('/dashboard', [\App\Http\Controllers\Admin\AdminAuthController::class, 'dashboard'])->name('admin_dashboard');
   Route::get('/profile', [\App\Http\Controllers\Admin\AdminAuthController::class, 'profile'])->name('admin_profile');
   Route::post('/profile', [\App\Http\Controllers\Admin\AdminAuthController::class, 'profile_submit'])->name('admin_profile_submit');
});

Route::prefix('admin')->group(function () {
    Route::get('/login', [\App\Http\Controllers\Admin\AdminAuthController::class, 'login'])->name('admin_login');
    Route::get('/forget-password', [\App\Http\Controllers\Admin\AdminAuthController::class, 'forgetPassword'])->name('admin_forget_password');
    Route::get('/reset-password./{token}/{email}', [\App\Http\Controllers\Admin\AdminAuthController::class, 'resetPassword'])->name('admin_reset_password');
    Route::post('/login',[\App\Http\Controllers\Admin\AdminAuthController::class,'login_submit'])->name('admin_login_submit');
    Route::get('/login', [\App\Http\Controllers\Admin\AdminAuthController::class, 'login'])->name('admin_login');
    Route::get('/logout', [\App\Http\Controllers\Admin\AdminAuthController::class, 'logout'])->name('admin.logout');
    Route::post('/forget-password', [\App\Http\Controllers\Admin\AdminAuthController::class, 'forget_password_submit'])->name('admin_forget_password_submit');
    Route::post('/reset-password/{token}/{email}',[\App\Http\Controllers\Admin\AdminAuthController::class, 'reset_password_submit'])->name('admin_reset_password_submit');
});