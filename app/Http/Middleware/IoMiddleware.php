<?php

namespace App\Http\Middleware;

use App\Services\MenuService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IoMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();
        $user_roles = $user->list_akses->pluck('akses')->toArray();
        $active_role = session('active_role', $user->akses->akses);
        if ($request->method() === 'GET') {
            $menuService = new MenuService();
            $menus = $menuService->list_menu($active_role);

            view()->share(['menus' => $menus, 'active_role' => $active_role, 'all_roles' => $user_roles]);
            $current_route = $request->route()->getName();
            $current_route_params = $request->query();
            view()->share($menuService::current_menu($menus, $current_route, $active_role, $current_route_params));
        }
        return $next($request);
    }
}
