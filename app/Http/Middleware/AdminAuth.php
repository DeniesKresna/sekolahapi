<?php

namespace App\Http\Middleware;

use App\Http\Controllers\ApiController;
use App\Models\Admin;
use App\Models\AdminToken;
use Closure;

class AdminAuth extends ApiController
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
        $token = $request->header("token");
        if (!empty($token)) {
            $res = AdminToken::query()->where("token","=",$token)->whereRaw("expired_time > NOW()")->first();
            if ($res){
                $admin = Admin::query()->where("id","=",$res->admin_id)->first();
                if ($admin) {
                    if(in_array($admin->role, $roles))
                    $request->attributes->add(['auth' => to_object(["admin"=>$admin])]);
                    return $next($request);
                }
            }
        }
        return self::error_responses(null, "Your request not allowed");
    }
}
