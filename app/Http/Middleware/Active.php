<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Active
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
        if ($request->user()->is_terminated)
        {
            // Logout user
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            // Redirect to login page
            return redirect()->route('login')->withErrors(['terminated' => 'Ihr Account wurde deaktiviert.']);
        }

        return $next($request);
    }
}
