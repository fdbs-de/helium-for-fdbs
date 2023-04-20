<?php

namespace App\Http\Controllers\Apps\Pages;

use App\Http\Controllers\Controller;
use App\Http\Resources\Apps\Forms\FrontendFormResource;
use App\Models\Document;
use App\Models\Form;
use App\Models\Setting;
use Inertia\Inertia;

class StaticController extends Controller
{
    public function indexHome() { return Inertia::render('Home'); }
    public function indexPhilosophie() { return Inertia::render('Philosophie'); }

    public function indexProdukteUndServices() { return Inertia::render('ProdukteUndServices/Index'); }
    public function indexAngebote() { return Inertia::render('ProdukteUndServices/Angebote'); }
    public function indexFoodservice() { return Inertia::render('ProdukteUndServices/Foodservice'); }
    public function indexMehrwegpflicht() { return Inertia::render('ProdukteUndServices/Mehrwegpflicht'); }    

    public function indexMarken() { return Inertia::render('ProdukteUndServices/Marken'); }
    public function indexEichenhof() { return Inertia::render('ProdukteUndServices/Marken/Eichenhof'); }
    public function indexIlCampese() { return Inertia::render('ProdukteUndServices/Marken/IlCampese'); }
    public function indexMaxiFrance() { return Inertia::render('ProdukteUndServices/Marken/MaxiFrance'); }

    public function indexFachberatungKaeseSalate() { return Inertia::render('ProdukteUndServices/FachberatungKaeseSalate'); }

    public function indexMarketingKommunikation() { return Inertia::render('ProdukteUndServices/MarketingKommunikation'); }
    public function indexMKBS() { return Inertia::render('ProdukteUndServices/MKBS/Index'); }
    public function indexMKBSWeb() { return Inertia::render('ProdukteUndServices/MKBS/Web'); }
    public function indexMKBSSocialMedia() { return Inertia::render('ProdukteUndServices/MKBS/SocialMedia'); }
    public function indexMKBSPrint() { return Inertia::render('ProdukteUndServices/MKBS/Print'); }
    public function indexMKBSOnline() { return Inertia::render('ProdukteUndServices/MKBS/Online'); }
    public function indexMKBSDigital() { return Inertia::render('ProdukteUndServices/MKBS/Digital'); }
    public function indexMKBSAdwork() { return Inertia::render('ProdukteUndServices/MKBS/Adwork'); }

    public function indexTechnischerKundendienst() { return Inertia::render('ProdukteUndServices/TechnischerKundendienst'); }

    public function indexSeminare() { return Inertia::render('ProdukteUndServices/Seminare/Index'); }
    public function indexSeminareGrillseminar()
    {
        $form = Form::where('status', 'published')->find(1);
        if ($form) $form = new FrontendFormResource($form);

        return Inertia::render('ProdukteUndServices/Seminare/Grillseminar', [
            'form' => $form,
        ]);
    }
    public function indexSeminareKreativworkshop()
    {
        $form = Form::where('status', 'published')->find(1);
        if ($form) $form = new FrontendFormResource($form);

        return Inertia::render('ProdukteUndServices/Seminare/Kreativworkshop', [
            'form' => $form,
        ]);
    }
    public function indexSeminareCatering()
    {
        $form = Form::where('status', 'published')->find(3);
        if ($form) $form = new FrontendFormResource($form);

        return Inertia::render('ProdukteUndServices/Seminare/Catering', [
            'form' => $form,
        ]);
    }



    public function indexImpressum()
    {
        $disclaimer = Setting::find('legal.disclaimer');
        
        return Inertia::render('Impressum', [
            'disclaimer' => $disclaimer ? $disclaimer->value : null,
        ]);
    }
    public function indexDatenschutz() { return Inertia::render('Datenschutz'); }
    public function indexAGBS() { return Inertia::render('AGBS'); }
    public function indexVideoInfo() { return Inertia::render('VideoInfo'); }
    public function indexGewinnspielTeilnahmebedingungen() { return Inertia::render('Gewinnspiel'); }
}
