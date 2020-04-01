<?php

namespace App\Http\Controllers\v1\Admin;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class UserController extends ApiController
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request)
    {
        $auth = $request->get('auth');
        $user = User::find($auth->user->id);

        if ($user) {
        	$validate = $this->validate($request, ['name' => 'required|string', 'phone' => 'required|string|max:13', 'address' => 'required|string']);
            if (!$validate->error){
	        	$name = $request->name;
	        	$phone = $request->phone;
	        	$address = $request->address;

	        	$user->name = $name;
	        	$user->phone = $phone;
	        	$user->address = $address;
	        	$user->save();

	        	return self::success_responses($user);
	        } 
	        else {
	        	return self::error_responses($validate->messages);
	        }
        } 
        else {
        	return self::error_responses("User doesn't exist");
        }
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
