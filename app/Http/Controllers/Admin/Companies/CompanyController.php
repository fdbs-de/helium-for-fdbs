<?php

namespace App\Http\Controllers\Admin\Companies;

use App\Http\Controllers\Controller;
use App\Http\Resources\Company\CompanyResource;
use App\Models\Company;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CompanyController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Companies/Index');
    }



    public function create(Company $company)
    {
        return Inertia::render('Admin/Companies/Create', [
            'item' => CompanyResource::make($company),
        ]);
    }
}
