<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VerifyRememberedMultiFactorAuthentication
{
    public function handle(Request $request, Closure $next)
    {
        // TODO: Security check... is this safe?

        // If user logs in via remember and has enabled MFA, verify their MFA status
        if (Auth::user()->hasMfaEnabled && Auth::viaRemember())
        {
            session()->put('verified_mfa', true);
        }

        return $next($request);
    }
}
