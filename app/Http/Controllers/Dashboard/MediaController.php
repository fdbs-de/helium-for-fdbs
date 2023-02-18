<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Media\CreateDirectoryRequest;
use App\Http\Requests\Media\CreateMediaRequest;
use App\Http\Requests\Media\DestroyMediaRequest;
use App\Http\Requests\Media\RenameMediaRequest;
use App\Http\Resources\MediaResource;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class MediaController extends Controller
{
    private const DRIVES = [
        ['path' => 'public/media', 'status' => 'public'],
        ['path' => 'private/media', 'status' => 'private'],
    ];



    public function setupMediaDrives()
    {
        foreach (self::DRIVES as $drive)
        {
            if (!Storage::exists($drive['path']))
            {
                Storage::makeDirectory($drive['path']);
            }

            Media::updateOrCreate([
                'path' => $drive['path']
            ], [
                'mediatype' => 'folder',
                'status' => $drive['status'],
                'belongs_to' => null,
            ]);
        }

        return true;
    }



    public function generateMediaCache()
    {
        // Delete all media that no longer exists on the disk
        foreach (Media::all() as $media)
        {
            if (Storage::exists($media->path)) continue;

            $media->delete();
        }



        // Scan all media drives
        foreach (self::DRIVES as $drive)
        {
            $media = Media::getRoot($drive['status']);
            
            if (!$media) continue;
            if (!Storage::exists($drive['path'])) continue;

            $this->getMediaContents($media->path, $media->id, $media->status);
        }



        return back();
    }



    private function getMediaContents($path, $belongsTo, $status)
    {
        $directories = Storage::directories($path);
        $files = Storage::files($path);

        foreach ($files as $key => $value)
        {
            $mimeType = Storage::mimeType($value);

            Media::updateOrCreate([
                'path' => $value
            ], [
                'mediatype' => $mimeType,
                'status' => $status,
                'belongs_to' => $belongsTo,
            ]);
        }

        foreach ($directories as $key => $value)
        {
            $newDirectory = Media::updateOrCreate([
                'path' => $value
            ], [
                'mediatype' => 'folder',
                'status' => $status,
                'belongs_to' => $belongsTo,
            ]);

            $this->getMediaContents($value, $newDirectory->id, $status);
        }
    }



    public function indexPublic(Request $request, Media $media)
    {
        if (!$media->id)
        {
            $media = Media::getRoot('public');
        }

        if (!$media) abort(404);
        if ($media->mediatype !== 'folder') abort(404);



        $path = [];
        $parent = $media;

        while ($parent)
        {
            array_unshift($path, $parent);
            $parent = $parent->parent;
        }

        $data = [
            'items' => MediaResource::collection($media->children),
            'breadcrumbs' => $path,
        ];



        if ($request->wantsJson()) return $data;

        return Inertia::render('Admin/Media/Index', [
            'items' => MediaResource::collection($media->children),
            'breadcrumbs' => $path,
        ]);
    }



    public function search()
    {
        return back();
    }



    public function storeFiles(CreateMediaRequest $request, Media $media)
    {
        $files = $request->file('files');

        foreach ($files as $file)
        {
            $filename = $file->getClientOriginalName();
            
            $path = Storage::putFileAs($media->path, $file, $filename);

            // save to database
            $media->children()->create([
                'path' => $path,
                'mediatype' => $file->getMimeType(),
                'status' => $media->status,
            ]);
        }

        return back();
    }



    public function storeDirectory(CreateDirectoryRequest $request, Media $media)
    {
        $path = $media->path . '/' . $request->name;

        Storage::makeDirectory($path);

        // save to database
        $media->children()->create([
            'path' => $path,
            'mediatype' => 'folder',
            'systus' => $media->status,
        ]);

        return back();
    }



    public function rename(RenameMediaRequest $request, Media $media)
    {
        $new_path = $media->parent->path . '/' . $request->name;
        $old_path = $media->path;

        $media->move($old_path, $new_path);

        return back();
    }




    public function delete(DestroyMediaRequest $request)
    {
        foreach ($request->ids as $id)
        {
            Media::find($id)->delete();
        }

        return back();
    }
}
