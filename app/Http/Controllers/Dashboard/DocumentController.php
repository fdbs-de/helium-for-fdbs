<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Docs\CreateDocumentRequest;
use App\Http\Requests\Docs\ShowDocumentRequest;
use App\Http\Requests\Docs\UpdateDocumentRequest;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Image;

class DocumentController extends Controller
{
    public function show(ShowDocumentRequest $request, Document $document)
    {
        $path = storage_path('app/documents/' . $document->filename);
        $headers = [
            'Content-Disposition' => 'inline; filename="' . $document->filename,
        ];

        return response()->file($path, $headers);
    }



    public function showCover(ShowDocumentRequest $request, Document $document)
    {
        $path = storage_path('app/documents/' . $document->filename . '.cover.png');
        $headers = [
            'Content-Disposition' => 'inline; filename="' . $document->filename . '.cover.png',
        ];

        return response()->file($path, $headers);
    }



    public function indexAdmin()
    {
        return Inertia::render('Admin/Docs/Index', [
            // 'documents' => Document::orderBy('category')->get(),
            // remove empty categories
            'categories' => Document::all()->pluck('category')->unique()->filter(function ($category) {
                return $category !== null;
            })->sort()->values()->all(),
        ]);
    }



    public function search(Request $request)
    {
        $documents = Document::where('name', 'like', '%' . $request->name . '%')
            ->when(true, function ($query) use ($request) {
                if (!$request->category) return $query;
                return $query->where('category', $request->category);
            })
            ->when(true, function ($query) use ($request) {
                if ($request->group === 'all') return $query;
                return $query->where('group', $request->group);
            })
            ->orderBy('category')
            ->get();

        return response()->json($documents);
    }



    public function store(CreateDocumentRequest $request)
    {
        $file = $request->file('file');
        
        // get file extension
        $extension = Str::lower(pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION));
        
        // get file name
        $filename = $request->slug . '.' . $extension;

        Storage::putFileAs('documents/', $file, $filename);

        $has_cover = $request->hasFile('cover');

        // Routine for creating a cover image
        // Right now it needs a separate image
        if ($has_cover)
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
        Document::create(array_merge($request->validated(), [
            'filename' => $filename,
            'has_cover' => $has_cover,
        ]));

        return back();
    }



    public function update(UpdateDocumentRequest $request, Document $document)
    {
        $document->update($request->validated());

        $old_filename = $document->filename;



        // If new file was uploaded
        if ($request->hasFile('file'))
        {
            // Delete old file
            Storage::delete('documents/' . $old_filename);

            // Get new file
            $file = $request->file('file');
    
            // Get file extension
            $extension = Str::lower(pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION));
    
            // Make new filename
            $filename = $request->slug . '.' . $extension;
    
            // Store new file
            Storage::putFileAs('documents/', $file, $filename);

            // Update document
            $document->update(['filename' => $filename]);
        }



        // If new cover was uploaded
        if ($request->has_cover && $request->hasFile('cover'))
        {
            // Delete old cover
            Storage::delete('documents/' . $old_filename . '.cover.png');

            // Get new cover image
            $cover = $request->file('cover');

            // Convert to intervention-image object
            $cover = Image::make($cover);

            // Resize it (so it keeps the same aspect ratio but no side is larger than 600px)
            $cover->resize(600, 600, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });

            // Make new filename
            $cover_filename = $document->filename . '.cover.png';

            // Save file
            $cover->save(storage_path('app/documents/' . $cover_filename));

            // Update document
            $document->update(['has_cover' => true]);
        }
        

        return back();
    }



    public function delete(Document $document)
    {
        $document->delete();

        return back();
    }
}
