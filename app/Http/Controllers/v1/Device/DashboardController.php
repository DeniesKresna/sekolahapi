<?php

namespace App\Http\Controllers\v1\Device;

use App\Http\Controllers\ApiController;
use App\Models\Device;
use Illuminate\Http\Request;
use Validator;

class DashboardController extends ApiController
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        if($request->has('imei')){
        	$imei = $request->imei;
	        $device = Device::where('imei',$imei)->first();
	        if($device){
	        	$download = null;
	        	if(!$request->has('login')){
		        	if($device->download_status == 1){
		        		$download = "downloading";
		        	}
		        	else{
		        		$download = "downloaded";
		        	}
	        	}
	        	$datas['tvid'] = strtolower($imei);
	        	$datas['status'] = "ok";
	        	$datas['download'] = $download;
	        	$datas['password'] = 20200;
	        	$datas['message'] = [];
        		return response()->json($datas);
        	}
        	else{
        		return response()->json(['message'=>"no data"]);
        	}
        }
        return response()->json(['message'=>"need Imei as parameter"]);
    }
}
//if(filter_var(request()->trashed, FILTER_VALIDATE_BOOLEAN)){