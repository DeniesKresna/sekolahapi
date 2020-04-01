<?php

namespace App\Http\Controllers\v1\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\Models\Device;
use Illuminate\Support\Facades\DB;
use Validator;

class DeviceController extends ApiController
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request) {
        $page = !empty($request->page)?$request->page:1;
        $page_size = !empty($request->page_size)?$request->page_size:10;
        $search = $request->search;

        $datas = Device::where('id','>',0);

        if($request->has('trashed')){
            if(filter_var(request()->trashed, FILTER_VALIDATE_BOOLEAN)){
                $datas = $datas->withTrashed();
            }
        }

        if($request->has('search')){
                $datas = $datas->where(function($query) use($search){
                    $query->where('name','like','%'.$search.'%')
                            ->orWhere('imei','like','%'.$search.'%')
                            ->orWhere('sim_card_no','like','%'.$search.'%')
                            ->orWhere('sim_card_serial','like','%'.$search.'%')
                            ->orWhere('monitor','like','%'.$search.'%');
                });

                $datas = $datas->orWhereHas('device_type',function($query) use($search){
                    $query->where('name','like','%'.$search.'%');
                });
        }

        if($request->has('active')){
            $datas = $datas->where('active',filter_var($request->active, FILTER_VALIDATE_BOOLEAN));
        }
/*
        $datas = $datas->orderBy('id', 'desc')->with('box', 'box.car', 'driver', 'kudo', 'kudo.kudoMerchant', 'kudo.kudoMerchant.kudoMerchantGroup','device_location.location')->paginate($page_size, ["devices.*"], "page", $page);
*/
        $datas = $datas->orderBy('id', 'desc')->with(['creator','location','device_line','device_line.layout','device_line.layout.boxes','device_type'])->paginate($page_size, ["devices.*"], "page", $page);

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
    public function list(Request $request) {
        $search = $request->search;
        $datas = Device::query()->where('id','>',0);
        if ($request->search) $datas = $datas->where('imei','like','%'.$search.'%');
        $datas = $datas->where("active","=",1);
        $datas = $datas->orderBy('id', 'desc')->get();
        return self::success_responses($datas);
    }

    public function store(Request $request){
        $datas = $request->all();
        $session_id = $request->get('auth')->user->id;

        $validator = Validator::make($datas, rules_lists(__CLASS__, __FUNCTION__));
        if($validator->fails()) return self::error_responses($validator->messages());

        $datas['creator_id'] = $session_id;
        $datas['active'] = 1;

        $result = Device::create($datas);
        if($result)
            return self::success_responses($result->load(['creator','location','device_line','device_line.layout','device_line.layout.boxes','device_type']));
        else
            return self::error_responses("Unknown Error");
    }

    public function update(Request $request, $id){
        $datas = $request->all();
        $session_id = $request->get('auth')->user->id;
        
        $validator = Validator::make($datas, rules_lists(__CLASS__, __FUNCTION__));
        if($validator->fails()) return self::error_responses($validator->messages());

        $datas['creator_id'] = $session_id;
        $result = Device::findOrFail($id);
        $result->update($datas);
        if($result)
            return self::success_responses($result->load(['creator','location','device_line','device_line.layout','device_line.layout.boxes','device_type']));
        else
            return self::error_responses("Unknown Error");
    }

    public function show($id){
        $res = Device::findOrFail($id);
        if ($res)
            return self::success_responses($res->load(['creator','location','device_line','device_line.layout','device_line.layout.boxes','device_type']));
        else
            return self::error_responses("Unkown error");
    }

    public function destroy($id){
        $res = Device::findOrFail($id);
        if($request->has('hard')){
            if(filter_var(request()->hard, FILTER_VALIDATE_BOOLEAN)){
                $res->slots()->detach();
                $res->forceDelete();
                return self::success_responses("Success Delete Device");
            }
        }
        $res->delete();
        return self::success_responses("Success Delete Device");
    }

    public function summary(Request $request){
        if($request->has('start_time'))
            $start_time = date("Y-m-d H:i:s", strtotime($request->start_time));
        else
            $start_time = date("Y-m-d H:i:s");

        if($request->has('end_time'))
            $end_time = date("Y-m-d H:i:s", strtotime($request->end_time));
        else
            $end_time = date("Y-m-d H:i:s");
        
        $validator = Validator::make($request->all(), rules_lists("Global","any"));
        if($validator->fails()) return self::error_responses($validator->messages());

        $devices = DB::table('devices')->get();
        foreach($devices as $device){
            $device_additional_data = DB::table('device_summaries')
                                        ->where('imei',$device->imei)
                                        ->where('dt','>=',$start_time)
                                        ->where('dt','<=',$end_time)
                                        ->select(DB::raw('sum(total_air_time) as online, sum(dst) as distance, avg(avg_speed) as speed','imei'))
                                        ->get();

            $device->online = $device_additional_data[0]->online;
            $device->distance = $device_additional_data[0]->distance;
            $device->speed = $device_additional_data[0]->speed;
            $device->on_status = "offline";
            $device->last_on = "";
            $device_summary = DB::table('device_summaries')->where('imei',$device->imei)
                                ->orderBy('last_on','desc')->first();
            if($device_summary){
              $device->on_status = $this->onlineStatusByTimeDifference($device_summary->last_on,$end_time);
              $device->last_on = $device_summary->last_on;
            }
        }
        return self::success_responses(['dsi'=>$devices, 'total'=>count($devices)]);
    }

    private function onlineStatusByTimeDifference($time1, $time2){
        $time1 = intval(strtotime($time1));
        $time2 = intval(strtotime($time2));
        $diff = abs($time1-$time2);
        if($diff <= (config('options.online_minutes') * 60))
            return "online";
        if($diff <= (config('options.standby_minutes') * 60))
            return "standby";
        return "offline";
    }

    private function isHaveTimeDifference($time1, $time2, $tolerance_range=1, $type="Day"){
        $time1 = intval(strtotime($time1));
        $time2 = intval(strtotime($time2));
        $diff = abs($time1-$time2);
        if($type == "Day")
            $tolerance_time = $tolerance_range * 60 * 60 * 24;
        else if($type == "Hour")
            $tolerance_time = $tolerance_range * 60 * 60;
        else
            $tolerance_time = $tolerance_range * 60;
        if($diff > $tolerance_time)
            return true;
        else
            return false;
    }
}
