<?php
namespace App\Traits;

use Illuminate\Support\Facades\DB;
use Datetime;

trait Slotting{
    public function get_available_slot($start_date, $end_date, $locations,$device_types){
        $start_date = date("Y-m-d H:00:00", strtotime($start_date));
        $end_date = date("Y-m-d H:00:00", strtotime($end_date));
        //get device online
        $devices = DB::table('devices as d')->join('device_lines as dl','dl.device_id','=','d.id')
                        ->join('layouts as l','l.id','=','dl.layout_id')
                        ->join('layout_boxes as lb','lb.layout_id','=','l.id')
                        ->where('lb.enable_slotting','>',0)
                        ->whereIn('d.location_id',$locations)
                        ->whereIn('d.device_type_id',$device_types)
                        //->where('d.last_gps_time','>',DB::raw('NOW() - INTERVAL 2 DAY'))
                        ->groupBy('dl.id')
                        ->orderBy('dl.id')
                        ->select("*","lb.id as lb_id","l.name as l_name","l.type as l_type","l.timeout as l_timeout")
                        ->get();

        //get campaign used
        $campaigns = DB::table('campaigns as c')
                    ->leftJoin('campaign_summaries as cs','c.id','=','cs.campaign_id')
                    ->join('campaign_location as cl','cl.campaign_id','=','c.id')
                    ->join('campaign_device_type as cdt','cdt.campaign_id','=','c.id')
                    ->select(DB::raw('c.*,(c.slots - SUM(cs.slot_played)) as slot_unplayed'))
                    ->groupBy('c.id')
                    ->whereIn('cl.location_id',$locations)
                    ->whereIn('cdt.device_type_id',$device_types)
                    ->where('c.status',1)
                    ->where('c.end_date','>',$start_date)
                    ->orderby('c.id')->get();

        $total_hour_requested = $this->block_hour($start_date, $end_date);
        $all_campaign_slot_booked_on_requested_hour = 0;
        $max_slot = 240;

        foreach($campaigns as $campaign){
            if(!$campaign->slot_unplayed){
                $campaign->slot_unplayed = $campaign->slots;
            }
            if($campaign->slot_unplayed <= 0){
                continue;
            }
            //
            $campaign_sd = $start_date;
            $campaign_ed = date("Y-m-d H:0:0", strtotime($campaign->end_date));
            $total_hour = $this->block_hour($campaign_sd, $campaign_ed);
            $booked = intval(ceil($campaign->slot_unplayed / ($total_hour*count($devices))));
            $campaign_slot_booked_on_requested_hour = $booked * count($devices) * $total_hour_requested;
            $all_campaign_slot_booked_on_requested_hour += $campaign_slot_booked_on_requested_hour;
        }

        return intval((($total_hour_requested * $max_slot)*count($devices))  - $all_campaign_slot_booked_on_requested_hour);
    }

    public function block_hour($next_hour, $end_date){
        $exception_hours = [];
        $exception_days = [];
        $hour_block = 0;
        $time_travel = strtotime($next_hour);
        while($time_travel < strtotime($end_date)){
            $hour_block++;
            $time_travel = strtotime(date("Y-m-d H:i:s",$time_travel)." +1 hour");
        }
        return $hour_block;
    }
}