<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;

class Role
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, ...$roles)
    {
        $user = Auth::user();
        if ($user) {
            foreach ($roles as $role) {
                try {
                    if ($user->hasRole($role)) {
                        return $next($request);
                    }

                } catch (ModelNotFoundException $exception) {
                    abort(403);
                }
            }
        }
        return redirect()->route("login");
    }
}
