<?php

namespace App\Http\Middleware;

use App\Models\Document;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Middleware;
use Tightenco\Ziggy\Ziggy;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function version(Request $request)
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function share(Request $request)
    {
        if ($request->user())
        {
            $user = $request->user()->refresh()->load(['settings']);
            $user->permission_list = $user->getAllPermissions()->pluck('name')->toArray();
        }

        return array_merge(parent::share($request), [
            'auth' => [
                'user' => $user ?? null,
            ],

            'ziggy' => function () {
                return (new Ziggy)->toArray();
            },

            'flash' => [
                'message' => fn () => $request->session()->get('message'),
                'success' => fn () => $request->session()->get('success'),
                'error' => fn () => $request->session()->get('error'),
            ],
        ]);
    }
}
