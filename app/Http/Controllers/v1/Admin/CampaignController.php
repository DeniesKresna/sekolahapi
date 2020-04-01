<?php

namespace App\Http\Controllers\v1\Admin;

use App\Http\Controllers\ApiController;
use App\Models\Campaign;
use App\Models\Device;
use Illuminate\Http\Request;
use Notification;
use App\Notifications\CampaignConfirmation;
use Validator;
use Illuminate\Support\Facades\DB;
use App\Traits\Slotting;

class CampaignController extends ApiController
{
    use Slotting;
    public function index(Request $request)
    {
        $page = !empty($request->page)?$request->page:1;
        $page_size = !empty($request->page_size)?$request->page_size:10;
        $datas = Campaign::where('id','>',0);
        if($request->has('status')){
            $datas = $datas->where('status',$request->status);
        }
        if($request->has('trashed')){
            if(filter_var($request->trashed, FILTER_VALIDATE_BOOLEAN)){
                $datas = $datas->withTrashed();
            }
        }

        $datas = $datas->orderBy("id","desc")->with('customer', 'verificator','locations', 'contents', 'device_types')->paginate($page_size,["*"],"page",$page);

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

    public function show($id)
    {        
        if(request()->has('trashed')){
            if(filter_var(request()->trashed, FILTER_VALIDATE_BOOLEAN)){
                $data =Campaign::with("customer", "verificator","locations","contents","device_types")->withTrashed()->findOrFail($id);
            }
            else{
                $data = Campaign::with("customer", "verificator","locations","contents","device_types")->findOrFail($id);
            }
        }
        else{
            $data = Campaign::with("customer", "verificator","locations","contents","device_types")->findOrFail($id);
        }
        return self::success_responses($data);
    }

    public function update($id,Request $request){
        $res = Campaign::findOrFail($id);
        $session_id = $request->get('auth')->user->id;
        
        if($request->has('status') && $res->status==0){
            if($request->status == '1'){
                $devices = Device::whereIn('id',$device_ids)->update(['download_status' => 1]);
                $res->status = '1';
            }
            else{
                $res->status = '2';
            }
            $res->verificator_id = $session_id;
            if($res->save()){
                //Notification::send($res->customer, new CampaignConfirmation($request->status));
                return self::success_responses($res->load("customer", "verificator","locations","contents","device_types"));
            } else {
                return self::error_responses("Unknown error");
            }
        }
        else
            return self::error_responses("Need status parameter or this campaign has been verified by admin");
    }

    public function destroy($id){
        //if hard delete
        if(request()->has('hard')){
            if(filter_var(request()->hard, FILTER_VALIDATE_BOOLEAN)){
                $res = Campaign::withTrashed()->findOrFail($id);
                if($res){
                    $res->locations()->detach();
                    $media_paths = $res->contents()->pluck('file_path');
                    foreach ($media_paths as $media_path) {
                        @unlink(base_upload_dir().$media_path);
                    }
                    $res->contents()->delete();
                    $res->contents()->detach();

                    $res->device_types()->delete();

                    $res->forceDelete();
                    return self::success_responses();
                }
            }
        }
        // if soft delete
        $res = Campaign::findOrFail($id)->delete();
        return self::success_responses();
    }


    //================= 2019 phase ===============

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

        $campaigns = DB::table('campaign as c')->join('campaign_summaries as cs','cs.campaign_id','=','c.id')
                    ->where('dt','>=',$start_time)
                    ->where('dt','<=',$end_time)
                    ->selectRaw('c.*, sum(cs.total_air_time) as online, sum(cs.dst) as distance')
                    ->groupBy('cs.campaign_id')->get();
        return self::success_responses($campaigns);
    }

    public function summaryDetail($id, $campaign_id, $campaign_device){
        
    }
    //==============
}