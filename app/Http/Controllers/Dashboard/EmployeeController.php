<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Document;
use Illuminate\Http\Request;
use Inertia\Inertia;

class EmployeeController extends Controller
{
    public function indexOverview()
    {
        return Inertia::render('Dashboard/Employee/Overview', [
            'leitbild' => Document::where('category', 'leitbild')->firstWhere('group', 'employees'),
            'organigramm' => Document::where('category', 'organigramm')->firstWhere('group', 'employees'),
        ]);
    }

    public function indexDocuments()
    {
        return Inertia::render('Dashboard/Employee/Documents', [
            'documents' => Document::where('category', 'dokumente')->where('group', 'employees')->orderBy('slug')->get(),
        ]);
    }
}
