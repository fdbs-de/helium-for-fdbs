<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VerifyMultiFactorAuthentication
{
    public function handle(Request $request, Closure $next)
    {
        // If MFA is enabled, check if the user has verified their MFA status
        if (Auth::user()->hasMfaEnabled && !session()->has('verified_mfa'))
        {
            return redirect()->route('mfa');
        }

        return $next($request);
    }
}
