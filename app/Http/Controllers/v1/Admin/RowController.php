<?php

namespace App\Http\Controllers\v1\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\Models\Device;
use Illuminate\Support\Facades\DB;
use Validator;

class RowController extends ApiController
{
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

        $device_summary_infos = DB::table('device_summary_info')->get();
        foreach($device_summary_infos as $device_summary_info){
            $device_additional_data = DB::table('baris_summaries')
                                        ->where('imei',$device_summary_info->imei)
                                        ->where('dt','>=',$start_time)
                                        ->where('dt','<=',$end_time)
                                        ->select(DB::raw('sum(total_air_time) as online, sum(dst) as distance, avg(avg_speed) as speed'))
                                        ->get();

            $device_summary_info->online = $device_additional_data[0]->online;
            $device_summary_info->distance = $device_additional_data[0]->distance;
            $device_summary_info->speed = $device_additional_data[0]->speed;
            $device_summary_info->on_status = "offline";
            $device_summary_info->last_on = "";
            $baris_summary = DB::table('baris_summaries')->where('imei',$device_summary_info->imei)
                                ->orderBy('last_on','desc')->first();
            if($baris_summary){
              $device_summary_info->on_status = $this->onlineStatusByTimeDifference($baris_summary->last_on,$end_time);
              $device_summary_info->last_on = $baris_summary->last_on;
            }
        }
        return self::success_responses(['dsi'=>$device_summary_infos, 'total'=>count($device_summary_infos)]);
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
}
