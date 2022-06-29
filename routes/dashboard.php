<?php

use App\Http\Controllers\Dashboard\AdminController;
use App\Http\Controllers\Dashboard\CustomerController;
use App\Http\Controllers\Dashboard\OverviewController;
use App\Http\Controllers\Dashboard\ProfileController;
use App\Http\Controllers\Dashboard\SpecController;
use App\Http\Controllers\Dashboard\UserController;
use App\Permissions\Permissions;
use Illuminate\Support\Facades\Route;

Route::prefix('dashboard')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/', [OverviewController::class, 'redirect'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'indexProfile'])->name('dashboard.profile');

    Route::prefix('admin')->middleware(['panelaccess:admin'])->group(function () {
        Route::get('/', [AdminController::class, 'redirect'])->name('dashboard.admin');

        Route::get('/users', [UserController::class, 'indexUsers'])->name('dashboard.admin.users');
        Route::post('/users/import', [UserController::class, 'importUsers'])->can('create', 'App\Models\User')->name('dashboard.admin.users.import');
        Route::put('/users/{user}/enable', [UserController::class, 'enableUser'])->can('enable', 'user')->name('dashboard.admin.users.enable');
        Route::put('/users/{user}/enable/customer', [UserController::class, 'enableCustomer'])->can('enable', 'user')->name('dashboard.admin.users.enable.customer');
        Route::put('/users/{user}/enable/employee', [UserController::class, 'enableEmployee'])->can('enable', 'user')->name('dashboard.admin.users.enable.employee');
        Route::put('/users/{user}/disable', [UserController::class, 'disableUser'])->can('disable', 'user')->name('dashboard.admin.users.disable');
        Route::put('/users/{user}/disable/customer', [UserController::class, 'disableCustomer'])->can('disable', 'user')->name('dashboard.admin.users.disable.customer');
        Route::put('/users/{user}/disable/employee', [UserController::class, 'disableEmployee'])->can('disable', 'user')->name('dashboard.admin.users.disable.employee');
        Route::put('/users/{user}/assign', [UserController::class, 'assignRole'])->can('manageRole', 'user')->name('dashboard.admin.users.role.assign');
        Route::put('/users/{user}/revoke', [UserController::class, 'revokeRole'])->can('manageRole', 'user')->name('dashboard.admin.users.role.revoke');
        Route::delete('/users/{user}', [UserController::class, 'destroyUser'])->can('delete', 'user')->name('dashboard.admin.users.destroy');
        Route::delete('/users/{user}/customer', [UserController::class, 'destroyCustomer'])->can('deleteProfile', 'user')->name('dashboard.admin.users.destroy.customer');
        Route::delete('/users/{user}/employee', [UserController::class, 'destroyEmployee'])->can('deleteProfile', 'user')->name('dashboard.admin.users.destroy.employee');
        
        Route::get('/spezifikationen', [SpecController::class, 'indexAdmin'])->name('dashboard.admin.specs');
        Route::post('/spezifikationen/upload', [SpecController::class, 'upload'])->can('create', 'App\Models\Specification')->name('dashboard.admin.specs.upload');
        Route::post('/spezifikationen/cache', [SpecController::class, 'cache'])->can('create', 'App\Models\Specification')->name('dashboard.admin.specs.cache');
        Route::delete('/spezifikationen/delete', [SpecController::class, 'delete'])->can('delete', 'App\Models\Specification')->name('dashboard.admin.specs.delete');
    });

    // Route::prefix('mitarbeiter')->middleware(['panelaccess:employee'])->group(function () {
    //     Route::get('/', [OverviewController::class, 'indexOverview'])->name('dashboard.employee');
    // });

    Route::prefix('kunde')->middleware(['panelaccess:customer'])->group(function () {
        Route::get('/', [CustomerController::class, 'redirect'])->name('dashboard.customer');
        Route::get('/spezifikationen', [SpecController::class, 'index'])->name('dashboard.customer.specs');
        Route::get('/spezifikationen/search/{page}/{search?}', [SpecController::class, 'search'])->name('dashboard.customer.specs.search');
        Route::get('/spezifikationen/download/{name}', [SpecController::class, 'download'])->name('dashboard.customer.specs.download');
    });
});