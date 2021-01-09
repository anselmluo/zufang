<?php

namespace App\Http\Middleware;

use Closure;

class CheckAdminLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //检查是否登录
        if (!auth()->check()) {
            return redirect(route('admin.login'))->withErrors(['error' => '请登录']);
        }

        //f访问权限
        $auths = is_array(session('admin.auth')) ? array_filter(session('admin.auth')) : [];
        $auths = array_merge($auths, config('rbac.allow_route'));

        $currentRoute = $request->route()->getName();
        if (auth()->user()->username != config('rbac.super') && !in_array($currentRoute, $auths)) {
            exit('无访问权限');
        }

        //使用request传到下一层去
        $request->auths = $auths;
        return $next($request);
    }
}
