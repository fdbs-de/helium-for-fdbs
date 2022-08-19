<?php

namespace App\Http\Controllers;

use App\Mail\AdminContactMail;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
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

    public function indexAngebote()
    {
        return Inertia::render('ProdukteUndServices/Angebote', [
            'angebote' => Document::where('category', 'angebote')->where('group', null)->orderBy('name')->get(),
        ]);
    }

    public function indexFoodservice()
    {
        return Inertia::render('ProdukteUndServices/Foodservice');
    }

    public function indexMarken()
    {
        return Inertia::render('ProdukteUndServices/Marken');
    }

    public function indexEichenhof()
    {
        return Inertia::render('ProdukteUndServices/Marken/Eichenhof');
    }

    public function indexIlCampese()
    {
        return Inertia::render('ProdukteUndServices/Marken/IlCampese');
    }

    public function indexMaxiFrance()
    {
        return Inertia::render('ProdukteUndServices/Marken/MaxiFrance');
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
        return Inertia::render('Karriere/Index');
    }

    public function indexStellenangebote()
    {
        return Inertia::render('Karriere/Stellenangebote', [
            'jobs' => Document::where('category', 'jobs')->where('group', null)->orderBy('name')->get(),
        ]);
    }

    public function indexStudiumAusbildung()
    {
        return Inertia::render('Karriere/StudiumAusbildung', [
            'jobs' => Document::where('category', 'jobs-studium')->where('group', null)->orderBy('name')->get(),
        ]);
    }

    public function indexFDBSAlsArbeitgeber()
    {
        return Inertia::render('Karriere/FDBSAlsArbeitgeber');
    }

    public function indexKontakt()
    {
        return Inertia::render('Kontakt');
    }

    public function storeKontakt(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:200',
            'email' => 'required|email',
            'message' => 'required|string|max:2000',
            'terms' => 'required|accepted',
        ]);

        Mail::to(config('mail.addresses.user_inquiry'))->send(new AdminContactMail($request->name, $request->email, $request->message));
        
        return back()->with('success', true);
    }



    public function indexImpressum()
    {
        return Inertia::render('Impressum');
    }

    public function indexDatenschutz()
    {
        return Inertia::render('Datenschutz');
    }

    public function indexAGBS()
    {
        return Inertia::render('AGBS');
    }

    public function indexVideoInfo()
    {
        return Inertia::render('VideoInfo');
    }
}
