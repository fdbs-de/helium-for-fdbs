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

Route::prefix('admin')->middleware(['auth', 'verified', 'can:system.access.admin.panel'])->group(function () {
    Route::get('/', [AdminController::class, 'show'])->name('admin');

    Route::prefix('settings')->group(function () {
        Route::get('/', [SettingsController::class, 'index'])->name('admin.settings');
        Route::patch('/', [SettingsController::class, 'update'])->name('admin.settings.update');
    });

    Route::prefix('newsletter')->group(function () {
        Route::get('/search', [NewsletterController::class, 'search'])->name('admin.newsletter.search');
        Route::put('/{user}', [NewsletterController::class, 'update'])->can('update', 'user')->name('admin.newsletter.update');
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

    Route::prefix('roles')->group(function () {
        Route::get('/', [RoleController::class, 'index'])->name('admin.roles');
        Route::post('/', [RoleController::class, 'store'])->name('admin.roles.store');
        Route::put('/{role}', [RoleController::class, 'update'])->name('admin.roles.update');
        Route::delete('/{role}', [RoleController::class, 'delete'])->name('admin.roles.delete');
    });

    Route::prefix('spezifikationen')->group(function () {
        Route::get('/', [SpecController::class, 'indexAdmin'])->name('admin.specs');
        Route::post('/upload', [SpecController::class, 'upload'])->can('create', 'App\Models\Specification')->name('admin.specs.upload');
        Route::post('/cache', [SpecController::class, 'cache'])->can('create', 'App\Models\Specification')->name('admin.specs.cache');
        Route::delete('/delete', [SpecController::class, 'delete'])->can('delete', 'App\Models\Specification')->name('admin.specs.delete');
    });

    Route::prefix('dokumente')->group(function () {
        Route::get('/', [DocumentController::class, 'indexAdmin'])->name('admin.docs');
        Route::get('/search', [DocumentController::class, 'search'])->name('admin.docs.search');
        Route::post('/', [DocumentController::class, 'store'])->name('admin.docs.store');
        Route::put('/{document}', [DocumentController::class, 'update'])->name('admin.docs.update');
        Route::delete('/{document}', [DocumentController::class, 'delete'])->name('admin.docs.delete');
    });

    Route::prefix('media')->group(function () {
        Route::post('/', [MediaController::class, 'store'])->name('admin.media.store.file');
        Route::post('/directory', [MediaController::class, 'storeDirectory'])->name('admin.media.store.directory');
        Route::put('/rename', [MediaController::class, 'rename'])->name('admin.media.rename');
        // Route::put('/{media}', [MediaController::class, 'update'])->name('admin.media.update.file');
        Route::delete('/', [MediaController::class, 'delete'])->name('admin.media.delete');
        // Route::get('/search', [MediaController::class, 'search'])->name('admin.media.search');
        Route::get('/{path?}', [MediaController::class, 'index'])->name('admin.media');
    });



    ////////////
    //  APPS  //
    ////////////
    // Route::prefix('blog')->middleware('select_app:blog')->group(function () {
    //     Route::prefix('posts')->group(function () {
    //         Route::get('/', [PostController::class, 'index'])->name('admin.blog.posts');
    //         Route::get('/editor/{post?}', [PostController::class, 'create'])->name('admin.blog.posts.editor');
    //         Route::post('/', [PostController::class, 'store'])->name('admin.blog.posts.store');
    //         Route::post('/{post}', [PostController::class, 'duplicate'])->name('admin.blog.posts.duplicate');
    //         Route::put('/{post}', [PostController::class, 'update'])->name('admin.blog.posts.update');
    //         Route::delete('/', [PostController::class, 'delete'])->name('admin.blog.posts.delete');
    //     });
        
    //     Route::prefix('categories')->group(function () {
    //         Route::get('/', [PostCategoryController::class, 'index'])->name('admin.blog.categories');
    //         Route::get('/editor/{category?}', [PostCategoryController::class, 'create'])->name('admin.blog.categories.editor');
    //         Route::post('/', [PostCategoryController::class, 'store'])->name('admin.blog.categories.store');
    //         Route::post('/{postCategory}', [PostCategoryController::class, 'duplicate'])->name('admin.blog.categories.duplicate');
    //         Route::put('/{postCategory}', [PostCategoryController::class, 'update'])->name('admin.blog.categories.update');
    //         Route::delete('/', [PostCategoryController::class, 'delete'])->name('admin.blog.categories.delete');
    //     });
    // });

    Route::prefix('posts')->group(function () {
        Route::get('/', [PostController::class, 'index'])->name('admin.posts');
        Route::get('/editor/{post?}', [PostController::class, 'create'])->name('admin.posts.editor');
        Route::post('/', [PostController::class, 'store'])->name('admin.posts.store');
        Route::post('/{post}', [PostController::class, 'duplicate'])->name('admin.posts.duplicate');
        Route::put('/{post}', [PostController::class, 'update'])->name('admin.posts.update');
        Route::delete('/', [PostController::class, 'delete'])->name('admin.posts.delete');
    });

    Route::prefix('categories')->group(function () {
        Route::get('/', [PostCategoryController::class, 'index'])->name('admin.categories');
        Route::get('/editor/{category?}', [PostCategoryController::class, 'create'])->name('admin.categories.editor');
        Route::post('/', [PostCategoryController::class, 'store'])->name('admin.categories.store');
        Route::post('/{postCategory}', [PostCategoryController::class, 'duplicate'])->name('admin.categories.duplicate');
        Route::put('/{postCategory}', [PostCategoryController::class, 'update'])->name('admin.categories.update');
        Route::delete('/', [PostCategoryController::class, 'delete'])->name('admin.categories.delete');
    });
});