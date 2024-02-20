<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MfaController extends Controller
{
    public function setupTOTP(Request $request)
    {
        $request->user()->setupTOTP();

        return response()->json([
            'qr_code' => $request->user()->TOTPProvisioningQRCode($request->user()->email ?? config('app.name')),
            'secret' => $request->user()->TOTPMethod()->secret,
        ]);
    }

    public function enableTOTP(Request $request)
    {
        $request->validate([
            'otp' => 'required|digits:6',
        ]);

        if (!$request->user()->enableTOTP($request->otp)) back()->withErrors(['multi_factor_code' => 'Der eingegebene Code ist ungültig.']);

        session(['verified_multi_factor' => true]);

        return back()->with('status', 'Two factor authentication has been enabled.');
    }

    public function resetTOTP(Request $request)
    {
        $request->user()->resetTOTP();

        return back();
    }



    public function create(Request $request)
    {
        return Inertia::render('Auth/VerifyMFA', [
            'status' => session('status'),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([ 'otp' => 'required|digits:6' ]);

        if (!$request->user()->verifyTOTP($request->otp)) back()->withErrors([ 'multi_factor_code' => 'Der eingegebene Code ist ungültig.' ]);

        session(['verified_multi_factor' => true]);

        return redirect()->intended(RouteServiceProvider::HOME);
    }
}
