<?php

use App\Http\Controllers\Dashboard\OverviewController;
use App\Permissions\Permissions;
use Illuminate\Support\Facades\Route;

Route::prefix('dashboard')->middleware(['auth', 'verified', 'enabled'])->group(function () {
    Route::get('/', [OverviewController::class, 'indexOverview'])->name('dashboard');

    Route::prefix('admin')->middleware('can:'.Permissions::CAN_ACCESS_ADMIN_PANEL)->group(function () {
        Route::get('/', [OverviewController::class, 'indexOverview'])->name('dashboard.admin');
    });

    Route::prefix('mitarbeiter')->middleware('can:'.Permissions::CAN_ACCESS_ADMIN_PANEL)->group(function () {
        Route::get('/', [OverviewController::class, 'indexOverview'])->name('dashboard.employee');
    });

    Route::prefix('kunde')->middleware('can:'.Permissions::CAN_ACCESS_ADMIN_PANEL)->group(function () {
        Route::get('/', [OverviewController::class, 'indexOverview'])->name('dashboard.customer');
    });
});