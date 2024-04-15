<?php

namespace App\Http\Controllers\Apps\Static;

use App\Http\Controllers\Controller;
use App\Http\Resources\Apps\Forms\FrontendFormResource;
use App\Models\Form;
use App\Models\Setting;
use Inertia\Inertia;

class StaticController extends Controller
{
    public function indexHome() { return Inertia::render('Apps/Static/Home'); }

    public function indexPhilosophie() { return Inertia::render('Apps/Static/Philosophie'); }
    public function indexNachhaltigkeit() { return Inertia::render('Apps/Static/Nachhaltigkeit'); }
    public function indexCI() { return Inertia::render('Apps/Static/CI'); }

    public function indexProdukteUndServices() { return Inertia::render('Apps/Static/ProdukteUndServices/Index'); }
    public function indexAngebote() { return Inertia::render('Apps/Static/ProdukteUndServices/Angebote'); }

    public function indexFoodservice() { return Inertia::render('Apps/Static/ProdukteUndServices/Foodservice/Index'); }
    public function indexFoodserviceRezepte() { return Inertia::render('Apps/Static/ProdukteUndServices/Foodservice/Rezepte'); }
    public function indexFoodserviceAktuelles() { return Inertia::render('Apps/Static/ProdukteUndServices/Foodservice/Aktuelles'); }
    public function indexTierhaltungskennzeichnung() { return Inertia::render('Apps/Static/ProdukteUndServices/Foodservice/Tierhaltungskennzeichnung'); }
    public function indexMehrwegpflicht() { return Inertia::render('Apps/Static/ProdukteUndServices/Foodservice/Mehrwegpflicht'); }

    public function indexMarken() { return Inertia::render('Apps/Static/ProdukteUndServices/Marken/Index'); }
    public function indexEichenhof() { return Inertia::render('Apps/Static/ProdukteUndServices/Marken/Eichenhof'); }
    public function indexIlCampese() { return Inertia::render('Apps/Static/ProdukteUndServices/Marken/IlCampese'); }
    public function indexMaxiFrance() { return Inertia::render('Apps/Static/ProdukteUndServices/Marken/MaxiFrance'); }

    public function indexFachberatungKaeseSalate() { return Inertia::render('Apps/Static/ProdukteUndServices/FachberatungKaeseSalate'); }

    public function indexMKBS() { return Inertia::render('Apps/Static/ProdukteUndServices/MKBS/Index'); }
    public function indexMKBSAktuelles() { return Inertia::render('Apps/Static/ProdukteUndServices/MKBS/Aktuelles'); }
    public function indexMKBSRecruiting() { return Inertia::render('Apps/Static/ProdukteUndServices/MKBS/Recruiting'); }
    public function indexMKBSWeb() { return Inertia::render('Apps/Static/ProdukteUndServices/MKBS/Web'); }
    public function indexMKBSSocialMedia() { return Inertia::render('Apps/Static/ProdukteUndServices/MKBS/SocialMedia'); }
    public function indexMKBSPrint() { return Inertia::render('Apps/Static/ProdukteUndServices/MKBS/Print'); }
    public function indexMKBSCrossmedia() { return Inertia::render('Apps/Static/ProdukteUndServices/MKBS/Crossmedia'); }

    public function indexTechnischerKundendienst() { return Inertia::render('Apps/Static/ProdukteUndServices/TechnischerKundendienst/Index'); }
    public function indexTechnischerKundendienstAktuelles() { return Inertia::render('Apps/Static/ProdukteUndServices/TechnischerKundendienst/Aktuelles'); }

    public function indexSeminare() { return Inertia::render('Apps/Static/ProdukteUndServices/Seminare/Index'); }
    // public function indexSeminareGrillseminar()
    // {
    //     $form = Form::where('status', 'published')->find(1);
    //     if ($form) $form = new FrontendFormResource($form);

    //     return Inertia::render('Apps/Static/ProdukteUndServices/Seminare/Grillseminar', [
    //         'form' => $form,
    //     ]);
    // }
    // public function indexSeminareKreativworkshop()
    // {
    //     $form = Form::where('status', 'published')->find(1);
    //     if ($form) $form = new FrontendFormResource($form);

    //     return Inertia::render('Apps/Static/ProdukteUndServices/Seminare/Kreativworkshop', [
    //         'form' => $form,
    //     ]);
    // }
    // public function indexSeminareCatering()
    // {
    //     $form = Form::where('status', 'published')->find(3);
    //     if ($form) $form = new FrontendFormResource($form);

    //     return Inertia::render('Apps/Static/ProdukteUndServices/Seminare/Catering', [
    //         'form' => $form,
    //     ]);
    // }
    // public function indexSeminareEmployerBranding()
    // {
    //     $form = Form::where('status', 'published')->find(1);
    //     if ($form) $form = new FrontendFormResource($form);

    //     return Inertia::render('Apps/Static/ProdukteUndServices/Seminare/EmployerBranding', [
    //         'form' => $form,
    //     ]);
    // }
    // public function indexSeminareKaeseworkshop()
    // {
    //     $form = Form::where('status', 'published')->find(4);
    //     if ($form) $form = new FrontendFormResource($form);

    //     return Inertia::render('Apps/Static/ProdukteUndServices/Seminare/Kaeseworkshop', [
    //         'form' => $form,
    //     ]);
    // }



    public function indexImpressum()
    {
        $disclaimer = Setting::find('legal.disclaimer');
        
        return Inertia::render('Apps/Static/Impressum', [
            'disclaimer' => $disclaimer ? $disclaimer->value : null,
        ]);
    }
    public function indexDatenschutz() { return Inertia::render('Apps/Static/Datenschutz'); }
    public function indexAGBS() { return Inertia::render('Apps/Static/AGBS'); }
    public function indexVideoInfo() { return Inertia::render('Apps/Static/VideoInfo'); }
    public function indexGewinnspielTeilnahmebedingungen() { return Inertia::render('Apps/Static/Gewinnspiel'); }
}
