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
        return Inertia::render('ProdukteUndServices/Index');
    }

    public function indexFoodservice()
    {
        return Inertia::render('ProdukteUndServices/Foodservice');
    }

    public function indexUnsereMarken()
    {
        return Inertia::render('ProdukteUndServices/UnsereMarken');
    }

    public function indexFachberatungKaeseSalate()
    {
        return Inertia::render('ProdukteUndServices/FachberatungKaeseSalate');
    }

    public function indexMarketingKommunikation()
    {
        return Inertia::render('ProdukteUndServices/MarketingKommunikation');
    }

    public function indexTechnischerKundendienst()
    {
        return Inertia::render('ProdukteUndServices/TechnischerKundendienst');
    }

    public function indexSeminare()
    {
        return Inertia::render('ProdukteUndServices/Seminare');
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
