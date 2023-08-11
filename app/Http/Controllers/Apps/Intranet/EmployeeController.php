<?php

namespace App\Http\Controllers\Apps\Intranet;

use App\Http\Controllers\Controller;
use App\Http\Resources\Post\PostResource;
use App\Models\Post;
use Inertia\Inertia;

class EmployeeController extends Controller
{
    public function indexOverview()
    {
        $query = Post::query();

        $query
        // Posts that are published and available to the user
        ->where(function ($query) {
            $query
            ->whereScope(['intranet'])
            ->wherePublished()
            ->whereAvailable();
        })
        // Posts that may not be published (drafts; only visible to editors and admins)
        ->orWhere(function ($query) {
            $query
            ->whereScope(['intranet'])
            ->whereEditable();
        });



        // START: Order
        $query
        ->orderByDesc('pinned')
        ->orderByDesc('created_at')
        ->orderByDesc('updated_at');
        // END: Order



        return Inertia::render('Apps/Intranet/Employee/Overview', [
            'posts' => PostResource::collection($query->get()),
        ]);
    }

    public function indexDocuments() { return Inertia::render('Apps/Intranet/Employee/Documents'); }
}
