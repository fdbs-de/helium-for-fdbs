<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Docs\CreateDocumentRequest;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Image;

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

    public function store(CreateDocumentRequest $request)
    {
        $file = $request->file('file');
        
        // get file extension
        $extension = Str::lower(pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION));

        // get file name
        $filename = $request->slug . '.' . $extension;

        Storage::putFileAs('documents/', $file, $filename);

        // Routine for creating a cover image
        // Right now it needs a separate image
        if ($request->has('cover'))
        {
            // Get cover image
            $cover = $request->file('cover');

            // Convert to intervention-image object
            $cover = Image::make($cover);

            // Resize it (so it keeps the same aspect ratio but no side is larger than 600px)
            $cover->resize(600, 600, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });

            // Create name
            $cover_filename = $filename . '.cover.png';

            // Save it
            $cover->save(storage_path('app/documents/' . $cover_filename));
        }
        
        // save to database
        $document = Document::create(array_merge($request->validated(), [
            'filename' => $filename,
            'has_cover' => $request->has('cover'),
        ]));

        return back();
    }
}
