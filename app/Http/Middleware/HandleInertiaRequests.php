<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    protected $rootView = 'app';

    public function version(Request $request): string|null
    {
        return parent::version($request);
    }

    public function share(Request $request): array
    {
        return array_merge(parent::share($request), [
            'auth' => [
                'user' => $request->user() ? [
                    'id'          => $request->user()->id,
                    'name'        => $request->user()->name,
                    'email'       => $request->user()->email,
                    'role'        => $request->user()->roles->first()?->name,
                    'is_pro'      => (bool) $request->user()->is_pro,
                    'has_program' => $request->user()->programs()->exists(),
                ] : null,
            ],
            'ziggy' => fn () => [
                'url' => $request->url(),
                'port' => $request->getPort(),
                'defaults' => [],
                'routes' => collect(app('router')->getRoutes())->mapWithKeys(function ($route) {
                    return [$route->getName() => [
                        'uri' => $route->uri(),
                        'methods' => $route->methods(),
                    ]];
                })->filter(fn($route, $name) => !is_null($name))->toArray(),
            ],
            'flash' => [
                'success' => fn () => $request->session()->get('success'),
                'error'   => fn () => $request->session()->get('error'),
            ],
            'cart_count' => fn () => $request->session()->get('cart', []) ? count($request->session()->get('cart', [])) : 0,
            'locale' => fn () => app()->getLocale(),
        ]);
    }
}
