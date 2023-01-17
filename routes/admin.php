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
    Route::prefix('blog')->middleware('select.app:blog')->group(function () {
        Route::prefix('posts')->group(function () {
            Route::get('/', [PostController::class, 'index'])->name('admin.blog.posts');
            Route::get('/editor/{post?}', [PostController::class, 'create'])->name('admin.blog.posts.editor');
            Route::post('/', [PostController::class, 'store'])->name('admin.blog.posts.store');
            Route::post('/{post}', [PostController::class, 'duplicate'])->name('admin.blog.posts.duplicate');
            Route::put('/{post}', [PostController::class, 'update'])->name('admin.blog.posts.update');
            Route::delete('/', [PostController::class, 'delete'])->name('admin.blog.posts.delete');
        });
        
        Route::prefix('categories')->group(function () {
            Route::get('/', [PostCategoryController::class, 'index'])->name('admin.blog.categories');
            Route::get('/editor/{category?}', [PostCategoryController::class, 'create'])->name('admin.blog.categories.editor');
            Route::post('/', [PostCategoryController::class, 'store'])->name('admin.blog.categories.store');
            Route::post('/{postCategory}', [PostCategoryController::class, 'duplicate'])->name('admin.blog.categories.duplicate');
            Route::put('/{postCategory}', [PostCategoryController::class, 'update'])->name('admin.blog.categories.update');
            Route::delete('/', [PostCategoryController::class, 'delete'])->name('admin.blog.categories.delete');
        });
    });



    Route::prefix('wiki')->middleware('select.app:wiki')->group(function () {
        Route::prefix('posts')->group(function () {
            Route::get('/', [PostController::class, 'index'])->name('admin.wiki.posts');
            Route::get('/editor/{post?}', [PostController::class, 'create'])->name('admin.wiki.posts.editor');
            Route::post('/', [PostController::class, 'store'])->name('admin.wiki.posts.store');
            Route::post('/{post}', [PostController::class, 'duplicate'])->name('admin.wiki.posts.duplicate');
            Route::put('/{post}', [PostController::class, 'update'])->name('admin.wiki.posts.update');
            Route::delete('/', [PostController::class, 'delete'])->name('admin.wiki.posts.delete');
        });

        Route::prefix('categories')->group(function () {
            Route::get('/', [PostCategoryController::class, 'index'])->name('admin.wiki.categories');
            Route::get('/editor/{category?}', [PostCategoryController::class, 'create'])->name('admin.wiki.categories.editor');
            Route::post('/', [PostCategoryController::class, 'store'])->name('admin.wiki.categories.store');
            Route::post('/{postCategory}', [PostCategoryController::class, 'duplicate'])->name('admin.wiki.categories.duplicate');
            Route::put('/{postCategory}', [PostCategoryController::class, 'update'])->name('admin.wiki.categories.update');
            Route::delete('/', [PostCategoryController::class, 'delete'])->name('admin.wiki.categories.delete');
        });
    });



    Route::prefix('jobs')->middleware('select.app:jobs')->group(function () {
        Route::prefix('posts')->group(function () {
            Route::get('/', [PostController::class, 'index'])->name('admin.jobs.posts');
            Route::get('/editor/{post?}', [PostController::class, 'create'])->name('admin.jobs.posts.editor');
            Route::post('/', [PostController::class, 'store'])->name('admin.jobs.posts.store');
            Route::post('/{post}', [PostController::class, 'duplicate'])->name('admin.jobs.posts.duplicate');
            Route::put('/{post}', [PostController::class, 'update'])->name('admin.jobs.posts.update');
            Route::delete('/', [PostController::class, 'delete'])->name('admin.jobs.posts.delete');
        });

        Route::prefix('categories')->group(function () {
            Route::get('/', [PostCategoryController::class, 'index'])->name('admin.jobs.categories');
            Route::get('/editor/{category?}', [PostCategoryController::class, 'create'])->name('admin.jobs.categories.editor');
            Route::post('/', [PostCategoryController::class, 'store'])->name('admin.jobs.categories.store');
            Route::post('/{postCategory}', [PostCategoryController::class, 'duplicate'])->name('admin.jobs.categories.duplicate');
            Route::put('/{postCategory}', [PostCategoryController::class, 'update'])->name('admin.jobs.categories.update');
            Route::delete('/', [PostCategoryController::class, 'delete'])->name('admin.jobs.categories.delete');
        });
    });



    Route::prefix('intranet')->middleware('select.app:intranet')->group(function () {
        Route::prefix('posts')->group(function () {
            Route::get('/', [PostController::class, 'index'])->name('admin.intranet.posts');
            Route::get('/editor/{post?}', [PostController::class, 'create'])->name('admin.intranet.posts.editor');
            Route::post('/', [PostController::class, 'store'])->name('admin.intranet.posts.store');
            Route::post('/{post}', [PostController::class, 'duplicate'])->name('admin.intranet.posts.duplicate');
            Route::put('/{post}', [PostController::class, 'update'])->name('admin.intranet.posts.update');
            Route::delete('/', [PostController::class, 'delete'])->name('admin.intranet.posts.delete');
        });

        Route::prefix('categories')->group(function () {
            Route::get('/', [PostCategoryController::class, 'index'])->name('admin.intranet.categories');
            Route::get('/editor/{category?}', [PostCategoryController::class, 'create'])->name('admin.intranet.categories.editor');
            Route::post('/', [PostCategoryController::class, 'store'])->name('admin.intranet.categories.store');
            Route::post('/{postCategory}', [PostCategoryController::class, 'duplicate'])->name('admin.intranet.categories.duplicate');
            Route::put('/{postCategory}', [PostCategoryController::class, 'update'])->name('admin.intranet.categories.update');
            Route::delete('/', [PostCategoryController::class, 'delete'])->name('admin.intranet.categories.delete');
        });
    });
});