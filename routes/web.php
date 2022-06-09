<?php

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

Route::get('/', [StaticController::class, 'indexHome'])->name('home');
Route::get('/philosopie', [StaticController::class, 'indexPhilosophie'])->name('philosophie');
Route::prefix('/produkte-und-services')->group(function () {
    Route::get('/', [StaticController::class, 'indexProdukteUndServices'])->name('produkte-und-services');
    Route::get('/foodservice', [StaticController::class, 'indexFoodservice'])->name('foodservice');
    Route::get('/unsere-marken', [StaticController::class, 'indexUnsereMarken'])->name('unsere-marken');
    Route::get('/fachberatung-kaese-und-salate', [StaticController::class, 'indexFachberatungKaeseSalate'])->name('fachberatung-kaese-und-salate');
    Route::get('/marketing-und-kommunikation', [StaticController::class, 'indexMarketingKommunikation'])->name('marketing-und-kommunikation');
    Route::get('/technischer-kundendienst', [StaticController::class, 'indexTechnischerKundendienst'])->name('technischer-kundendienst');
    Route::get('/seminare', [StaticController::class, 'indexSeminare'])->name('seminare');
});
Route::get('/karriere', [StaticController::class, 'indexKarriere'])->name('karriere');
Route::get('/kontakt', [StaticController::class, 'indexKontakt'])->name('kontakt');

Route::get('/impressum', [StaticController::class, 'indexImpressum'])->name('impressum');
Route::get('/datenschutz', [StaticController::class, 'indexDatenschutz'])->name('datenschutz');
Route::get('/agbs', [StaticController::class, 'indexAGBS'])->name('agbs');
Route::get('/video-info', [StaticController::class, 'indexVideoInfo'])->name('video-info');

require __DIR__.'/auth.php';
require __DIR__.'/dashboard.php';
