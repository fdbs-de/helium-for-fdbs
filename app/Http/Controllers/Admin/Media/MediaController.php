<?php

namespace App\Http\Controllers\Admin\Media;

use App\Classes\Drives\Drives;
use App\Http\Controllers\Controller;
use App\Http\Requests\Media\CreateDirectoryRequest;
use App\Http\Requests\Media\CreateMediaRequest;
use App\Http\Requests\Media\DestroyMediaRequest;
use App\Http\Requests\Media\RenameMediaRequest;
use App\Http\Requests\Media\UpdateMediaRequest;
use App\Http\Requests\Media\UpdatePermissionsMediaRequest;
use App\Http\Resources\Media\MediaResource;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class MediaController extends Controller
{
    public function setupMediaDrives()
    {
        foreach (Drives::getDrives() as $drive)
        {
            if (!Storage::exists($drive['path']))
            {
                Storage::makeDirectory($drive['path']);
            }

            Media::updateOrCreate([
                'path' => $drive['path']
            ], [
                'mediatype' => 'folder',
                'permission_mode' => $drive['permission_mode'],
                'drive' => $drive['alias'],
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
        foreach (Drives::getDrives() as $drive)
        {
            $media = Media::getDriveRoot($drive['alias']);
            
            if (!$media) continue;
            if (!Storage::exists($drive['path'])) continue;

            $this->getMediaContents($media->path, $media->id);
        }



        return back();
    }



    private function getMediaContents($path, $belongsTo)
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
                'drive' => null,
                'belongs_to' => $belongsTo,
            ]);
        }

        foreach ($directories as $key => $value)
        {
            $newDirectory = Media::updateOrCreate([
                'path' => $value
            ], [
                'mediatype' => 'folder',
                'drive' => null,
                'belongs_to' => $belongsTo,
            ]);

            $this->getMediaContents($value, $newDirectory->id);
        }
    }



    public function index(Request $request, String $driveAlias, Media $media)
    {
        // Get the drive config
        $drive = Drives::getDrive($driveAlias);

        // Get root media object
        if (!$media->id)
        {
            $media = Media::getDriveRoot($drive['alias']);
        }

        // Cancel if unauthorized
        if (!$media->canAccess($request)) abort(403);

        // Cancel if media object is empty
        if (!$media) abort(404);

        // Cancel if media object is not a folder
        // (when indexing media, the object we're looking for is naturally a folder)
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
            'drive' => $drive,
        ];



        if ($request->wantsJson()) return $data;

        return Inertia::render('Admin/Media/Index', $data);
    }



    public function indexPublic(Request $request, String $driveAlias, Media $media)
    {
        // Get the drive config
        $drive = Drives::getDrive($driveAlias);

        // Cancel if media object is empty
        if (!$media) abort(404);

        // Cancel if unauthorized
        if (!$media->canAccess($request)) abort(403);

        // Cancel if media object is not a folder
        if ($media->mediatype !== 'folder') abort(404);



        // Get query builder from current media object
        $query = $media->children();

        // Search for files in query builder
        if($request->search)
        {
            $query->whereFuzzy(function ($query) use ($request) {
                $query
                ->orWhereFuzzy('path', $request->search)
                ->orWhereFuzzy('title', $request->search)
                ->orWhereFuzzy('description', $request->search);
            });
        }

        // Get media from query builder and filter out items the user can't access
        $items = collect($query->get())->filter(function ($item) use ($request) {
            return $item->canAccess($request) && $item->mediatype !== 'folder';
        });

        $total = $items->count();

        $limit = $request->size ?? 20;
        $offset = $request->size * ($request->page ?? 0) - $request->size;

        // Clamp the offset to 0 and limit
        $offset = max(0, $offset);
        $offset = min($offset, intdiv($total, $limit) * $limit);

        // Get the items for the current page
        $items = $items->slice($offset, $limit);

        return [
            'data' => MediaResource::collection($items),
            'drive' => $drive,
            'total' => $total,
        ];
    }



    public function showPublic(Request $request, String $drive, Media $media)
    {
        if (!$media->canAccess($request)) abort(403);
        
        $media = (new MediaResource($media))->toArray($request);

        // Cancel if media object is a folder
        if ($media['mime']['string'] === 'folder') abort(404);
        
        $path = storage_path('app/' . $media['path']['path']);
        
        // dd($media['path']['filename']);

        $headers = [
            'Content-Type' => $media['mime']['string'],
            'Content-Disposition' => 'inline; filename="' . $media['path']['filename'] . '"',
        ];

        return response()->file($path, $headers);
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



    public function update(UpdateMediaRequest $request, Media $media)
    {
        $media->update($request->validated());

        // update profiles
        foreach ($request->profiles as $profile)
        {
            $media->profiles()->updateOrCreate([
                'profile' => $profile,
            ]);
        }
        // delete profiles that are not in the request
        $media->profiles()->whereNotIn('profile', $request->profiles)->delete();

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
