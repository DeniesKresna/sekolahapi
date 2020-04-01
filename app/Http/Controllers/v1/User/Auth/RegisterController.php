<?php

namespace App\Http\Controllers\v1\User\Auth;

use App\Http\Controllers\ApiController;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RegisterController extends ApiController
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request){
        $validate = $this->validate($request);
        if (!$validate->error){
            $res = $this->create($request->all());
            if ($res){
                return self::success_responses($res);
            } else {
                return self::error_responses("Unkown error");
            }
        } else {
            return self::error_responses($validate->messages);
        }
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  Request  $data
     * @return object
     */
    protected function validate($request)
    {
        $rules = [
            'name' => 'required|string|max:100',
            'email' => 'required|string|max:200|unique:users',
            'phone' => 'required|string|max:30',
            'address' => 'required|string|max:100',
            'username' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:6|max:100|confirmed',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()){
            return to_object(["error"=>true,"messages"=>$validator->errors()]);
        } else {
            return to_object(["error"=>false]);
        }
    }

    /**
     * @param array $data
     * @return bool|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null|static|static[]
     */
    public function create(array $data)
    {
        $user =  User::create([
            'name'=>$data["name"],
            'email'=>$data["email"],
            'phone'=>$data["phone"],
            'address'=>$data["address"],
            'username'=>$data["username"],
            'password'=>password_encrypt($data["password"]),
            //'type'=>'customer',
            'active'=>1,
        ]);
        $user->attachRole(Role::query()->where("name","=","customer")->first());
        $user->save();
        if ($user){
            return $user;
        } else {
            return false;
        }
    }

}
