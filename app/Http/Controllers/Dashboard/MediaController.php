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
    public function index(Request $request)
    {
        $path = $request->path ? urldecode($request->path) : 'public/media';
        $directory = new Directory($path);
        
        return Inertia::render('Dashboard/Admin/Media', [
            'items' => $directory->jsonSerialize(),
            'path' => $path,
        ]);
    }



    public function search()
    {

        return back();
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



    public function delete(Request $request)
    {
        $paths = $request->paths;
        
        foreach ($paths as $path)
        {
            if (!Storage::exists($path)) continue;

            $mime = Storage::mimeType($path);

            if (!$mime)
            {
                // delete from storage
                Storage::deleteDirectory($path);
            }
            else
            {
                // delete from storage
                Storage::delete($path);

                // delete from database
                Media::where('path', $path)->delete();
            }
        }

        return back();
    }
}
