<?php

namespace App\Http\Controllers\Dashboard;

use App\Classes\MediaLibrary\Directory;
use App\Http\Controllers\Controller;
use App\Http\Requests\Media\CreateMediaRequest;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class MediaController extends Controller
{
    public function index()
    {
        return Inertia::render('Dashboard/Admin/Media');
    }



    public function search(Request $request)
    {
        $directory = new Directory($request->path);

        return response()->json($directory->jsonSerialize());
    }



    public function store(CreateMediaRequest $request)
    {
        $files = $request->file('files');

        foreach ($files as $file) {
            $filename = Str::lower(Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension());
            
            $path = Storage::putFileAs($request->path, $file, $filename);

            // Get the MIME type of the file
            $mediatype = $file->getMimeType();
            
            // save to database
            Media::create(array_merge($request->validated(), ['path' => $path, 'mediatype' => $mediatype]));
        }

        return back();
    }



    public function storeDirectory(Request $request)
    {
        Storage::makeDirectory($request->path);

        return back();
    }
}
