<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VerifyMultiFactor
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::user()->hasMfaEnabled)
        {
            if (!session()->has('verified_multi_factor'))
            {
                return redirect()->route('mfa');
            }
        }

        return $next($request);
    }
}
