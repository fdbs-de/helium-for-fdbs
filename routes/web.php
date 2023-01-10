<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\Dashboard\DocumentController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\StaticController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Warning for IE users
Route::view('/ie', 'ie')->name('ie');

Route::get('/', [StaticController::class, 'indexHome'])->name('home');
Route::get('/philosopie', [StaticController::class, 'indexPhilosophie'])->name('philosophie');

Route::prefix('/blog')->group(function () {
    Route::get('/', [BlogController::class, 'index'])->name('blog');
    Route::get('/{post:slug}', [BlogController::class, 'show'])->name('blog.article');
});

Route::prefix('/produkte-und-services')->group(function () {
    Route::get('/', [StaticController::class, 'indexProdukteUndServices'])->name('produkte-und-services');
    Route::get('/angebote', [StaticController::class, 'indexAngebote'])->name('ps.angebote');
    Route::prefix('/foodservice')->group(function () {
        Route::get('/', [StaticController::class, 'indexFoodservice'])->name('ps.foodservice');
        Route::get('/mehrwegpflicht', [StaticController::class, 'indexMehrwegpflicht'])->name('ps.mehrwegpflicht');
    });
    Route::get('/fachberatung-kaese-und-salate', [StaticController::class, 'indexFachberatungKaeseSalate'])->name('ps.fachberatung-kaese-und-salate');
    Route::get('/marketing-und-kommunikation', [StaticController::class, 'indexMarketingKommunikation'])->name('ps.marketing-und-kommunikation');
    // Route::get('/mkbs', [StaticController::class, 'indexMKBS'])->name('ps.mkbs');
    Route::get('/technischer-kundendienst', [StaticController::class, 'indexTechnischerKundendienst'])->name('ps.technischer-kundendienst');
    Route::get('/seminare', [StaticController::class, 'indexSeminare'])->name('ps.seminare');
    
    Route::prefix('/marken')->group(function () {
        Route::get('/', [StaticController::class, 'indexMarken'])->name('ps.marken');
        Route::get('/eichenhof', [StaticController::class, 'indexEichenhof'])->name('ps.marken.eichenhof');
        Route::get('/il-campese', [StaticController::class, 'indexIlCampese'])->name('ps.marken.il-campese');
        Route::get('/maxi-france', [StaticController::class, 'indexMaxiFrance'])->name('ps.marken.maxi-france');
    });
});

Route::prefix('/karriere')->group(function () {
    Route::get('/', [JobController::class, 'index'])->name('karriere');
    Route::get('/stellenangebote', [JobController::class, 'index'])->name('karriere.stellenangebote');
    Route::get('/stellenangebote/{post:slug}', [JobController::class, 'show'])->name('karriere.stellenangebote.show');
    Route::get('/bewerben-als/lkw-fahrer', [JobController::class, 'showFunnelFahrer'])->name('karriere.funnel.lkw-fahrer');
    Route::post('/bewerben-als/lkw-fahrer', [JobController::class, 'storeFunnelFahrer'])->name('karriere.funnel.lkw-fahrer.store');
});

Route::get('/kontakt', [StaticController::class, 'indexKontakt'])->name('kontakt');
Route::post('/kontakt', [StaticController::class, 'storeKontakt'])->name('kontakt.send');

Route::get('/impressum', [StaticController::class, 'indexImpressum'])->name('impressum');
Route::get('/datenschutz', [StaticController::class, 'indexDatenschutz'])->name('datenschutz');
Route::get('/agbs', [StaticController::class, 'indexAGBS'])->name('agbs');
Route::get('/video-info', [StaticController::class, 'indexVideoInfo'])->name('video-info');

Route::get('docs/{document:slug}', [DocumentController::class, 'show'])->name('docs');
Route::get('docs/{document:slug}/cover', [DocumentController::class, 'showCover'])->name('docs.cover');



require __DIR__.'/auth.php';
require __DIR__.'/dashboard.php';
require __DIR__.'/admin.php';
