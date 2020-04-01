<?php

namespace App\Http\Controllers\v1\User\Auth;

use App\Http\Controllers\ApiController;
use App\Models\User;
use App\Models\UserToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LoginController extends ApiController
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
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
        $validate = $this->validate($request);
        if (!$validate->error){
            $res = User::query()->whereRaw("(email = ? OR username = ?) AND password = ?",[$request->email,$request->email,password_encrypt($request->password)])->first();
            if ($res){
                $res->last_login = date('Y-m-d H:i:s');
                $res->save();

                $current_token = UserToken::query()->where("user_id",'=',$res->id)->whereRaw("expired_time > NOW()")->first();
                if (!$current_token){
                    $expired_time = date("Y-m-d H:i:s",strtotime("+".env("USER_TOKEN_LIFETIME",120)." MINUTES"));
                    $token = (new \Dirape\Token\Token)->RandomString(60);
                    $id = UserToken::query()->insertGetId([
                        'expired_time'=>$expired_time,
                        'dt_added'=>date("Y-m-d H:i:s"),
                        'token'=>$token,
                        'user_id'=>$res->id
                    ]);
                } else {
                    $id = $current_token->id;
                }
                $token = UserToken::with("user")->find($id);
                $token->user->role = $token->user->roles ? $token->user->roles->first() : 'No role';
                unset($token->user->roles);
                return self::success_responses(array_merge(to_array($token),["user"=>$token->user]));
            } else {
                return self::error_responses(null, "Wrong credentials");
            }
        } else {
            return self::error_responses($validate->messages);
        }
    }

    /**
     * @param Request $request
     * @return array|mixed
     */
    public function validate($request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|max:200',
            'password' => 'required|string|min:6|max:100',
        ]);
        if ($validator->fails()){
            return to_object(["error"=>true,"messages"=>$validator->errors()]);
        } else {
            return to_object(["error"=>false]);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkToken(Request $request) {
        $token = $request->header('token');

        if (!empty($token)) {
            $auth = $request->get('auth');
            $user = User::query()->where('id',"=",$auth->user->id)->first();
            return self::success_responses(["token" => $token, "user" => $user]);
        } else {
            return self::error_responses("Token Was Expired");
        }
    }

}
