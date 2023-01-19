<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Media;
use App\Models\Post;
use App\Models\Specification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class AdminController extends Controller
{
    public function show()
    {
        return Inertia::render('Admin/Show', [
            'user_count' => User::count(),
            'users' => [
                'total' => User::count(),
                'disabled' => User::where('enabled_at', null)->count(),
                'employees' => User::whereHas('settings', function ($query) {
                    $query->where('key', 'profile.employee');
                })->count(),
                'customers' => User::whereHas('settings', function ($query) {
                    $query->where('key', 'profile.customer');
                })->count(),
            ],
            'posts' => [
                'total' => Post::count(),
                'wiki' => Post::where('scope', 'wiki')->count(),
                'jobs' => Post::where('scope', 'jobs')->count(),
                'intranet' => Post::where('scope', 'intranet')->count(),
                'blog' => Post::where('scope', 'blog')->count(),
            ],
            'unverified_user_count' => User::where('enabled_at', null)->count(),
            'post_count' => Post::count(),
            'spec_count' => Specification::count(),
        ]);
    }



    public function generateDirCache()
    {
        $basePath = 'public'.DIRECTORY_SEPARATOR.'media';

        $this->getDirContents($basePath, null);

        dd('done');
    }

    private function getDirContents($path, $belongsTo)
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
                'status' => 'public',
                'belongs_to' => $belongsTo,
            ]);
        }

        foreach ($directories as $key => $value)
        {
            $newDirectory = Media::updateOrCreate([
                'path' => $value
            ], [
                'mediatype' => 'folder',
                'status' => 'public',
                'belongs_to' => $belongsTo,
            ]);

            $this->getDirContents($value, $newDirectory->id);
        }
    }
}
