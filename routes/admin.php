<?php

use App\Http\Controllers\Dashboard\AdminController;
use App\Http\Controllers\Dashboard\DocumentController;
use App\Http\Controllers\Dashboard\MediaController;
use App\Http\Controllers\Dashboard\PostCategoryController;
use App\Http\Controllers\Dashboard\PostController;
use App\Http\Controllers\Dashboard\SpecController;
use App\Http\Controllers\Dashboard\UserController;
use App\Permissions\Permissions;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->middleware(['auth', 'verified', 'panelaccess:admin'])->group(function () {
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
    
    Route::post('/media', [MediaController::class, 'store'])->name('admin.media.store.file');
    Route::post('/media/directory', [MediaController::class, 'storeDirectory'])->name('admin.media.store.directory');
    Route::put('/media/rename', [MediaController::class, 'rename'])->name('admin.media.rename');
    // Route::put('/media/{media}', [MediaController::class, 'update'])->name('admin.media.update.file');
    Route::delete('/media', [MediaController::class, 'delete'])->name('admin.media.delete');
    // Route::get('/media/search', [MediaController::class, 'search'])->name('admin.media.search');
    Route::get('/media/{path?}', [MediaController::class, 'index'])->name('admin.media');

    Route::get('/posts', [PostController::class, 'index'])->name('dashboard.admin.posts');
    Route::post('/posts', [PostController::class, 'store'])->name('dashboard.admin.posts.store');
    Route::put('/posts/{post}', [PostController::class, 'update'])->name('dashboard.admin.posts.update');
    Route::delete('/posts/{post}', [PostController::class, 'delete'])->name('dashboard.admin.posts.delete');

    Route::post('/categories', [PostCategoryController::class, 'store'])->name('dashboard.admin.categories.store');
    Route::put('/categories/{postCategory}', [PostCategoryController::class, 'update'])->name('dashboard.admin.categories.update');
    Route::delete('/categories/{postCategory}', [PostCategoryController::class, 'delete'])->name('dashboard.admin.categories.delete');
});