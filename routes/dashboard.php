<?php

use App\Http\Controllers\Dashboard\AdminController;
use App\Http\Controllers\Dashboard\CustomerController;
use App\Http\Controllers\Dashboard\OverviewController;
use App\Http\Controllers\Dashboard\ProfileController;
use App\Http\Controllers\Dashboard\UserController;
use App\Permissions\Permissions;
use Illuminate\Support\Facades\Route;

Route::prefix('dashboard')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/', [OverviewController::class, 'redirect'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'indexProfile'])->name('dashboard.profile');

    Route::prefix('admin')->middleware(['enabled', 'can:'.Permissions::CAN_ACCESS_ADMIN_PANEL])->group(function () {
        Route::get('/', [AdminController::class, 'redirect'])->name('dashboard.admin');
        Route::get('/users', [UserController::class, 'indexUsers'])->name('dashboard.admin.users');

        Route::put('/users/{user}/enable', [UserController::class, 'enableUser'])->can('enable', 'user')->name('dashboard.admin.users.enable');
        Route::put('/users/{user}/enable/customer', [UserController::class, 'enableCustomer'])->can('enable', 'user')->name('dashboard.admin.users.enable.customer');
        Route::put('/users/{user}/enable/employee', [UserController::class, 'enableEmployee'])->can('enable', 'user')->name('dashboard.admin.users.enable.employee');

        Route::put('/users/{user}/disable', [UserController::class, 'disableUser'])->can('disable', 'user')->name('dashboard.admin.users.disable');
        Route::put('/users/{user}/disable/customer', [UserController::class, 'disableCustomer'])->can('disable', 'user')->name('dashboard.admin.users.disable.customer');
        Route::put('/users/{user}/disable/employee', [UserController::class, 'disableEmployee'])->can('disable', 'user')->name('dashboard.admin.users.disable.employee');

        Route::delete('/users/{user}', [UserController::class, 'destroyUser'])->can('delete', 'user')->name('dashboard.admin.users.destroy');
        Route::delete('/users/{user}/customer', [UserController::class, 'destroyCustomer'])->can('deleteProfile', 'user')->name('dashboard.admin.users.destroy.customer');
        Route::delete('/users/{user}/employee', [UserController::class, 'destroyEmployee'])->can('deleteProfile', 'user')->name('dashboard.admin.users.destroy.employee');
    });

    // Route::prefix('mitarbeiter')->middleware(['enabled:employee'])->group(function () {
    //     Route::get('/', [OverviewController::class, 'indexOverview'])->name('dashboard.employee');
    // });

    Route::prefix('kunde')->middleware(['enabled:customer'])->group(function () {
        Route::get('/', [CustomerController::class, 'redirect'])->name('dashboard.customer');
        Route::get('/spezifikationen', [CustomerController::class, 'create'])->name('dashboard.customer.specs');
        Route::get('/spezifikationen/search/{search?}', [CustomerController::class, 'index'])->name('dashboard.customer.specs.index');
        Route::get('/spezifikationen/download/{name}', [CustomerController::class, 'download'])->name('dashboard.customer.spec.download');
    });
});