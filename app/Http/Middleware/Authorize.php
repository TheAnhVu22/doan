<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Log;

class Authorize
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function handle($request, Closure $next)
    {
        // Get route name as ability
        $ability = $request->route()->getName();

        // Check ability authorized admin to access
        if (!(\Auth::guard('admin')->user()->hasAbility($ability))) {
            return redirect(getUrlByRole());
        }
        return $next($request);
    }
}
