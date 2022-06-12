<?php

use App\Http\Controllers\Dashboard\OverviewController;
use App\Http\Controllers\Dashboard\UserController;
use App\Permissions\Permissions;
use Illuminate\Support\Facades\Route;

Route::prefix('dashboard')->middleware(['auth', 'verified', 'enabled'])->group(function () {
    Route::get('/', [OverviewController::class, 'indexOverview'])->name('dashboard');

    Route::prefix('admin')->middleware('can:'.Permissions::CAN_ACCESS_ADMIN_PANEL)->group(function () {
        Route::get('/', [OverviewController::class, 'indexOverview'])->name('dashboard.admin');
        Route::get('/users', [UserController::class, 'indexUsers'])->name('dashboard.admin.users');
        Route::put('/users/{user}', [UserController::class, 'enableUser'])->can('enable', 'user')->name('dashboard.admin.users.enable');
    });

    Route::prefix('mitarbeiter')->middleware('can:'.Permissions::CAN_ACCESS_ADMIN_PANEL)->group(function () {
        Route::get('/', [OverviewController::class, 'indexOverview'])->name('dashboard.employee');
    });

    Route::prefix('kunde')->middleware('can:'.Permissions::CAN_ACCESS_ADMIN_PANEL)->group(function () {
        Route::get('/', [OverviewController::class, 'indexOverview'])->name('dashboard.customer');
    });

    Route::get('/profile', [OverviewController::class, 'indexOverview'])->name('dashboard.profile');
});