<?php

namespace App\Http\Controllers\v1\User;

use App\Http\Controllers\ApiController;
use App\Models\Campaign;
use App\Models\CampaignDeviceType;
use App\Models\Content;
use App\Models\Location;
use App\Models\DeviceType;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Validator;
use App\Traits\Slotting;
use Illuminate\Support\Facades\DB;

class CampaignController extends ApiController
{
    use Slotting;

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $auth = $request->get('auth');
        $page = !empty($request->page)?$request->page:1;
        $page_size = !empty($request->page_size)?$request->page_size:10;
        $datas = Campaign::where('customer_id','=',$auth->user->id);
        if($request->has('status')){
            $datas = $datas->where('status',$request->status);
        }
        $datas = $datas->orderBy("id","desc")->with('customer', 'verificator', 'locations', 'contents', 'device_types')->paginate($page_size,["*"],"page",$page);

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
        $session_id = request()->get('auth')->user->id;
        $data = Campaign::withTrashed()->with("customer","verificator","locations","contents","device_types")->findOrFail($id);
        if($data->customer_id == $session_id)
            return self::success_responses($data);
        else
            return self::error_responses("This Campaign is not belonging to you");
        
    }

    public function store(Request $request){
        $datas = $request->all();
        $datas["status"] = "0";
        $session_id = $request->get('auth')->user->id;
        $datas["customer_id"] = $session_id;

        $validator = Validator::make($datas, rules_lists(__CLASS__, __FUNCTION__));
        if($validator->fails()) return self::error_responses($validator->messages());

        //blank option on locations and device_types
        if($request->locations){
            if(is_array($request->locations)){
                if(count($request->locations) == 0)
                    $locations = Location::where('id' ,'>' ,0)->pluck('id')->toArray();
                else
                    $locations = $request->locations;
            }
            else
                $locations = Location::where('id' ,'>' ,0)->pluck('id')->toArray();
        }
        else
            $locations = Location::where('id' ,'>' ,0)->pluck('id')->toArray();

        if($request->device_types){
            if(is_array($request->device_types)){
                if(count($request->device_types) == 0)
                    $device_types = DeviceType::where('id','>',0)->pluck('id')->toArray();
                else
                    $device_types = $request->device_types;
            }
            else
                $device_types = DeviceType::where('id','>',0)->pluck('id')->toArray();
        }
        else
            $device_types = DeviceType::where('id','>',0)->pluck('id')->toArray();

        $medias = $request->medias;
        $new_medias = Input::file('new_medias');
        
        if((count($medias) == 0) && !$new_medias){
            return self::error_responses("Need minimum 1 media");
        }
        //set medias to empty array on null medias.
        //i dont know why in postman if there is media request with null data, the laravel array
        //has one element with null data inside it. so i reset the array if first element is null.
        //i cant ignore with uncheck the request in postman coz the frontend send it.
        if(!$medias[0])
            $medias = [];

        $available_slot = $this->get_available_slot($datas['start_date'],$datas['end_date'],$datas['locations'],$datas['device_types']);

        if($available_slot >= $datas['slots']){
            $res = Campaign::create($datas);
            if ($res){
                //insert new medias
                if (!empty($new_medias))
                    $medias = to_object(array_merge(to_array($medias),to_array($this->insert_media($new_medias,$datas["customer_id"],$datas['file_name'],$datas['file_description']))));

                $res->device_types()->attach($device_types);
                $res->locations()->attach($locations);
                $res->contents()->sync($medias);

                return self::success_responses($res->load("customer","verificator","locations","contents","device_types"));
            } else {
                return self::error_responses("Unknown error");
            }
        }else{
            return self::error_responses("Some slots have been booked. Please rearrange your slot again.");
        }
    }

    public function insert_media($new_medias,$user_id,$file_name,$file_description){
        $inserted = [];
        $i = 1;
        foreach ($new_medias as $key => $new_media){           
            if (!empty($new_media)){
                $upload = upload("/screen/medias/",$new_media, $i);
                $type = file_extension($upload);
                $data['name'] = $file_name[$key];
                $data['description'] = $file_description[$key];
                $data['file_url'] = upload_dir().$upload;
                $data['file_path'] = $upload;
                $tmp = explode("/", $upload);
                $data['file_name'] = end($tmp);
                $data['type'] = file_type($type);
                $data['customer_id'] = $user_id;
                $res = Content::query()->create($data);
                array_push($inserted,$res->id);
                $i++;
            }
        }
        return $inserted;
    }

    public function update($id,Request $request){
        $datas = $request->all();
        $session_id = $request->get('auth')->user->id;

        $validator = Validator::make($datas, rules_lists(__CLASS__, __FUNCTION__));
        if($validator->fails()) return self::error_responses($validator->messages());
        
        $datas = exclude_array($datas,['name']);
        $res = Campaign::findOrFail($id);
        if($res->customer_id == $session_id){
            $res->update($datas);
            if ($res){
                return self::success_responses($res->load("customer","verificator","locations","contents","device_types"));
            } else {
                return self::error_responses("Unknown error");
            }
        }
        else
            return self::error_responses("This Campaign is not belonging to you");
    }

    public function destroy($id, Request $request){
        $session_id = $request->get('auth')->user->id;
        $res = Campaign::withTrashed()->findOrFail($id);
        if($res){
            if($res->customer_id == $session_id){
                if($res->status != 1){
                    $res->locations()->detach();

                    $media_paths = $res->contents()->pluck('file_path');
                    foreach ($media_paths as $media_path) {
                        @unlink(base_upload_dir().$media_path);
                    }
                    $res->contents()->delete();
                    $res->contents()->detach();

                    $res->device_types()->detach();

                    $this->delete_slot_by_campaign_id($res->id);
                    $res->forceDelete();
                    return self::success_responses("Success delete Campaign");
                }
                else
                    return self::error_responses("You cannot delete approved Campaign. Contact Administrator");
            }
            else
                return self::error_responses("This Campaign is not belonging to you");
        }
        else{
            return self::error_responses("Campaign Not Found");
        }
    }

    public function available_slots(Request $request){
        $data = $request->all();

        $available_slot = $this->get_available_slot($data['start_date'],$data['end_date'],$data['locations'],$data['device_types']);

        return self::success_responses($available_slot);
    }
}