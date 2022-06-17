<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class CustomerController extends Controller
{
    public function redirect()
    {
        return redirect()->route('dashboard.customer.specs');
    }



    public function create()
    {
        return Inertia::render('Dashboard/Specs');
    }



    public function index(Request $request)
    {
        $request->validate([
            'search' => 'nullable|string',
        ]);

        $specs = [];

        foreach (Storage::files('specifications') as $file)
        {
            $extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));
            $filename = pathinfo($file, PATHINFO_FILENAME);

            if ($extension !== 'pdf') continue;
            if (!str_contains(strtolower($filename), strtolower($request->search))) continue;

            $specs[] = [
                'name' => $filename,
                'extension' => $extension,
                'url' => route('dashboard.customer.spec.download', ['name' => $filename]),
            ];
        }

        return response()->json($specs);
    }

    

    public function download(Request $request, $name)
    {
        $path = storage_path('app/specifications/'.$name.'.pdf');
        $mime = 'application/pdf';
        $headers = [
            'Content-Type' => $mime,
            'Content-Disposition' => 'inline; filename="'.$name.'.pdf"',
        ];
        return response()->file($path, $headers);
    }
}
