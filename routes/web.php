<?php

use App\Http\Controllers\Admin\Media\MediaController;
use App\Http\Controllers\Apps\Blog\BlogController;
use App\Http\Controllers\Apps\Fairs\FairController;
use App\Http\Controllers\Apps\Forms\FormController;
use App\Http\Controllers\Apps\Jobs\JobController;
use App\Http\Controllers\Apps\Pages\PageController;
use App\Http\Controllers\Apps\Static\ContactController;
use App\Http\Controllers\Apps\Static\StaticController;
use App\Http\Controllers\Apps\Static\SurveyController;
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

require __DIR__ . '/web/auth.php';
require __DIR__ . '/web/dashboard.php';
require __DIR__ . '/web/admin.php';

// Forms App
Route::get('/forms/{form}', [FormController::class, 'fetch'])->name('forms.form.fetch');
Route::post('/forms/{form}', [FormController::class, 'submit'])->name('forms.form.submit');

// Blog App
Route::prefix('/blog')->group(function () {
    Route::get('/', [BlogController::class, 'index'])->name('blog');
    Route::get('/{postSlug}', [BlogController::class, 'show'])->name('blog.article');
});

// Job App
Route::prefix('/karriere')->group(function () {
    Route::get('/', [JobController::class, 'index'])->name('karriere');
    Route::get('/stellenangebote', [JobController::class, 'index'])->name('karriere.stellenangebote');
    Route::get('/stellenangebote/{postSlug}', [JobController::class, 'show'])->name('karriere.stellenangebote.show');
    Route::get('/bewerben-als/{slug}', [JobController::class, 'showFunnel'])->name('karriere.funnel.show');
    Route::post('/bewerben-als/{slug}', [JobController::class, 'storeFunnel'])->name('karriere.funnel.store');
});

// Media
Route::get('/storage/media/thumbnails/{media}', [MediaController::class, 'showThumbnail']);
Route::get('/storage/{driveAlias}/{media}/index', [MediaController::class, 'indexPublic']);
Route::get('/storage/{driveAlias}/{media}', [MediaController::class, 'showPublic']);



// Static Pages
Route::get('/', [StaticController::class, 'indexHome'])->name('home');
Route::get('/philosophie', [StaticController::class, 'indexPhilosophie'])->name('philosophie');
Route::get('/nachhaltigkeit', [StaticController::class, 'indexNachhaltigkeit'])->name('nachhaltigkeit');
Route::get('/ci', [StaticController::class, 'indexCI'])->middleware(['auth', 'verified', 'panelaccess:employee'])->name('ci');

Route::get('/angebote', [StaticController::class, 'indexAngebote'])->name('ps.angebote');
Route::prefix('/produkte-und-services')->group(function () {
    Route::get('/', [StaticController::class, 'indexProdukteUndServices'])->name('produkte-und-services');

    Route::prefix('/foodservice')->group(function () {
        Route::get('/', [StaticController::class, 'indexFoodservice'])->name('ps.foodservice');
        // Route::get('/aktuelles', [StaticController::class, 'indexFoodserviceAktuelles'])->name('ps.foodservice.aktuelles');
        Route::get('/tierhaltungskennzeichnung', [StaticController::class, 'indexTierhaltungskennzeichnung'])->name('ps.tierhaltungskennzeichnung');
        Route::get('/mehrwegpflicht', [StaticController::class, 'indexMehrwegpflicht'])->name('ps.mehrwegpflicht');
    });

    Route::get('/fachberatung-kaese-und-salate', [StaticController::class, 'indexFachberatungKaeseSalate'])->name('ps.fachberatung-kaese-und-salate');

    Route::prefix('/technischer-kundendienst')->group(function () {
        Route::get('/', [StaticController::class, 'indexTechnischerKundendienst'])->name('ps.technischer-kundendienst');
        Route::get('/aktuelles', [StaticController::class, 'indexTechnischerKundendienstAktuelles'])->name('ps.technischer-kundendienst.aktuelles');
    });
    
    Route::prefix('/marken')->group(function () {
        Route::get('/', [StaticController::class, 'indexMarken'])->name('ps.marken');
        Route::get('/eichenhof', [StaticController::class, 'indexEichenhof'])->name('ps.marken.eichenhof');
        Route::get('/il-campese', [StaticController::class, 'indexIlCampese'])->name('ps.marken.il-campese');
        Route::get('/maxi-france', [StaticController::class, 'indexMaxiFrance'])->name('ps.marken.maxi-france');
    });
});
Route::redirect('/tierhaltungskennzeichnung', '/produkte-und-services/foodservice/tierhaltungskennzeichnung', 301);

// Route::prefix('/seminare')->group(function () {
//     Route::get('/', [StaticController::class, 'indexSeminare'])->name('seminare');
//     // Route::get('/grillseminar-2023', [StaticController::class, 'indexSeminareGrillseminar'])->name('seminare.grillseminar');
//     // Route::get('/kreativworkshop-2023', [StaticController::class, 'indexSeminareKreativworkshop'])->name('seminare.kreativworkshop');
//     // Route::get('/catering-2023', [StaticController::class, 'indexSeminareCatering'])->name('seminare.catering');
//     // Route::get('/kaeseworkshop-2023', [StaticController::class, 'indexSeminareKaeseworkshop'])->name('seminare.kaeseworkshop');
//     // Route::get('/employer-branding-2023', [StaticController::class, 'indexSeminareEmployerBranding'])->name('seminare.employer-branding');
// });

Route::prefix('/mkbs')->group(function () {
    Route::get('/', [StaticController::class, 'indexMKBS'])->name('mkbs');
    // Route::get('/aktuelles', [StaticController::class, 'indexMKBSAktuelles'])->name('mkbs.aktuelles');
    Route::get('/personal', [StaticController::class, 'indexMKBSRecruiting'])->name('mkbs.recruiting');
    Route::get('/web', [StaticController::class, 'indexMKBSWeb'])->name('mkbs.web');
    Route::get('/social-media', [StaticController::class, 'indexMKBSSocialMedia'])->name('mkbs.social-media');
    Route::get('/print', [StaticController::class, 'indexMKBSPrint'])->name('mkbs.print');
    Route::get('/crossmedia', [StaticController::class, 'indexMKBSCrossmedia'])->name('mkbs.crossmedia');
});

Route::get('/kontakt', [ContactController::class, 'index'])->name('kontakt');
Route::post('/kontakt', [ContactController::class, 'store'])->name('kontakt.send');

Route::get('/impressum', [StaticController::class, 'indexImpressum'])->name('impressum');
Route::get('/datenschutz', [StaticController::class, 'indexDatenschutz'])->name('datenschutz');
Route::get('/agbs', [StaticController::class, 'indexAGBS'])->name('agbs');
Route::get('/video-info', [StaticController::class, 'indexVideoInfo'])->name('video-info');
Route::get('/gewinnspiel/teilnahmebedingungen', [StaticController::class, 'indexGewinnspielTeilnahmebedingungen'])->name('gewinnspiel-teilnahmebedingungen');

Route::prefix('/umfragen')->group(function () {
    Route::prefix('/mkbs-kundenzufriedenheit')->group(function () {
        Route::get('/', [SurveyController::class, 'show']);
        Route::post('/', [SurveyController::class, 'store'])->name('survey.mkbs.store');
    });
});

Route::prefix('/messeanmeldung')->group(function () {
    Route::get('/', [FairController::class, 'show'])->name('fair');
    Route::post('/', [FairController::class, 'store'])->name('fair.store');
});

// Pages Wildcard
Route::get('/pages/prefetch', [PageController::class, 'prefetch'])->name('app.pages.prefetch');
Route::get('/{page}', [PageController::class, 'show'])->where('page', '.*')->name('app.pages.render.page');