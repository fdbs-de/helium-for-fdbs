<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Specification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Illuminate\Support\Str;

class SpecController extends Controller
{
    public function index()
    {
        return Inertia::render('Dashboard/Customer/Specs');
    }

    public function indexAdmin()
    {
        return Inertia::render('Dashboard/Admin/Specs');
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

            Storage::putFileAs('specifications/', $file, $filename.'.pdf');

            Specification::firstOrCreate(['name' => $filename]);
        }

        return back();
    }



    public function cache(Request $request)
    {
        Specification::truncate();

        foreach (Storage::files('specifications') as $file)
        {
            $extension = Str::lower(pathinfo($file, PATHINFO_EXTENSION));
            $filename = pathinfo($file, PATHINFO_FILENAME);

            // Filter files: only PDFs
            if ($extension !== 'pdf') continue;

            Specification::firstOrCreate(['name' => $filename]);
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
            Storage::delete('specifications/'.$name.'.pdf');
            Specification::find($name)->delete();
        }
        
        return back();
    }



    public function search(Request $request)
    {
        $request->validate([
            'search' => 'nullable|string',
            'page' => 'nullable|integer|min:1',
        ]);

        $results = Specification::where('name', 'like', '%' . $request->search . '%');
        $page = min(ceil($results->count() / 50), $request->page ?? 1);

        return response()->json($results->paginate(50, ['*'], 'page', $page));
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
