<?php

namespace App\Http\Controllers\v1\Device;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use App\Models\Campaign;
use App\Models\Device;
use App\Models\DeviceSchedule;
use App\Models\LayoutBox;
use App\Models\SlotImpression;
use Illuminate\Support\Facades\DB;
use App\Traits\Slotting;

class SlotController extends ApiController
{
    use Slotting;
    //
    public function played(Request $request){
        $data = $request->all();
        $raw_id = DB::table('slot_raws')->insertGetId(['imei'=>$request->device_id, 'data'=>json_encode($request->data), 'created_at'=>date("Y-m-d H:i:s"), 'updated_at'=>date("Y-m-d H:i:s")]);
    	if($raw_id){
    		foreach($data['data'] as $dt){
                $slot_impression = DB::table('slot_impressions')
                        ->where('imei',$request->device_id)
                        ->where('content_id',$dt['idmedia'])
                        ->where('campaign_id',$dt['idcampaign'])
                        ->where('play_start_time',$dt['starttime'])
                        ->where('play_end_time',$dt['endtime'])
                        ->first();

                if(!$slot_impression){
    	    		$res = DB::table('slot_impressions')->insert(
                        ['imei'=>$data['device_id'], 'content_id'=>$dt['idmedia'], 'campaign_id'=>$dt['idcampaign'], 'play_start_time'=>$dt['starttime'], 'play_end_time'=>$dt['endtime'], 'created_at'=>date('Y-m-d H:i:s'), 'updated_at'=>date('Y-m-d H:i:s')]
                    );
                    if(!$res){
                        DB::table('slot_raws')->where('id',$raw_id)->delete();
                        return response()->json(['status'=>'not-ok']);
                    }
                }
    		}
    	}
        return response()->json(['status'=>'ok']);
    }

    public function generate(){
        $next_hour_start = date("Y-m-d H:00:00", strtotime(date("Y-m-d H:i:s")." +1 hour"));
        $next_hour_end = date("Y-m-d H:00:00", strtotime($next_hour_start. " +1 hour"));

        //make sure device schedule generated once
        
        $device_schedule = DeviceSchedule::orderBy('created_at','desc')->first();
        if($device_schedule){
            $last_device_schedule_hour = date("Y-m-d H:00:00", strtotime($device_schedule->created_at."+1 hour"));
            if($last_device_schedule_hour == $next_hour_start){
                return self::success_responses("slot has been created on last generate");
            }
        }

        //get device online
        $devices = DB::table('devices as d')->join('device_lines as dl','dl.device_id','=','d.id')
                        ->join('layouts as l','l.id','=','dl.layout_id')
                        ->join('layout_boxes as lb','lb.layout_id','=','l.id')
                        ->where('lb.enable_slotting','>',0)
                        //->where('d.last_gps_time','>',DB::raw('NOW() - INTERVAL 2 DAY'))
                        ->groupBy('dl.id')
                        ->orderBy('dl.id')
                        ->select("*","lb.id as lb_id","l.name as l_name","l.type as l_type","l.timeout as l_timeout")
                        ->get();
        if(count($devices) == 0){
            return response()->json(['message'=>"no device available"]);
        }
        //get campaign used
        $campaigns = DB::table('campaigns as c')
                    ->leftJoin('campaign_summaries as cs','c.id','=','cs.campaign_id')
                    ->select(DB::raw('c.*,(c.slots - SUM(cs.slot_played)) as slot_unplayed'))
                    ->groupBy('c.id')
                    ->where('c.status',1)
                    ->where('c.start_date','<=',$next_hour_start)
                    ->where('c.end_date','>=',$next_hour_end)
                    ->orderby('c.id')->get();

        //return response()->json($campaigns);
        if(count($campaigns) == 0){
            return response()->json(['message'=>"no campaign available"]);
        }
        foreach($campaigns as $campaign){
            //set campaign additional data
            $max_slot = 240;
            if(!$campaign->slot_unplayed){
                $campaign->slot_unplayed = $campaign->slots;
            }
            if($campaign->slot_unplayed <= 0){
                continue;
            }
            $campaign->locations = DB::table('campaign_location')->where('campaign_id',$campaign->id)->pluck('location_id')->toArray();
            $campaign->device_types = DB::table('campaign_device_type')->where('campaign_id',$campaign->id)->pluck('device_type_id')->toArray();
            $campaign->contents = Campaign::find($campaign->id)->contents;
            //

            $device_match = [];
            foreach ($devices as $device) {
                if(in_array($device->location_id, $campaign->locations) && in_array($device->device_type_id, $campaign->device_types)){
                    array_push($device_match, $device);
                }
            }

            $campaign_sd = $next_hour_start;
            $campaign_ed = date("Y-m-d H:0:0", strtotime($campaign->end_date));
            $total_hour = $this->block_hour($campaign_sd, $campaign_ed);
            $booked = intval(ceil($campaign->slot_unplayed / ($total_hour*count($device_match))));
            foreach ($device_match as $device) {
                $real_booked = $booked;
                if(isset($device->remaining_slot)){
                    if($device->remaining_slot > 0){
                        if($device->remaining_slot>=$real_booked){
                            $device->remaining_slot -= $real_booked;
                        }else{
                            $real_booked = $device->remaining_slot;
                            $device->remaining_slot = 0;
                        }
                    }else{
                        continue;
                    }
                }else{
                    $device->remaining_slot = $max_slot-$real_booked;
                }

                $booked_slot = ['campaign_id'=>$campaign->id, 'slot'=>$real_booked];

                if(isset($device->booked)){
                    array_push($device->booked, $booked_slot);
                }else{
                    $device->booked[0] = $booked_slot;
                }
            }
        }

        //============get filler===================
        $slotting_layout_boxes = LayoutBox::where('enable_slotting',1)->with('sequences','layout.device_lines')->get();
        //=========================================

        $device_schedule_data = [];
        foreach ($devices as $device) {
            $device->slot = array_fill(0, 240, null);
            $device->layout_boxes = Device::find($device->device_id)->device_line->layout->boxes;
            //$device->slot = [];
            foreach($device->booked as $book){
                $campaign = $this->get_object_from_array($campaigns, 'id', $book['campaign_id']);
                $multiple_index = intval(round($max_slot / $book['slot']));
                $cmp_content_amount = count($campaign->contents);
                $cmp_counter = 0;
                $walking_counter = 0;
                while($cmp_counter < $book['slot']){
                    $walking_counter %= $max_slot;
                    if(isset($device->slot[$walking_counter])){
                        $walking_counter++;
                        continue;
                    }else{
                        $content = $campaign->contents[$cmp_counter % $cmp_content_amount];
                        $tmp = [];
                        $tmp['iddetaillayout'] = $device->lb_id;
                        $tmp['sequenceno'] = $walking_counter;
                        $tmp['idmedia'] = $content->id;
                        $tmp['typedata'] = $content->type;
                        $tmp['filename'] = $content->file_name;
                        $tmp['labeltext'] = $content->name;
                        $tmp['urldownload'] = $content->file_url;
                        $tmp['campaign_id'] = $campaign->id;
                        $tmp['status'] = "aktif";

                        $device->slot[$walking_counter] = $tmp;

                        $walking_counter += $multiple_index;
                        $cmp_counter++;
                    }
                }
            }

            //put filler content
            $filler_content = null;
            foreach ($slotting_layout_boxes as $slotting_layout_box) {
                $slotting_device_lines = $slotting_layout_box->layout->device_lines;
                foreach ($slotting_device_lines as $slotting_device_line) {
                    if($slotting_device_line->device_id == $device->device_id){
                        $filler_content = $slotting_layout_box->sequences;
                        break;
                    }
                }
                if($filler_content) break;
            }

            if($filler_content){
                if(count($filler_content) > 0){
                    $filler_counter = 0;
                    $filler_content_amount = count($filler_content);
                    for($i=0; $i<$max_slot; $i++) {
                        if(!isset($device->slot[$i])){
                            $content = $filler_content[$filler_counter % $filler_content_amount];
                            $tmp['iddetaillayout'] = $device->lb_id;
                            $tmp['sequenceno'] = $i;
                            $tmp['idmedia'] = $content->id;
                            $tmp['typedata'] = $content->type;
                            $tmp['filename'] = $content->file_name;
                            $tmp['labeltext'] = $content->name;
                            $tmp['urldownload'] = $content->file_url;
                            $tmp['campaign_id'] = 0;
                            $tmp['status'] = "aktif";

                            $device->slot[$i] = $tmp;
                            $filler_counter++;
                        }
                    }
                }else{
                    for($i=0; $i<$max_slot; $i++) {
                        if(!isset($device->slot[$i])){
                            $device->slot[$i] = "no data or use filler";
                        }
                    }
                }
            }else{
                for($i=0; $i<$max_slot; $i++) {
                    if(!isset($device->slot[$i])){
                        $device->slot[$i] = "no data or use filler";
                    }
                }
            }

            //========================================

            $array_list['nomorlayout'] = 1;
            $array_list['layoutname'] = $device->l_name;
            $array_list['starttime'] = $next_hour_start;
            $array_list['endtime'] = $next_hour_end;
            $tmp1['tvid'] = $device->imei;
            $tmp1['layoutid'] = $device->layout_id;
            $tmp1['layoutname'] = $device->l_name;
            $tmp1['layouttype'] = $device->l_type;
            $tmp1['timerlayout'] = $device->l_timeout;
            $tmp1['layoutdetail'] = [];
            $array_list['layout'] = $tmp1;

            foreach($device->layout_boxes as $layout_box){
                $tmp2['idlayout'] = $layout_box->layout_box_id;
                $tmp2['boxno'] = $layout_box->box_number;
                $tmp2['typetemplate_detail'] = $layout_box->data_type;
                $tmp2['publisher_id'] = $layout_box->lemma_publisher_id;
                $tmp2['addunitid'] = $layout_box->lemma_ads_unit_id;
                $tmp2['width'] = $layout_box->width;
                $tmp2['height'] = $layout_box->height;
                $tmp2['below'] = $layout_box->below;
                $tmp2['rightof'] = $layout_box->right_of;
                $tmp2['leftof'] = $layout_box->left_of;
                $tmp2['fontsize'] = $layout_box->font_size;
                $tmp2['periode'] = $layout_box->timeout;
                $tmp2['sequencemedia'] = [];
                if($layout_box->enable_slotting == 1){
                    $tmp2['sequencemedia'] = $device->slot;
                }
                array_push($array_list['layout']['layoutdetail'],$tmp2);
            }

            $arr[0] = $array_list;
            $datas = ['imei'=>$device->imei, 'data'=>json_encode(["list"=>$arr,"status"=>"ok","wake"=>"07:00","sleep"=>"21:00","timerdownload"=>"900","timerestart"=>120,"maxsizelemma"=>"200","maxpendingdata"=>"75000"]), 'created_at'=>date("Y-m-d H:i:s"), 'updated_at'=>date("Y-m-d H:i:s")];
            array_push($device_schedule_data, $datas);
        }

        DB::table('device_schedules')->where('created_at','<',DB::raw('NOW() - INTERVAL 2 HOUR'))->delete();
        $res = DB::table('device_schedules')->insert($device_schedule_data);
        if($res){
            return self::success_responses("generate slot schedule success");
        }else{
            return self::error_responses("Unknown error");
        }
    }

    private function get_object_from_array($arrayObject, $pivotColumn, $pivotData){
        foreach ($arrayObject as $obj) {
            if($obj->{$pivotColumn} == $pivotData)
                return $obj;
        }
    }

    private function array_object_operation($arrayObject, $column, $mode){
        $returnData = 0;
        if($mode == "sum"){
            foreach ($arrayObject as $obj){
                $returnData += $obj->{$column};
            }
        }
        return $returnData;
    }
}
