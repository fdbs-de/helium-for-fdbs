<?php

namespace App\Http\Controllers\Admin\Apps\Forms;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class FormController extends Controller
{
    public function index(Request $request)
    {
        return Inertia::render('Admin/Apps/Forms/Index', [
            'items' => [],
        ]);
    }
}
