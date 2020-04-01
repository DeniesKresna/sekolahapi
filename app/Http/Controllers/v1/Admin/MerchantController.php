<?php

namespace App\Http\Controllers\v1\Admin;

use App\Http\Controllers\ApiController;
use App\Models\Merchant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class MerchantController extends ApiController
{

    /**
     * Accessing Location Data.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request){
        $page = !empty($request->page)?$request->page:1;
        $page_size = !empty($request->page_size)?$request->page_size:10;
        $datas = Merchant::where('id','>',0);
        if($request->has('name')){
            $datas = $datas->where('name','like','%'.$request->name.'%');
        }
        $datas = $datas->orderBy("id","desc")->with('boxes', 'creator')->paginate($page_size,["*"],"page",$page);

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
        $layouts = Merchant::all();
        return self::success_responses($layouts->load('devices','creator'));
    }

    public function show($id){
        $layout = Merchant::findOrFail($id);
        if ($layout)
            return self::success_responses($layout);
        else
            return self::error_responses("Unkown error");
    }

    public function store(Request $request){
        $datas = $request->all();
        $session_id = $request->get('auth')->user->id;
        $validator = Validator::make($datas, rules_lists(__CLASS__, __FUNCTION__));
        if($validator->fails()) return self::error_responses($validator->messages());

        $datas['creator_id'] = $session_id;

        $res = Merchant::create($datas);
        if($res)
            return self::success_responses($res->load('devices','creator'));
        else
            return self::error_responses("Unknown Error");
    }

    public function update(Request $request, $id){
        $datas = $request->all();
        $session_id = $request->get('auth')->user->id;
        $validator = Validator::make($datas, rules_lists(__CLASS__, __FUNCTION__));
        if($validator->fails()) return self::error_responses($validator->messages());

        $datas['creator_id'] = $session_id;

        $res = Merchant::findOrFail($id);
        $res->update($datas);
        if($res){
            return self::success_responses($res->load('devices','creator'));
        } else{
            return self::error_responses("Unknown error");
        }
    }
}