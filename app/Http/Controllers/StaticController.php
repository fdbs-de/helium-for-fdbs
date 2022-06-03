<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class StaticController extends Controller
{
    public function indexHome()
    {
        return Inertia::render('Home');
    }

    public function indexPhilosophie()
    {
        return Inertia::render('Philosophie');
    }

    public function indexProdukteUndServices()
    {
        return Inertia::render('ProdukteUndServices');
    }

    public function indexFoodservice()
    {
        return Inertia::render('ProdukeUndServices/Foodservice');
    }

    public function indexUnsereMarken()
    {
        return Inertia::render('ProdukeUndServices/UnsereMarken');
    }

    public function indexFachberatungKaeseSalate()
    {
        return Inertia::render('ProdukeUndServices/FachberatungKaeseSalate');
    }

    public function indexMarketingKommunikation()
    {
        return Inertia::render('ProdukeUndServices/MarketingKommunikation');
    }

    public function indexTechnischerKundendienst()
    {
        return Inertia::render('ProdukeUndServices/TechnischerKundendienst');
    }

    public function indexSeminare()
    {
        return Inertia::render('ProdukeUndServices/Seminare');
    }

    public function indexKarriere()
    {
        return Inertia::render('Karriere');
    }

    public function indexKontakt()
    {
        return Inertia::render('Kontakt');
    }
}
