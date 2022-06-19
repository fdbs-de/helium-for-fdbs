<?php

namespace App\Http\Middleware;

use App\Permissions\Permissions;
use Closure;
use Illuminate\Http\Request;

class PanelAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $profile = null)
    {
        $user = $request->user();

        switch ($profile)
        {
            case 'employee':    if (!$user->can_access_employee_panel)  { return redirect()->route('dashboard.profile'); } break;
            case 'customer':    if (!$user->can_access_customer_panel)  { return redirect()->route('dashboard.profile'); } break;
            case 'admin':       if (!$user->can_access_admin_panel)     { return redirect()->route('dashboard.profile'); } break;
            default:            return $next($request); break;
        }

        return $next($request);
    }
}
