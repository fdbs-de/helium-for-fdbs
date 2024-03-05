<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VerifyMultiFactor
{
    public function handle(Request $request, Closure $next)
    {
        $mfaEnabled = $request->user()->hasMfaEnabled;

        // If the user is logging in via "remember me" and has enabled MFA, we will verify their MFA status
        if ($mfaEnabled && Auth::viaRemember())
        {
            session()->put('verified_multi_factor', true);
        }

        // Now we check if the user has verified their MFA status
        if ($mfaEnabled && !session()->has('verified_multi_factor'))
        {
            return redirect()->route('mfa');
        }

        // Lastly, if the user has verified their MFA status, we can continue
        return $next($request);
    }
}
