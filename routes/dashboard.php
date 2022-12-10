<?php

use App\Http\Controllers\Dashboard\AdminController;
use App\Http\Controllers\Dashboard\CustomerController;
use App\Http\Controllers\Dashboard\DocumentController;
use App\Http\Controllers\Dashboard\EmployeeController;
use App\Http\Controllers\Dashboard\MediaController;
use App\Http\Controllers\Dashboard\OverviewController;
use App\Http\Controllers\Dashboard\PostCategoryController;
use App\Http\Controllers\Dashboard\PostController;
use App\Http\Controllers\Dashboard\ProfileController;
use App\Http\Controllers\Dashboard\SpecController;
use App\Http\Controllers\Dashboard\UserController;
use App\Permissions\Permissions;
use Illuminate\Support\Facades\Route;

Route::prefix('dashboard')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/', [OverviewController::class, 'show'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'indexProfile'])->name('dashboard.profile');
    Route::put('/profile/change-password', [ProfileController::class, 'changePassword'])->name('dashboard.profile.change-password');

    Route::prefix('admin')->middleware(['panelaccess:admin'])->group(function () {
        Route::get('/', [AdminController::class, 'redirect'])->name('dashboard.admin');

        Route::get('/users', [UserController::class, 'indexUsers'])->name('dashboard.admin.users');
        Route::post('/users/import', [UserController::class, 'importUsers'])->can('create', 'App\Models\User')->name('dashboard.admin.users.import');
        Route::put('/users/{user}/change-password', [UserController::class, 'changePassword'])->can('update', 'user')->name('dashboard.admin.users.change-password');
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
        
        Route::get('/dokumente', [DocumentController::class, 'indexAdmin'])->name('dashboard.admin.docs');
        Route::get('/dokumente/search', [DocumentController::class, 'search'])->name('dashboard.admin.docs.search');
        Route::post('/dokumente', [DocumentController::class, 'store'])->name('dashboard.admin.docs.store');
        Route::put('/dokumente/{document}', [DocumentController::class, 'update'])->name('dashboard.admin.docs.update');
        Route::delete('/dokumente/{document}', [DocumentController::class, 'delete'])->name('dashboard.admin.docs.delete');
        
        Route::get('/media', [MediaController::class, 'index'])->name('dashboard.admin.media');
        Route::get('/media/search', [MediaController::class, 'search'])->name('dashboard.admin.media.search');
        Route::post('/media', [MediaController::class, 'store'])->name('dashboard.admin.media.store');
        Route::put('/media/{media}', [MediaController::class, 'update'])->name('dashboard.admin.media.update');
        Route::delete('/media/{media}', [MediaController::class, 'delete'])->name('dashboard.admin.media.delete');
        Route::post('/media/directory', [MediaController::class, 'storeDirectory'])->name('dashboard.admin.media.store.directory');
        Route::put('/media/directory', [MediaController::class, 'renameDirectory'])->name('dashboard.admin.media.rename.directory');
        Route::delete('/media/directory', [MediaController::class, 'deleteDirectory'])->name('dashboard.admin.media.delete.directory');

        Route::get('/posts', [PostController::class, 'index'])->name('dashboard.admin.posts');
        Route::post('/posts', [PostController::class, 'store'])->name('dashboard.admin.posts.store');
        Route::put('/posts/{post}', [PostController::class, 'update'])->name('dashboard.admin.posts.update');
        Route::delete('/posts/{post}', [PostController::class, 'delete'])->name('dashboard.admin.posts.delete');

        Route::post('/categories', [PostCategoryController::class, 'store'])->name('dashboard.admin.categories.store');
        Route::put('/categories/{postCategory}', [PostCategoryController::class, 'update'])->name('dashboard.admin.categories.update');
        Route::delete('/categories/{postCategory}', [PostCategoryController::class, 'delete'])->name('dashboard.admin.categories.delete');
    });

    Route::prefix('mitarbeiter')->middleware(['panelaccess:employee'])->group(function () {
        Route::get('/', [EmployeeController::class, 'indexOverview'])->name('dashboard.employee.overview');
        Route::get('/dokumente', [EmployeeController::class, 'indexDocuments'])->name('dashboard.employee.documents');
        Route::get('/qm', [EmployeeController::class, 'indexQM'])->name('dashboard.employee.qm');
    });

    Route::prefix('kunde')->middleware(['panelaccess:customer'])->group(function () {
        Route::get('/', [CustomerController::class, 'redirect'])->name('dashboard.customer');
        Route::get('/spezifikationen', [SpecController::class, 'index'])->name('dashboard.customer.specs');
        Route::get('/spezifikationen/search/{page}/{search?}', [SpecController::class, 'search'])->name('dashboard.customer.specs.search');
        Route::get('/spezifikationen/download/{name}', [SpecController::class, 'download'])->name('dashboard.customer.specs.download');

        Route::get('/angebote', [CustomerController::class, 'indexOffers'])->name('dashboard.customer.offers');
    });
});