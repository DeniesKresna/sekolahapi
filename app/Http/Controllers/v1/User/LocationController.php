<?php

namespace App\Http\Controllers\v1\User;

use App\Http\Controllers\ApiController;
use App\Models\Location;
use App\Models\AdsCampaignLocation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Validator;

class LocationController extends ApiController
{

    /**
     * Accessing Location Data.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request){
        $page = !empty($request->page)?$request->page:1;
        $page_size = !empty($request->page_size)?$request->page_size:10;
        $datas = Location::where('id','>',0);
        if($request->has('name')){
            $datas = $datas->where('name','like','%'.$request->name.'%');
        }
        $datas = $datas->orderBy("id","desc")->paginate($page_size,["*"],"page",$page);

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

    public function list(){
        $locations = Location::all();
        return self::success_responses($locations);
    }
}