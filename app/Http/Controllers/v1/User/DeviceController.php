<?php

namespace App\Http\Controllers\v1\User;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\Models\Device;

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

        $datas = $datas->where(function($query) use($search){
            $query->where('name','like','%'.$search.'%')
                    ->orWhere('imei','like','%'.$search.'%')
                    ->orWhere('sim_card_no','like','%'.$search.'%')
                    ->orWhere('sim_card_serial','like','%'.$search.'%')
                    ->orWhere('monitor','like','%'.$search.'%');
        });

        if($request->has('active')){
            $datas = $datas->where('active',filter_var($request->active, FILTER_VALIDATE_BOOLEAN));
        }
/*
        $datas = $datas->orderBy('id', 'desc')->with('box', 'box.car', 'driver', 'kudo', 'kudo.kudoMerchant', 'kudo.kudoMerchant.kudoMerchantGroup','device_location.location')->paginate($page_size, ["devices.*"], "page", $page);
*/
        $datas = $datas->orderBy('id', 'desc')->with(['creator','location'])->paginate($page_size, ["devices.*"], "page", $page);

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

    public function update_device_location(){

    }
}
