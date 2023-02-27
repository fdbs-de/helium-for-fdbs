<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\Apps\Forms\FormController;
use App\Http\Controllers\Admin\Apps\Pages\MenuController;
use App\Http\Controllers\Admin\Apps\Pages\PageController;
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

    Route::get('/generate-dir-cache', [AdminController::class, 'generateDirCache']);

    Route::get('/search-users', [UserController::class, 'searchPublic'])->name('admin.search.users');

    Route::prefix('settings')->group(function () {
        Route::middleware('can:system.view.settings')->group(function () {
            Route::get('/general', [SettingsController::class, 'indexGeneral'])->name('admin.settings.general');
            Route::get('/apps', [SettingsController::class, 'indexApps'])->name('admin.settings.apps');
            Route::get('/media', [SettingsController::class, 'indexMedia'])->name('admin.settings.media');
            Route::get('/legal', [SettingsController::class, 'indexLegal'])->name('admin.settings.legal');
        });

        Route::middleware('can:system.edit.settings')->group(function () {
            Route::patch('/general', [SettingsController::class, 'updateGeneral'])->name('admin.settings.update.general');
            Route::patch('/apps', [SettingsController::class, 'updateApps'])->name('admin.settings.update.apps');
            Route::patch('/media', [SettingsController::class, 'updateMedia'])->name('admin.settings.update.media');
            Route::patch('/legal', [SettingsController::class, 'updateLegal'])->name('admin.settings.update.legal');
        });
    });

    Route::prefix('newsletter')->group(function () {
        Route::get('/search', [NewsletterController::class, 'search'])
        ->middleware('can:system.view.users')
        ->name('admin.newsletter.search');
        
        Route::put('/{user}', [NewsletterController::class, 'update'])
        ->middleware('can:system.edit.users')
        ->name('admin.newsletter.update');
    });

    Route::prefix('users')->group(function () {
        Route::get('/', [UserController::class, 'index'])
        ->middleware('can:system.view.users')
        ->name('admin.users');
        
        Route::get('/search', [UserController::class, 'search'])
        ->middleware('can:system.view.users')
        ->name('admin.users.search');
        
        Route::get('/editor/{user?}', [UserController::class, 'create'])
        ->middleware('can:system.view.users')
        ->name('admin.users.editor');
        
        Route::post('/', [UserController::class, 'store'])
        ->middleware('can:system.create.users')
        ->name('admin.users.store');
        
        Route::put('/{user}', [UserController::class, 'update'])
        ->middleware('can:system.edit.users')
        ->name('admin.users.update');
        
        Route::delete('/', [UserController::class, 'delete'])
        ->middleware('can:system.delete.users')
        ->name('admin.users.delete');
    });

    Route::prefix('roles')->group(function () {
        Route::get('/', [RoleController::class, 'index'])
        ->middleware('can:system.view.roles')
        ->name('admin.roles');
        
        Route::post('/', [RoleController::class, 'store'])
        ->middleware('can:system.create.roles')
        ->name('admin.roles.store');
        
        Route::put('/{role}', [RoleController::class, 'update'])
        ->middleware('can:system.edit.roles')
        ->name('admin.roles.update');
        
        Route::delete('/{role}', [RoleController::class, 'delete'])
        ->middleware('can:system.delete.roles')
        ->name('admin.roles.delete');
    });

    Route::prefix('spezifikationen')->middleware('can:edit specs')->group(function () {
        Route::get('/', [SpecController::class, 'indexAdmin'])->name('admin.specs');
        Route::post('/upload', [SpecController::class, 'upload'])->can('create', 'App\Models\Specification')->name('admin.specs.upload');
        Route::post('/cache', [SpecController::class, 'cache'])->can('create', 'App\Models\Specification')->name('admin.specs.cache');
        Route::delete('/delete', [SpecController::class, 'delete'])->can('delete', 'App\Models\Specification')->name('admin.specs.delete');
    });

    Route::prefix('dokumente')->middleware('can:edit docs')->group(function () {
        Route::get('/', [DocumentController::class, 'indexAdmin'])->name('admin.docs');
        Route::get('/search', [DocumentController::class, 'search'])->name('admin.docs.search');
        Route::post('/', [DocumentController::class, 'store'])->name('admin.docs.store');
        Route::put('/{document}', [DocumentController::class, 'update'])->name('admin.docs.update');
        Route::delete('/{document}', [DocumentController::class, 'delete'])->name('admin.docs.delete');
    });

    Route::prefix('media')->group(function () {
        Route::patch('/cache', [MediaController::class, 'generateMediaCache'])
        ->middleware('can:system.edit.media')
        ->name('admin.media.generate.cache');

        Route::get('/public/{media?}', [MediaController::class, 'indexPublic'])
        ->middleware('can:system.view.media')
        ->name('admin.media');
        
        // Route::get('/search', [MediaController::class, 'search'])
        // ->middleware('can:system.view.media')
        // ->name('admin.media.search');
        
        Route::post('/{media}/files', [MediaController::class, 'storeFiles'])
        ->middleware('can:system.upload.media')
        ->name('admin.media.store.files');
        
        Route::post('/{media}/directory', [MediaController::class, 'storeDirectory'])
        ->middleware('can:system.upload.media')
        ->name('admin.media.store.directory');
        
        Route::put('/{media}/rename', [MediaController::class, 'rename'])
        ->middleware('can:system.edit.media')
        ->name('admin.media.update.rename');
        
        Route::put('/{media}', [MediaController::class, 'update'])
        ->middleware('can:system.edit.media')
        ->name('admin.media.update');
        
        Route::delete('/', [MediaController::class, 'delete'])
        ->middleware('can:system.delete.media')
        ->name('admin.media.delete');
    });



    ////////////
    //  APPS  //
    ////////////
    Route::prefix('pages')->middleware(['can:app.pages.access.admin.panel'])->group(function () {
        Route::prefix('pages')->group(function () {
            Route::get('/', [PageController::class, 'index'])
            ->middleware('can:app.pages.view.pages')
            ->name('admin.pages.pages');

            Route::get('/search', [PageController::class, 'search'])
            ->middleware('can:app.pages.view.pages')
            ->name('admin.pages.pages.search');

            Route::get('/editor/{pages?}', [PageController::class, 'editor'])
            ->middleware('can:app.pages.view.pages')
            ->name('admin.pages.pages.editor');

            Route::post('/', [PageController::class, 'store'])
            ->middleware('can:app.pages.create.pages')
            ->name('admin.pages.pages.store');

            Route::post('/{page}', [PageController::class, 'duplicate'])
            ->middleware('can:app.pages.create.pages')
            ->name('admin.pages.pages.duplicate');

            Route::delete('/', [PageController::class, 'delete'])
            ->middleware('can:app.pages.delete.pages')
            ->name('admin.pages.pages.delete');
        });

        Route::prefix('menus')->group(function () {
            Route::get('/', [MenuController::class, 'index'])
            ->middleware('can:app.pages.view.menus')
            ->name('admin.pages.menus');
        });
    });



    Route::prefix('forms')->middleware(['can:app.forms.access.admin.panel'])->group(function () {
        Route::prefix('forms')->group(function () {
            Route::get('/', [FormController::class, 'index'])
            ->middleware('can:app.forms.view.forms')
            ->name('admin.forms.forms.overview');

            Route::get('/editor/{form?}', [FormController::class, 'editor'])
            ->middleware('can:app.forms.view.forms')
            ->name('admin.forms.forms.editor');

            Route::post('/', [FormController::class, 'store'])
            ->middleware('can:app.forms.create.forms')
            ->name('admin.forms.forms.store');

            Route::put('/{form}', [FormController::class, 'update'])
            ->middleware('can:app.forms.edit.forms')
            ->name('admin.forms.forms.update');

            Route::delete('/', [FormController::class, 'delete'])
            ->middleware('can:app.forms.delete.forms')
            ->name('admin.forms.forms.delete');
        });
    });



    Route::prefix('blog')->middleware(['select.app:blog', 'can:app.blog.access.admin.panel'])->group(function () {
        Route::prefix('posts')->group(function () {
            Route::get('/', [PostController::class, 'index'])
            ->middleware('can:app.blog.view.posts')
            ->name('admin.blog.posts');

            Route::get('/search', [PostController::class, 'search'])
            ->middleware('can:app.blog.view.posts')
            ->name('admin.blog.posts.search');
            
            Route::get('/editor/{post?}', [PostController::class, 'create'])
            ->middleware('can:app.blog.view.posts')
            ->name('admin.blog.posts.editor');
            
            Route::post('/', [PostController::class, 'store'])
            ->middleware('can:app.blog.create.posts')
            ->name('admin.blog.posts.store');
            
            Route::post('/{post}', [PostController::class, 'duplicate'])
            ->middleware('can:app.blog.create.posts')
            ->name('admin.blog.posts.duplicate');
            
            Route::put('/{post}', [PostController::class, 'update'])
            ->middleware('can:app.blog.edit.posts')
            ->name('admin.blog.posts.update');
            
            Route::delete('/', [PostController::class, 'delete'])
            ->middleware('can:app.blog.delete.posts')
            ->name('admin.blog.posts.delete');
        });
        
        Route::prefix('categories')->group(function () {
            Route::get('/', [PostCategoryController::class, 'index'])
            ->middleware('can:app.blog.view.categories')
            ->name('admin.blog.categories');
            
            Route::get('/editor/{category?}', [PostCategoryController::class, 'create'])
            ->middleware('can:app.blog.view.categories')
            ->name('admin.blog.categories.editor');
            
            Route::post('/', [PostCategoryController::class, 'store'])
            ->middleware('can:app.blog.create.categories')
            ->name('admin.blog.categories.store');
            
            Route::post('/{postCategory}', [PostCategoryController::class, 'duplicate'])
            ->middleware('can:app.blog.create.categories')
            ->name('admin.blog.categories.duplicate');
            
            Route::put('/{postCategory}', [PostCategoryController::class, 'update'])
            ->middleware('can:app.blog.edit.categories')
            ->name('admin.blog.categories.update');
            
            Route::delete('/', [PostCategoryController::class, 'delete'])
            ->middleware('can:app.blog.delete.categories')
            ->name('admin.blog.categories.delete');
        });
    });



    Route::prefix('wiki')->middleware(['select.app:wiki', 'can:app.wiki.access.admin.panel'])->group(function () {
        Route::prefix('posts')->group(function () {
            Route::get('/', [PostController::class, 'index'])
            ->middleware('can:app.wiki.view.pages')
            ->name('admin.wiki.posts');

            Route::get('/search', [PostController::class, 'search'])
            ->middleware('can:app.wiki.view.pages')
            ->name('admin.wiki.posts.search');
            
            Route::get('/editor/{post?}', [PostController::class, 'create'])
            ->middleware('can:app.wiki.view.pages')
            ->name('admin.wiki.posts.editor');
            
            Route::post('/', [PostController::class, 'store'])
            ->middleware('can:app.wiki.create.pages')
            ->name('admin.wiki.posts.store');
            
            Route::post('/{post}', [PostController::class, 'duplicate'])
            ->middleware('can:app.wiki.create.pages')
            ->name('admin.wiki.posts.duplicate');
            
            Route::put('/{post}', [PostController::class, 'update'])
            ->middleware('can:app.wiki.edit.pages')
            ->name('admin.wiki.posts.update');
            
            Route::delete('/', [PostController::class, 'delete'])
            ->middleware('can:app.wiki.delete.pages')
            ->name('admin.wiki.posts.delete');
        });

        Route::prefix('categories')->group(function () {
            Route::get('/', [PostCategoryController::class, 'index'])
            ->middleware('can:app.wiki.view.categories')
            ->name('admin.wiki.categories');
            
            Route::get('/editor/{category?}', [PostCategoryController::class, 'create'])
            ->middleware('can:app.wiki.view.categories')
            ->name('admin.wiki.categories.editor');
            
            Route::post('/', [PostCategoryController::class, 'store'])
            ->middleware('can:app.wiki.create.categories')
            ->name('admin.wiki.categories.store');
            
            Route::post('/{postCategory}', [PostCategoryController::class, 'duplicate'])
            ->middleware('can:app.wiki.create.categories')
            ->name('admin.wiki.categories.duplicate');
            
            Route::put('/{postCategory}', [PostCategoryController::class, 'update'])
            ->middleware('can:app.wiki.edit.categories')
            ->name('admin.wiki.categories.update');
            
            Route::delete('/', [PostCategoryController::class, 'delete'])
            ->middleware('can:app.wiki.delete.categories')
            ->name('admin.wiki.categories.delete');
        });
    });



    Route::prefix('jobs')->middleware(['select.app:jobs', 'can:app.jobs.access.admin.panel'])->group(function () {
        Route::prefix('posts')->group(function () {
            Route::get('/', [PostController::class, 'index'])
            ->middleware('can:app.jobs.view.offers')
            ->name('admin.jobs.posts');

            Route::get('/search', [PostController::class, 'search'])
            ->middleware('can:app.jobs.view.offers')
            ->name('admin.jobs.posts.search');
            
            Route::get('/editor/{post?}', [PostController::class, 'create'])
            ->middleware('can:app.jobs.view.offers')
            ->name('admin.jobs.posts.editor');
            
            Route::post('/', [PostController::class, 'store'])
            ->middleware('can:app.jobs.create.offers')
            ->name('admin.jobs.posts.store');
            
            Route::post('/{post}', [PostController::class, 'duplicate'])
            ->middleware('can:app.jobs.create.offers')
            ->name('admin.jobs.posts.duplicate');
            
            Route::put('/{post}', [PostController::class, 'update'])
            ->middleware('can:app.jobs.edit.offers')
            ->name('admin.jobs.posts.update');
            
            Route::delete('/', [PostController::class, 'delete'])
            ->middleware('can:app.jobs.delete.offers')
            ->name('admin.jobs.posts.delete');
        });

        Route::prefix('categories')->group(function () {
            Route::get('/', [PostCategoryController::class, 'index'])
            ->middleware('can:app.jobs.view.categories')
            ->name('admin.jobs.categories');
            
            Route::get('/editor/{category?}', [PostCategoryController::class, 'create'])
            ->middleware('can:app.jobs.view.categories')
            ->name('admin.jobs.categories.editor');
            
            Route::post('/', [PostCategoryController::class, 'store'])
            ->middleware('can:app.jobs.create.categories')
            ->name('admin.jobs.categories.store');
            
            Route::post('/{postCategory}', [PostCategoryController::class, 'duplicate'])
            ->middleware('can:app.jobs.create.categories')
            ->name('admin.jobs.categories.duplicate');
            
            Route::put('/{postCategory}', [PostCategoryController::class, 'update'])
            ->middleware('can:app.jobs.edit.categories')
            ->name('admin.jobs.categories.update');
            
            Route::delete('/', [PostCategoryController::class, 'delete'])
            ->middleware('can:app.jobs.delete.categories')
            ->name('admin.jobs.categories.delete');
        });
    });



    Route::prefix('intranet')->middleware(['select.app:intranet', 'can:app.intranet.access.admin.panel'])->group(function () {
        Route::prefix('posts')->group(function () {
            Route::get('/', [PostController::class, 'index'])
            ->name('admin.intranet.posts');

            Route::get('/search', [PostController::class, 'search'])
            ->middleware('can:app.intranet.view.posts')
            ->name('admin.intranet.posts.search');
            
            Route::get('/editor/{post?}', [PostController::class, 'create'])
            ->middleware('can:app.intranet.view.posts')
            ->name('admin.intranet.posts.editor');
            
            Route::post('/', [PostController::class, 'store'])
            ->middleware('can:app.intranet.create.posts')
            ->name('admin.intranet.posts.store');
            
            Route::post('/{post}', [PostController::class, 'duplicate'])
            ->middleware('can:app.intranet.create.posts')
            ->name('admin.intranet.posts.duplicate');
            
            Route::put('/{post}', [PostController::class, 'update'])
            ->middleware('can:app.intranet.edit.posts')
            ->name('admin.intranet.posts.update');
            
            Route::delete('/', [PostController::class, 'delete'])
            ->middleware('can:app.intranet.delete.posts')
            ->name('admin.intranet.posts.delete');
        });

        Route::prefix('categories')->group(function () {
            Route::get('/', [PostCategoryController::class, 'index'])
            ->middleware('can:app.intranet.view.categories')
            ->name('admin.intranet.categories');
            
            Route::get('/editor/{category?}', [PostCategoryController::class, 'create'])
            ->middleware('can:app.intranet.view.categories')
            ->name('admin.intranet.categories.editor');
            
            Route::post('/', [PostCategoryController::class, 'store'])
            ->middleware('can:app.intranet.create.categories')
            ->name('admin.intranet.categories.store');
            
            Route::post('/{postCategory}', [PostCategoryController::class, 'duplicate'])
            ->middleware('can:app.intranet.create.categories')
            ->name('admin.intranet.categories.duplicate');
            
            Route::put('/{postCategory}', [PostCategoryController::class, 'update'])
            ->middleware('can:app.intranet.edit.categories')
            ->name('admin.intranet.categories.update');
            
            Route::delete('/', [PostCategoryController::class, 'delete'])
            ->middleware('can:app.intranet.delete.categories')
            ->name('admin.intranet.categories.delete');
        });
    });
});