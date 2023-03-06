<?php

use App\Http\Controllers\Dashboard\Apps\Wiki\WikiController;
use App\Http\Controllers\Dashboard\CustomerController;
use App\Http\Controllers\Dashboard\EmployeeController;
use App\Http\Controllers\Dashboard\NewsletterController;
use App\Http\Controllers\Dashboard\OverviewController;
use App\Http\Controllers\Dashboard\ProfileController;
use App\Http\Controllers\Dashboard\SpecController;
use Illuminate\Support\Facades\Route;

Route::prefix('dashboard')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/', [OverviewController::class, 'show'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'indexProfile'])->name('dashboard.profile');
    Route::put('/profile/change-password', [ProfileController::class, 'changePassword'])->name('dashboard.profile.change-password');

    Route::put('/newsletter', [NewsletterController::class, 'update'])->name('dashboard.newsletter.update');

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



Route::prefix('wiki')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/', [WikiController::class, 'overview'])->name('wiki');
    Route::get('/{categorySlug}/{postSlug}', [WikiController::class, 'show'])->name('wiki.entry');
});