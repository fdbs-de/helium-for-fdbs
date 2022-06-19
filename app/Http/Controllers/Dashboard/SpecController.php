<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Illuminate\Support\Str;

class SpecController extends Controller
{
    public function index()
    {
        return Inertia::render('Dashboard/Specs');
    }

    public function indexAdmin()
    {
        return Inertia::render('Dashboard/SpecsManagement');
    }



    public function upload(Request $request)
    {
        $request->validate([
            'files' => 'required|array|min:1',
            'files.*' => 'required|file|mimes:pdf|max:16384',
        ]);

        foreach ($request->file('files') as $file)
        {
            $filename = Str::lower(Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME), '_'));
            Storage::putFileAs('specifications/', $file, $filename . '.' . $file->getClientOriginalExtension());
        }

        return back();
    }



    public function delete(Request $request)
    {
        $request->validate([
            'names' => 'required|array|min:1',
            'names.*' => 'required|string',
        ]);

        foreach ($request->names as $name)
        {
            Storage::delete('specifications/' . $name);
        }
        
        return back();
    }



    public function search(Request $request)
    {
        $request->validate([
            'search' => 'nullable|string',
            'page' => 'nullable|integer|min:1',
        ]);



        // Get Items
        $specs = [];

        foreach (Storage::files('specifications') as $file) {
            $extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));
            $filename = pathinfo($file, PATHINFO_FILENAME);

            // Filter files: only PDFs
            if ($extension !== 'pdf') continue;

            // Filter files: only files with the search term
            if (!str_contains(strtolower($filename), strtolower($request->search))) continue;

            $specs[] = [
                'name' => $filename,
                'url' => route('dashboard.customer.spec.download', ['name' => $filename]),
            ];
        }



        // Paginate
        $pageSize = 50;
        $total = count($specs);
        $pages = ceil($total / $pageSize);
        $page = min(max($request->page, 1), $pages);
        $offset = ($page - 1) * $pageSize;

        return response()->json([
            'items' => array_slice($specs, $offset, $pageSize),
            'last_page' => $pages,
            'total' => $total,
        ]);
    }



    public function download(Request $request, $name)
    {
        $path = storage_path('app/specifications/' . $name . '.pdf');
        $mime = 'application/pdf';
        $headers = [
            'Content-Type' => $mime,
            'Content-Disposition' => 'inline; filename="' . $name . '.pdf"',
        ];
        return response()->file($path, $headers);
    }
}
