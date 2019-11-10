<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard("admin")->check()) {
            return redirect('/admin/index');
        }

        if (Auth::guard("customer")->check()) {
            return redirect('/customer/');
        }

        return $next($request);
    }
}
