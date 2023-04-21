<?php

namespace App\Http\Controllers\Apps\Pages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SurveyController extends Controller
{
    public function show()
    {
        return Inertia::render('Umfragen/MkbsFeedback');
    }
}
