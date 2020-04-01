<?php

namespace App\Http\Controllers\v1\Device;

use App\Http\Controllers\ApiController;
use App\Models\DeviceSchedule;
use App\Models\Device;
use App\Models\LayoutBox;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;

class LayoutController extends ApiController
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function list(Request $request)
    {
        if($request->has('imei')){
            $imei = $request->imei;
            $next_hour_start = date("Y-m-d H:00:00");
            $next_hour_end = date("Y-m-d H:00:00", strtotime($next_hour_start. " +1 hour"));
            $device_schedule = DeviceSchedule::where('imei',$imei)
                ->where('created_at','>',$next_hour_start)->orderBy('created_at')->value('data');
            if($device_schedule){
                $dt = json_decode($device_schedule);
                return response()->json($dt);
            }else{
                $max_slot = 240;
                //============get filler===================
                $slotting_layout_boxes = LayoutBox::where('enable_slotting',1)->with('sequences','layout.device_lines')->get();
                //=========================================
                $device = DB::table('devices as d')->join('device_lines as dl','dl.device_id','=','d.id')
                        ->join('layouts as l','l.id','=','dl.layout_id')
                        ->join('layout_boxes as lb','lb.layout_id','=','l.id')
                        ->where('lb.enable_slotting','>',0)
                        ->where('d.imei', $request->imei)
                        ->select("*","lb.id as lb_id","l.name as l_name","l.type as l_type","l.timeout as l_timeout")->first();
                if(!$device){
                    return response()->json(["message"=>"no device"], 401);
                }

                $device->layout_boxes = Device::find($device->device_id)->device_line->layout->boxes;
                $enable_slot_layout_box = LayoutBox::find($device->lb_id);
                $filler_content = $enable_slot_layout_box->sequences;

                //looking for layout which has layout box with enable slotting on
                /*
                if(!$device->layout_boxes){
                    $layout = DB::table('layout as l')->join('layout_boxes as lb','lb.layout_id','=','l.id')->where('lb.enable_slotting',1)->first();
                    if($layout)
                        $device->layout_boxes = DB::table('layout_boxes')->where('layout_id',$layout->id)->get();
                    else {
                        return response()->json(['message'=>"no layout with enable sloting on"]);
                    }
                }*/

                //put filler content
                //$filler_content = null;
                /*
                foreach ($slotting_layout_boxes as $slotting_layout_box) {
                    $slotting_device_lines = $slotting_layout_box->layout->device_lines;
                    foreach ($slotting_device_lines as $slotting_device_line) {
                        if($slotting_device_line->device_id == $device->device_id){
                            $device->lb_id = $slotting_layout_box->id;
                            $filler_content = $slotting_layout_box->sequences;
                            break;
                        }
                    }
                    if($filler_content) break;
                }*/

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
                                $device->slot[$i] = "no data or filler";
                            }
                        }
                    }
                }else{
                    for($i=0; $i<$max_slot; $i++) {
                        if(!isset($device->slot[$i])){
                            $device->slot[$i] = "no data or filler";
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

                DB::table('device_schedules')->where('imei',$device->imei)->where('created_at','<',DB::raw('NOW() - INTERVAL 2 HOUR'))->delete();
                $res = DB::table('device_schedules')->insert($datas);
                if($res){
                    $device_schedule = DeviceSchedule::where('imei',$imei)
                        ->where('created_at','>',$next_hour_start)->orderBy('created_at')->value('data');
                    if($device_schedule){
                        $dt = json_decode($device_schedule);
                        return response()->json($dt);
                    }
                    else{
                        return self::error_responses("Unknown error");
                    }
                }else{
                    return self::error_responses("Unknown error");
                }
            }
        }
        return response()->json(['message'=>"need Imei as parameter"]);
    }
}