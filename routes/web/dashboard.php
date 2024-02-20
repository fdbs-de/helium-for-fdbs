<?php

use App\Http\Controllers\Apps\Wiki\WikiController;
use App\Http\Controllers\Apps\Intranet\CustomerController;
use App\Http\Controllers\Apps\Intranet\EmployeeController;
use App\Http\Controllers\Apps\Intranet\InviteController;
use App\Http\Controllers\Apps\Newsletter\NewsletterController;
use App\Http\Controllers\Apps\Intranet\OverviewController;
use App\Http\Controllers\Apps\Intranet\ProfileController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified.mfa', 'verified', 'enabled', 'active'])->group(function () {
    Route::prefix('dashboard')->group(function () {
        Route::get('/', [OverviewController::class, 'redirect'])->name('dashboard');
        Route::get('/home', [OverviewController::class, 'show']);
    
        Route::get('/profile', [ProfileController::class, 'indexProfile'])->name('dashboard.profile');
        Route::put('/profile/change-password', [ProfileController::class, 'changePassword'])->name('dashboard.profile.change-password');
    
        Route::put('/newsletter', [NewsletterController::class, 'update'])->name('dashboard.newsletter.update');
    
        Route::put('/invite', [InviteController::class, 'update'])->name('dashboard.invite.update');
    
        Route::prefix('intranet')->middleware(['role:Personal'])->group(function () {
            Route::get('/news', [EmployeeController::class, 'indexOverview'])->name('dashboard.employee.overview');
            Route::get('/dokumente', [EmployeeController::class, 'indexDocuments'])->name('dashboard.employee.documents');
        });
    
        Route::prefix('kunden')->middleware(['role:Personal|Kunde'])->group(function () {
            Route::get('/spezifikationen', [CustomerController::class, 'indexSpecs'])->name('dashboard.customer.specs');
            Route::get('/angebote', [CustomerController::class, 'indexOffers'])->name('dashboard.customer.offers');
        });
    });
    
    Route::prefix('wiki')->group(function () {
        Route::get('/', [WikiController::class, 'overview'])->name('wiki');
        Route::get('/{postSlug}', [WikiController::class, 'show'])->name('wiki.entry');
    });
});