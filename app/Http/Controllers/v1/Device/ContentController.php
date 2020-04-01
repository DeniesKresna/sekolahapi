<?php

namespace App\Http\Controllers\v1\Device;

use App\Http\Controllers\ApiController;
use App\Models\Content;
use App\Models\Device;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;

class ContentController extends ApiController
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function downloading(Request $request)
    {
        if($request->has('imei')){
        	$imei = $request->imei;
        	$device = Device::where('imei',$imei)->firstOrFail();
	        $array_list = [];

        	if($device->download_status == 1){
	        	$time_content = date('Y-m-d H:i:s', strtotime(date("Y-m-d H:00:00").'+1 hour'));
	        	$time_content_end = date('Y-m-d H:i:s', strtotime($time_content.'+1 hour'));

		        //two line below used for development testing. delete if going to production.
		        /*
	            $time_content = date('Y-m-d H:i:s', strtotime(date("Y-m-d H:00:00")));
	            $time_content_end = date('Y-m-d H:i:s', strtotime($time_content.'+1 hour'));
	            */

	        	/*-----------------------------------------------------------------------------
	        	| get all slots that reference to the device which has imei like the request data
	        	| and the slot time is interval one hour on the next hour.
	        	| and only take the list of the content id
				|-----------------------------------------------------------------------------*/
	        	$slots = DB::table('slots as s')
	        				->join('device_lines as dl','dl.id','=','s.device_line_id')
	        				->join('devices as d','d.id','=','dl.device_id')
	        				->where('d.id',$device->id)
	        				->where('s.start_time','>=',$time_content)
	        				->where('s.end_time','<=',$time_content_end)
	        				->groupBy('content_id')
	        				->pluck('content_id');

	        	$contents = Content::whereIn('id',$slots)->get();
	        	foreach ($contents as $content) {
	        		$tmp['filename'] = $content->file_name;
	        		$tmp['urldownload'] = $content->file_url;
	        		array_push($array_list, $tmp);
	        	}

	        	$data["list"] = $array_list;
	        	$data["timezone"] = "Asia/Jakarta";
	        	$data["timerestart"] = 120;
	            $data["timedownload"] = 30;
	        	$data["password"] = "20200";
	        	return response()->json($data);
	        }
	        $data["list"] = $array_list;
	        $data["timezone"] = "Asia\Jakarta";
	        $data["timerestart"] = 120;
	        $data["timedownload"] = 30;
	        $data["password"] = "20200";
	        return response()->json($data);
        }
        else{
        	return response()->json(['message'=>"need Imei as parameter"],422);
        }
    }

    public function downloaded(Request $request)
    {
        if($request->has('imei')){
        	$imei = $request->imei;
        	$device = Device::where('imei',$imei)->firstOrFail();

        	if($device->download_status == 1){
        		$device->download_status == 0;
        		$device->save();
	        }
	        $data["status"] = "ok";
	        $data["message"] = "Update status completed !!!";
	        return response()->json($data);
        }
        else{
        	return response()->json(['message'=>"need Imei as parameter"],422);
        }
    }
}