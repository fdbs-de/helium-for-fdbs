<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Document;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DocumentController extends Controller
{
    public function show(Request $request, Document $document)
    {
        return Inertia::render('Dashboard/Documents/Show', [
            'document' => $document,
        ]);
    }

    public function indexAdmin()
    {
        return Inertia::render('Dashboard/DocsManagement');
    }
}
