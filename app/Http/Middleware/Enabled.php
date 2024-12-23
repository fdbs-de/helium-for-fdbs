<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Enabled
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (!$request->user()->is_enabled)
        {
            // Logout user
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            // Redirect to login page
            return redirect()->route('login')->withErrors(['enabled' => 'Ihr Account wurde noch nicht freigegeben.']);
        }

        return $next($request);
    }
}
