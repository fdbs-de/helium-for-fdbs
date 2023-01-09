<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Specification;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AdminController extends Controller
{
    public function show()
    {
        return Inertia::render('Admin/Show', [
            'user_count' => User::count(),
            'unverified_user_count' => User::where('enabled_at', null)->count(),
            'post_count' => Post::count(),
            'spec_count' => Specification::count(),
        ]);
    }
}
