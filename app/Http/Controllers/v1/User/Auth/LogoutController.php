<?php

namespace App\Http\Controllers\v1\User\Auth;

use App\Http\Controllers\ApiController;
use App\Models\UserToken;
use Illuminate\Http\Request;

class LogoutController extends ApiController
{
    /*
    |--------------------------------------------------------------------------
    | Logout Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request){
        $token = $request->header("token");
        if (!empty($token)) {
            $res = UserToken::query()->where("token","=",$token)->whereRaw("expired_time > NOW()")->update(["expired_time"=>date("Y-m-d H:i:s")]);

            if ($res){
                return self::success_responses(null, "Logout success");
            }
        }
        return self::error_responses(null, "Logout Fail");
    }

}
