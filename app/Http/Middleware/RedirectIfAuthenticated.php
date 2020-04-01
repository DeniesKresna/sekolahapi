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
        $user = Auth::user();
        if ($user){
            if ($user->hasRole("customer"))
                return redirect()->route("submission");
            elseif ($user->hasRole("superadmin") || $user->hasRole("shopadmin")) return redirect()->route("admin.home");
        }
        return $next($request);
    }
}
