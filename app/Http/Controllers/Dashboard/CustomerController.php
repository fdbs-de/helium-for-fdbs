<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Inertia\Inertia;

class CustomerController extends Controller
{
    public function redirect() { return redirect()->route('dashboard.customer.specs'); }
    public function indexSpecs() { return Inertia::render('Apps/Intranet/Customer/Specs'); }
    public function indexOffers() { return Inertia::render('Apps/Intranet/Customer/Offers'); }
}
