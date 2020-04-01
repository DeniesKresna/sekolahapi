<?php

namespace App\Http\Controllers\v1\Admin;

use App\Models\DeviceType;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\Models\Device;
use App\Models\DeviceLine;
use Illuminate\Support\Facades\DB;
use Validator;

class DeviceLineController extends ApiController
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request) {
        $page = !empty($request->page)?$request->page:1;
        $page_size = !empty($request->page_size)?$request->page_size:10;
        $search = $request->search;

        $datas = DeviceLine::where('id','>',0);

        if($request->has('imei')){
            $imei = $request->imei;
            $checkImei = $datas->where('device_id',function($query) use ($imei){
                $query->select('id')->from('devices')->where('imei',$imei)->value('id');
            })->first();
            if($checkImei){
                $datas = $checkImei;
            }
        }
        $datas = $datas->orderBy('id', 'desc')
            ->with(['device','box','car','driver','layout','device_type'])
            ->paginate($page_size, ["*"], "page", $page);

        $data = [
            "total"=>$datas->total(),
            "page_size"=>$datas->perPage(),
            "page"=>$datas->currentPage(),
            "result"=>$datas->items(),
            "previous_page_url" => $datas->previousPageUrl(),
            "next_page_url" => $datas->nextPageUrl(),
        ];

        return self::success_responses($data);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request){
        $validator = Validator::make($request->all(), rules_lists(__CLASS__, __FUNCTION__));
        if($validator->fails()) return self::error_responses($validator->messages());
        $datas = to_object($request->all());
        $result = DeviceLine::query()->create([
            "device_id"=>!empty($datas->device_id)?$datas->device_id:0,
            "box_id"=>!empty($datas->box_id)?$datas->box_id:0,
            "car_id"=>!empty($datas->car_id)?$datas->car_id:0,
            "driver_id"=>!empty($datas->driver_id)?$datas->driver_id:0,
            "layout_id"=>!empty($datas->layout_id)?$datas->layout_id:0,
            "device_type_id"=>!empty($datas->device_type_id)?$datas->device_type_id:0
        ]);
        if ($result)
            return self::success_responses('There is Device Line reference to that Device');
        else
            return self::error_responses("No device with that id");
    }


    public function create(Request $request, $device_id){
        $device = Device::find($device_id);
        if($device){
            if(!$device->device_line){
                $device_line = $device->device_line()->create($device->toArray());
                if($device_line){
                    return self::success_responses($device_line->load(['device','box','car','driver','layout','device_type']));
                }else{
                    return self::error_responses('Unknown Error');
                }
            }
            else{
                return self::error_responses('There is Device Line reference to that Device');
            }
        }
        return self::error_responses("No device with that id");
    }

    public function show($id){
        $res = DeviceLine::findOrFail($id);
        if ($res)
            return self::success_responses($res->load("device","box","car","driver","layout","device_type"));
        else
            return self::error_responses("Unkown error");
    }

    public function update(Request $request, $id){
        $datas = $request->all();
        $validator = Validator::make($request->all(), rules_lists(__CLASS__, __FUNCTION__, ["id"=>$id]));
        if($validator->fails()) return self::error_responses($validator->messages());
        $result = DeviceLine::findOrFail($id);

        $result->update($datas);
        if($result)
            return self::success_responses($result->load(['device','box','car','driver','layout','device_type']));
        else
            return self::error_responses("Unknown Error");
    }

    public function destroy($id){
        $res = DeviceLine::findOrFail($id);
        $res->delete();
        return self::success_responses("Success Delete Device");
    }
}
