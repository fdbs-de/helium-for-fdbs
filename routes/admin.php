<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\NewsletterController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Dashboard\DocumentController;
use App\Http\Controllers\Dashboard\MediaController;
use App\Http\Controllers\Dashboard\PostCategoryController;
use App\Http\Controllers\Dashboard\PostController;
use App\Http\Controllers\Dashboard\SpecController;
use App\Http\Controllers\Dashboard\UserController;
use App\Http\Controllers\Wiki\WikiController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->middleware(['auth', 'verified', 'panelaccess:admin'])->group(function () {
    Route::get('/', [AdminController::class, 'show'])->name('admin');

    Route::prefix('settings')->group(function () {
        Route::get('/', [SettingsController::class, 'index'])->name('admin.settings');
        Route::patch('/', [SettingsController::class, 'update'])->name('admin.settings.update');
    });

    Route::prefix('newsletter')->group(function () {
        Route::get('/search', [NewsletterController::class, 'search'])->name('admin.newsletter.search');
        Route::put('/{user}', [NewsletterController::class, 'update'])->can('update', 'user')->name('admin.newsletter.update');
    });

    Route::prefix('roles')->group(function () {
        Route::get('/', [RoleController::class, 'index'])->name('admin.roles');
        Route::post('/', [RoleController::class, 'store'])->name('admin.roles.store');
        Route::put('/{role}', [RoleController::class, 'update'])->name('admin.roles.update');
        Route::delete('/{role}', [RoleController::class, 'delete'])->name('admin.roles.delete');
    });

    Route::prefix('users')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('admin.users');
        Route::get('/search', [UserController::class, 'search'])->name('admin.users.search');
        Route::get('/editor/{user?}', [UserController::class, 'create'])->name('admin.users.editor');
        Route::post('/', [UserController::class, 'store'])->name('admin.users.store');
        Route::put('/{user}', [UserController::class, 'update'])->name('admin.users.update');
        Route::delete('/', [UserController::class, 'delete'])->name('admin.users.destroy');

        // Route::put('/{user}/enable', [UserController::class, 'enableUser'])->can('enable', 'user')->name('dashboard.admin.users.enable');
        // Route::put('/{user}/disable', [UserController::class, 'disableUser'])->can('disable', 'user')->name('dashboard.admin.users.disable');
        // Route::put('/{user}/assign', [UserController::class, 'assignRole'])->can('manageRole', 'user')->name('dashboard.admin.users.role.assign');
        // Route::put('/{user}/revoke', [UserController::class, 'revokeRole'])->can('manageRole', 'user')->name('dashboard.admin.users.role.revoke');
        // Route::put('/{user}/change-password', [UserController::class, 'changePassword'])->can('update', 'user')->name('dashboard.admin.users.change-password');
    });
    
    Route::get('/spezifikationen', [SpecController::class, 'indexAdmin'])->name('admin.specs');
    Route::post('/spezifikationen/upload', [SpecController::class, 'upload'])->can('create', 'App\Models\Specification')->name('admin.specs.upload');
    Route::post('/spezifikationen/cache', [SpecController::class, 'cache'])->can('create', 'App\Models\Specification')->name('admin.specs.cache');
    Route::delete('/spezifikationen/delete', [SpecController::class, 'delete'])->can('delete', 'App\Models\Specification')->name('admin.specs.delete');
    
    Route::get('/dokumente', [DocumentController::class, 'indexAdmin'])->name('admin.docs');
    Route::get('/dokumente/search', [DocumentController::class, 'search'])->name('admin.docs.search');
    Route::post('/dokumente', [DocumentController::class, 'store'])->name('admin.docs.store');
    Route::put('/dokumente/{document}', [DocumentController::class, 'update'])->name('admin.docs.update');
    Route::delete('/dokumente/{document}', [DocumentController::class, 'delete'])->name('admin.docs.delete');
    
    Route::post('/media', [MediaController::class, 'store'])->name('admin.media.store.file');
    Route::post('/media/directory', [MediaController::class, 'storeDirectory'])->name('admin.media.store.directory');
    Route::put('/media/rename', [MediaController::class, 'rename'])->name('admin.media.rename');
    // Route::put('/media/{media}', [MediaController::class, 'update'])->name('admin.media.update.file');
    Route::delete('/media', [MediaController::class, 'delete'])->name('admin.media.delete');
    // Route::get('/media/search', [MediaController::class, 'search'])->name('admin.media.search');
    Route::get('/media/{path?}', [MediaController::class, 'index'])->name('admin.media');

    Route::get('/posts', [PostController::class, 'index'])->name('admin.posts');
    Route::get('/posts/editor/{post?}', [PostController::class, 'create'])->name('admin.posts.editor');
    Route::post('/posts', [PostController::class, 'store'])->name('admin.posts.store');
    Route::post('/posts/{post}', [PostController::class, 'duplicate'])->name('admin.posts.duplicate');
    Route::put('/posts/{post}', [PostController::class, 'update'])->name('admin.posts.update');
    Route::delete('/posts', [PostController::class, 'delete'])->name('admin.posts.delete');
    
    Route::get('/categories', [PostCategoryController::class, 'index'])->name('admin.categories');
    Route::get('/categories/editor/{category?}', [PostCategoryController::class, 'create'])->name('admin.categories.editor');
    Route::post('/categories', [PostCategoryController::class, 'store'])->name('admin.categories.store');
    Route::post('/categories/{postCategory}', [PostCategoryController::class, 'duplicate'])->name('admin.categories.duplicate');
    Route::put('/categories/{postCategory}', [PostCategoryController::class, 'update'])->name('admin.categories.update');
    Route::delete('/categories', [PostCategoryController::class, 'delete'])->name('admin.categories.delete');
});