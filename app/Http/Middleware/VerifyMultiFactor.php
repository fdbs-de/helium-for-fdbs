<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VerifyMultiFactor
{
    public function handle(Request $request, Closure $next)
    {
        // If the user is loggen in via "remember me" cookie, we will just let them through
        if (Auth::viaRemember()) return $next($request);

        // At this point, we know that the user is logged in and has enabled MFA
        // We will check if the user has verified their MFA
        if ($request->user()->hasMfaEnabled && !session()->has('verified_multi_factor'))
        {
            return redirect()->route('mfa');
        }

        // If the user has verified their MFA, we will let them through
        return $next($request);
    }
}
