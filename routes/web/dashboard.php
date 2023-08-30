<?php

use App\Http\Controllers\Apps\Wiki\WikiController;
use App\Http\Controllers\Apps\Intranet\CustomerController;
use App\Http\Controllers\Apps\Intranet\EmployeeController;
use App\Http\Controllers\Apps\Intranet\InviteController;
use App\Http\Controllers\Apps\Newsletter\NewsletterController;
use App\Http\Controllers\Apps\Intranet\OverviewController;
use App\Http\Controllers\Apps\Intranet\ProfileController;
use Illuminate\Support\Facades\Route;

Route::prefix('dashboard')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/', [OverviewController::class, 'show'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'indexProfile'])->name('dashboard.profile');
    Route::put('/profile/change-password', [ProfileController::class, 'changePassword'])->name('dashboard.profile.change-password');

    Route::put('/newsletter', [NewsletterController::class, 'update'])->name('dashboard.newsletter.update');

    Route::put('/invite', [InviteController::class, 'update'])->name('dashboard.invite.update');

    Route::prefix('mitarbeiter')->middleware(['panelaccess:employee'])->group(function () {
        Route::get('/', [EmployeeController::class, 'indexOverview'])->name('dashboard.employee.overview');
        Route::get('/dokumente', [EmployeeController::class, 'indexDocuments'])->name('dashboard.employee.documents');
    });

    Route::prefix('kunde')->middleware(['panelaccess:customer'])->group(function () {
        Route::get('/', [CustomerController::class, 'redirect'])->name('dashboard.customer');
        Route::get('/spezifikationen', [CustomerController::class, 'indexSpecs'])->name('dashboard.customer.specs');
        Route::get('/angebote', [CustomerController::class, 'indexOffers'])->name('dashboard.customer.offers');
    });
});



Route::prefix('wiki')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/', [WikiController::class, 'overview'])->name('wiki');
    Route::get('/{postSlug}', [WikiController::class, 'show'])->name('wiki.entry');
});