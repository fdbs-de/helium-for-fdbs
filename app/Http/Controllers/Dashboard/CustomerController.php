<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function redirect()
    {
        return redirect()->route('dashboard.customer.specs');
    }
}
