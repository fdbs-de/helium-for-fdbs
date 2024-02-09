<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MfaController extends Controller
{
    public function setupTOTP(Request $request)
    {
        $request->user()->setupTOTP();

        return response()->json([
            'qr_code' => $request->user()->TOTPProvisioningQRCode(config('app.name')),
            'secret' => $request->user()->TOTPMethod()->secret,
        ]);
    }

    public function enableTOTP(Request $request)
    {
        $request->validate([
            'otp' => 'required|digits:6',
        ]);

        if (!$request->user()->enableTOTP($request->otp)) back(422);

        return back()->with('status', 'Two factor authentication has been enabled.');
    }

    public function resetTOTP(Request $request)
    {
        $request->user()->resetTOTP();

        return back();
    }
}
