<?php

namespace App\Http\Controllers\v1\User\Auth;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ResetPasswordController extends ApiController
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request)
    {
        $auth = $request->get('auth');
        $user = User::query()->where('id',"=",$auth->user->id)->first();
        if (password_encrypt($request->old_password) == $user->password && $request->new_password === $request->password_confirm){
            $datas["password"] = password_encrypt($request->new_password);
            $res = $user->update($datas);
            if ($res){
                return self::success_responses($res);
            } else {
                return self::error_responses("Unkown error");
            }
        } else {
            return self::error_responses("Credentials error");
        }
    }

}
