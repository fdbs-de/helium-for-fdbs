<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Inertia\Inertia;

class EmployeeController extends Controller
{
    public function indexOverview()
    {
        return Inertia::render('Apps/Intranet/Employee/Overview', [
            'posts' => Post::getPublished('intranet', request()->user() ?? null, ['roles' => 'all'])
            ->orderByDesc('pinned')
            ->orderByDesc('created_at')
            ->orderByDesc('updated_at')
            ->get(),
        ]);
    }

    public function indexDocuments() { return Inertia::render('Apps/Intranet/Employee/Documents'); }
}
