<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\Post;
use Illuminate\Http\Request;
use Inertia\Inertia;

class EmployeeController extends Controller
{
    public function indexOverview()
    {
        return Inertia::render('Dashboard/Employee/Overview', [
            'posts' => Post::with(['category' => function ($query) {
                $query->select('id', 'name', 'slug');
            }])
            ->where('scope', 'intranet')
            ->where('status', 'published')
            ->where(function ($query) {
                $query->whereDate('available_from', '<=', now())->orWhere('available_from', null);
            })
            ->where(function ($query) {
                $query->whereDate('available_to', '>=', now())->orWhere('available_to', null);
            })
            ->orderByDesc('pinned')
            ->orderByDesc('created_at')
            ->orderByDesc('updated_at')
            ->get(),
        ]);
    }

    public function indexDocuments()
    {
        return Inertia::render('Dashboard/Employee/Documents', [
            'documents' => Document::where('category', 'dokumente')->where('group', 'employees')->orderBy('slug')->get(),
        ]);
    }
}
