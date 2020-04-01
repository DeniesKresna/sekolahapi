<?php

namespace App\Http\Controllers\v1\User\Auth;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Password;
use App\Models\User;
use App\Models\PasswordReset;
use Hash;
use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;

class ForgotPasswordController extends ApiController
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
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

    public function newPassword(Request $request) {
        $email = Crypt::decrypt($request->email);
        $token = $request->token;
        $getUserToken = PasswordReset::where('email','=', $email)
                        ->where('created_at','>',Carbon::now()->subHours(2))
                        ->first();
        if (!$getUserToken) {
            return self::error_responses("Token Credentials Was Exipired");
        }

        $checkHashToken = Hash::check($token, $getUserToken->token);        
        if ($checkHashToken == true) {
            $validate = $this->validate($request, ['password' => 'required|string|min:6|confirmed']);
            if (!$validate->error){
                if ($request->password === $request->password_confirmation){
                    $datas["password"] = password_encrypt($request->password);
                    $user = User::query()->where('email',"=",$email)->first();
                    $res = $user->update($datas);
                    if ($res){
                        return self::success_responses($res);
                    } else {
                        return self::error_responses("Unkown error");
                    }
                } else {
                    return self::error_responses("Credentials error");
                }
            } else {
                //Validation error
                return self::error_responses($validate->messages);
            }             
        }  else {
            return self::error_responses("Token Credentials Is Not Valid");
        }     
    }

    public function checkTokenReset($token, Request $request)
    {
        $email = Crypt::decrypt($request->email);

        $token = $request->token;
        $getUserToken = PasswordReset::where('email', '=', $email)
                        ->where('created_at', '>', Carbon::now()->subHours(2))
                        ->first();
        if (!$getUserToken) {
            return self::error_responses("Token Credentials Was Exipired");
        }

        $checkHashToken = Hash::check($token, $getUserToken->token);
        if ($checkHashToken) {
            return self::success_responses($token);
        }
        else {
            return self::error_responses("Token Credentials Is Not Valid");
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendResetLinkEmail(Request $request)
    {
        $validate = $this->validate($request, ['email' => 'required|email']);
        if (!$validate->error){
            $res = User::query()->whereRaw("(email = ? OR username = ?)",[$request->email,$request->email])->first();
            if ($res) {
                // We will send the password reset link to this user. Once we have attempted
                // to send the link, we will examine the response then see the message we
                // need to show to the user. Finally, we'll send out a proper response.
                $response = $this->broker()->sendResetLink(
                    $request->only('email')
                );
                return $response == Password::RESET_LINK_SENT
                    ? self::success_responses($response)
                    : self::error_responses("Send email failed");
            } else {
                //Email not found
                return self::error_responses("Send email failed. Email not found.");
            }
        } else {
            //Validation error
            return self::error_responses($validate->messages);
        }
    }

    /**
     * Get the broker to be used during password reset.
     *
     * @return \Illuminate\Contracts\Auth\PasswordBroker
     */
    public function broker()
    {
        return Password::broker();
    }


    /**
     * @param Request $request
     * @return array|mixed
     */
    public function validate($request, $rules)
    {
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()){
            return to_object(["error"=>true,"messages"=>$validator->errors()]);
        } else {
            return to_object(["error"=>false]);
        }
    }
}
