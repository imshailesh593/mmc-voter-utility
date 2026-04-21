<?php

use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\VoterController;
use App\Http\Controllers\SlipController;
use Illuminate\Support\Facades\Route;

Route::get('/', [VoterController::class, 'index'])->name('home');

// Admin auth (guest only)
Route::prefix('admin')->name('admin.')->middleware('guest')->group(function () {
    Route::get('/login',  [AdminAuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('login.post');
});

// Admin panel (auth required)
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::post('/logout',   [AdminAuthController::class, 'logout'])->name('logout');
    Route::get('/',          [VoterController::class, 'adminDashboard'])->name('dashboard');
    Route::get('/voters',    [VoterController::class, 'adminVoters'])->name('voters');
    Route::get('/branches',  [VoterController::class, 'adminBranches'])->name('branches');
    Route::get('/import',    [VoterController::class, 'adminImport'])->name('import');
    Route::get('/users',     [VoterController::class, 'adminUsers'])->name('users');
});

Route::prefix('slip')->name('slip.')->group(function () {
    Route::get('/download/{id}', [SlipController::class, 'download'])->name('download');
    Route::get('/share/{id}',    [SlipController::class, 'share'])->name('share');
});
