<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Media;
use App\Models\Post;
use App\Models\Role;
use App\Models\User;
use Inertia\Inertia;

class IndexController extends Controller
{
    public function show()
    {
        $usersWithRoles = [];

        Role::all()->each(function ($role) use (&$usersWithRoles) {
            $usersWithRoles[$role->name] = $role->users()->count();
        });

        arsort($usersWithRoles);

        return Inertia::render('Admin/Show', [
            'users' => [
                'total' => User::count(),
                'unverified' => User::where('email_verified_at', null)->count(),
                'verified' => User::where('enabled_at', null)->count(),
                'terminated' => User::where('terminated_at', '!=', null)->count(),
            ],
            'roles' => [
                'total' => Role::count(),
                'userCount' => $usersWithRoles,
            ],
            'posts' => [
                'total' => Post::count(),
                'wiki' => Post::where('scope', 'wiki')->count(),
                'jobs' => Post::where('scope', 'jobs')->count(),
                'intranet' => Post::where('scope', 'intranet')->count(),
                'blog' => Post::where('scope', 'blog')->count(),
            ],
            'media' => [
                'total_files' => Media::where('mediatype', '!=', 'folder')->count(),
                'total_folders' => Media::where('mediatype', 'folder')->count(),
                'storage' => [
                    'total' => disk_total_space(storage_path('app/public')),
                    'available' => disk_free_space(storage_path('app/public')),
                    'used' => disk_total_space(storage_path('app/public')) - disk_free_space(storage_path('app/public')),
                ],
            ],
        ]);
    }
}
