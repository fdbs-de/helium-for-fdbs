<?php

namespace App\Http\Controllers\Apps\Intranet;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class ProfileController extends Controller
{
    public function indexProfile()
    {
        return Inertia::render('Apps/Intranet/Profile');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'currentPassword' => 'required',
            'newPassword' => 'required|min:8',
        ]);

        if (!Hash::check($request->currentPassword, Auth::user()->password))
        {
            return back()->with('error', 'Falsches Passwort.');
        }

        $request->user()->update(['password' => Hash::make($request->newPassword)]);

        return back()->with('success', 'Passwort erfolgreich geändert.');
    }
}
