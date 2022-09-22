<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Document;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CustomerController extends Controller
{
    public function redirect()
    {
        return redirect()->route('dashboard.customer.specs');
    }



    public function indexOffers()
    {
        return Inertia::render('Dashboard/Customer/Offers', [
            'angebote' => Document::where('category', 'angebote')->where('group', 'customers')->orderBy('slug')->get(),
        ]);
    }
}
