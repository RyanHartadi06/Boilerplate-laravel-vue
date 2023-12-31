<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Defines the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function share(Request $request): array
    {
        $guard  = 'web';
        $auth   = Auth::guard($guard);

        return array_merge(parent::share($request), [
            'auth' => function () use ($auth, $guard) {
                return [
                    'user' => $auth->user() ? [
                        'id'            => $auth->user()->id,
                        'name'          => $auth->user()->name,
                        'email'         => $auth->user()->email,
                        'permissions'   => $auth->user()->getAllPermissions()->map->name,
                        'roles'         => $auth->user()->getRoleNames(),
                        'image'         => $auth->user()->image ? $auth->user()->image : $auth->user()->avatar,
                        'guard'         => $guard,
                    ] : null,
                ];
            },
            'flash' => function () {
                return [
                    'success'   => Session::get('success'),
                    'error'     => Session::get('error'),
                ];
            },
        ]);
    }
}
