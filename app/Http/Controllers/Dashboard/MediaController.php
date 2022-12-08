<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Media\CreateMediaRequest;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class MediaController extends Controller
{
    public function indexAdmin()
    {
        return Inertia::render('Dashboard/Admin/Media', [
            'media' => Media::all(),
        ]);
    }



    public function store(CreateMediaRequest $request)
    {
        $files = $request->file('files');

        foreach ($files as $file) {
            $filename = Str::lower(Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension());
            
            $path = Storage::putFileAs('public/media', $file, $filename);

            // Get the MIME type of the file
            $mediatype = $file->getMimeType();
            
            // save to database
            Media::create(array_merge($request->validated(), ['path' => $path, 'mediatype' => $mediatype]));
        }

        return back();
    }
}
