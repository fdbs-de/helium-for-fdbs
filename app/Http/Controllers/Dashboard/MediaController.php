<?php

namespace App\Http\Controllers\Dashboard;

use App\Classes\MediaLibrary\Directory;
use App\Http\Controllers\Controller;
use App\Http\Requests\Media\CreateDirectoryRequest;
use App\Http\Requests\Media\CreateMediaRequest;
use App\Http\Requests\Media\DestroyMediaRequest;
use App\Http\Requests\Media\IndexMediaRequest;
use App\Http\Requests\Media\RenameMediaRequest;
use App\Models\Media;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class MediaController extends Controller
{
    public function index(IndexMediaRequest $request)
    {
        $path = $request->path ? urldecode($request->path) : 'public/media';

        $directory = new Directory($path);
        
        return Inertia::render('Admin/Media/Index', [
            'items' => $directory->jsonSerialize(),
            'path' => $path,
            'exists' => Storage::exists($path),
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
            $filename = $file->getClientOriginalName();
            
            $path = Storage::putFileAs($request->path, $file, $filename);

            // Get the MIME type of the file
            $mediatype = $file->getMimeType();
            
            // save to database
            Media::create(array_merge($request->validated(), ['path' => $path, 'mediatype' => $mediatype]));
        }

        return back();
    }



    public function storeDirectory(CreateDirectoryRequest $request)
    {
        Storage::makeDirectory($request->path);

        return back();
    }



    public function rename(RenameMediaRequest $request)
    {
        $current_path = $request->current_path;
        $new_path = $request->new_path;

        if (!Storage::exists($current_path)) return back();

        // rename item
        Storage::move($current_path, $new_path);
        

        // check if item is a file and update the database
        $mime = Storage::mimeType($current_path);
        
        if ($mime)
        {
            // update database
            Media::where('path', $current_path)->update(['path' => $new_path]);
        }

        return back();
    }



    public function delete(DestroyMediaRequest $request)
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
