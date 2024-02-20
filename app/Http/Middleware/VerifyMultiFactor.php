<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class VerifyMultiFactor
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->user()->hasMfaEnabled && !session()->has('verified_multi_factor'))
        {
            if ($request->expectsJson())
            {
                return response()->json(['message' => 'You must verify your multi factor authentication before proceeding.'], 401);
            }
            
            return redirect()->route('mfa');
        }

        return $next($request);
    }
}
