<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SelectApp
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, string $app)
    {
        $appRepository = [
            'blog' => ['id' => 'blog', 'name' => 'Blog', 'route' => 'blog'],
            'wiki' => ['id' => 'wiki', 'name' => 'Wiki', 'route' => 'wiki'],
            'jobs' => ['id' => 'jobs', 'name' => 'Jobs', 'route' => 'jobs'],
            'intranet' => ['id' => 'intranet', 'name' => 'Intranet', 'route' => 'intranet'],
        ];

        if (!array_key_exists($app, $appRepository)) abort(404);

        $request->merge(['app' => $appRepository[$app]]);
        
        return $next($request);
    }
}
