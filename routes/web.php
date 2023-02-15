<?php

use App\Http\Controllers\Admin\Apps\Forms\FormController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ContactController;
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

Route::get('/test/{form}', [FormController::class, 'test'])->name('test');
Route::post('/forms/{form}', [FormController::class, 'submit'])->name('forms.form.submit');

Route::get('/', [StaticController::class, 'indexHome'])->name('home');
Route::get('/philosopie', [StaticController::class, 'indexPhilosophie'])->name('philosophie');

Route::prefix('/blog')->group(function () {
    Route::get('/', [BlogController::class, 'index'])->name('blog');
    Route::get('/{categorySlug}/{postSlug}', [BlogController::class, 'show'])->name('blog.article');
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
    Route::get('/technischer-kundendienst', [StaticController::class, 'indexTechnischerKundendienst'])->name('ps.technischer-kundendienst');
    Route::get('/seminare', [StaticController::class, 'indexSeminare'])->name('ps.seminare');
    
    Route::prefix('/marken')->group(function () {
        Route::get('/', [StaticController::class, 'indexMarken'])->name('ps.marken');
        Route::get('/eichenhof', [StaticController::class, 'indexEichenhof'])->name('ps.marken.eichenhof');
        Route::get('/il-campese', [StaticController::class, 'indexIlCampese'])->name('ps.marken.il-campese');
        Route::get('/maxi-france', [StaticController::class, 'indexMaxiFrance'])->name('ps.marken.maxi-france');
    });
});

Route::prefix('/mkbs')->group(function () {
    Route::get('/', [StaticController::class, 'indexMKBS'])->name('mkbs');
    Route::get('/web', [StaticController::class, 'indexMKBSWeb'])->name('mkbs.web');
    Route::get('/social-media', [StaticController::class, 'indexMKBSSocialMedia'])->name('mkbs.social-media');
    Route::get('/print', [StaticController::class, 'indexMKBSPrint'])->name('mkbs.print');
    Route::get('/online', [StaticController::class, 'indexMKBSOnline'])->name('mkbs.online');
    Route::get('/digital', [StaticController::class, 'indexMKBSDigital'])->name('mkbs.digital');
    Route::get('/verkaufsfoerderung', [StaticController::class, 'indexMKBSAdwork'])->name('mkbs.adwork');
});

Route::prefix('/karriere')->group(function () {
    Route::get('/', [JobController::class, 'index'])->name('karriere');
    Route::get('/stellenangebote', [JobController::class, 'index'])->name('karriere.stellenangebote');
    Route::get('/stellenangebote/{postSlug}', [JobController::class, 'show'])->name('karriere.stellenangebote.show');
    Route::get('/bewerben-als/lkw-fahrer', [JobController::class, 'showFunnelFahrer'])->name('karriere.funnel.lkw-fahrer');
    Route::post('/bewerben-als/lkw-fahrer', [JobController::class, 'storeFunnelFahrer'])->name('karriere.funnel.lkw-fahrer.store');
});

Route::get('/kontakt', [ContactController::class, 'index'])->name('kontakt');
Route::post('/kontakt', [ContactController::class, 'store'])->name('kontakt.send');

Route::get('/impressum', [StaticController::class, 'indexImpressum'])->name('impressum');
Route::get('/datenschutz', [StaticController::class, 'indexDatenschutz'])->name('datenschutz');
Route::get('/agbs', [StaticController::class, 'indexAGBS'])->name('agbs');
Route::get('/video-info', [StaticController::class, 'indexVideoInfo'])->name('video-info');

Route::get('docs/{document:slug}', [DocumentController::class, 'show'])->name('docs');
Route::get('docs/{document:slug}/cover', [DocumentController::class, 'showCover'])->name('docs.cover');



require __DIR__.'/auth.php';
require __DIR__.'/dashboard.php';
require __DIR__.'/admin.php';
