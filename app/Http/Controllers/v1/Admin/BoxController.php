<?php

namespace App\Http\Controllers\v1\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\Models\Box;
use Illuminate\Support\Facades\DB;
use Validator;

class BoxController extends ApiController
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request) {
        $page = !empty($request->page)?$request->page:1;
        $page_size = !empty($request->page_size)?$request->page_size:10;
        $search = $request->search;
        
        $datas = Box::where('id','>',0);

        if($request->has('trashed')){
            if(filter_var(request()->trashed, FILTER_VALIDATE_BOOLEAN)){
                $datas = $datas->withTrashed();
            }
        }

        $datas = $datas->where(function($query) use($search){
            $query->where('name','like','%'.$search.'%');
        });

        if($request->has('active')){
            $datas = $datas->where('active',filter_var($request->active, FILTER_VALIDATE_BOOLEAN));
        }
/*
        $datas = $datas->orderBy('id', 'desc')->with('box', 'box.car', 'driver', 'kudo', 'kudo.kudoMerchant', 'kudo.kudoMerchant.kudoMerchantGroup','device_location.location')->paginate($page_size, ["devices.*"], "page", $page);
*/
        $datas = $datas->orderBy('id', 'desc')->with(['car'])->paginate($page_size, ["*"], "page", $page);

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
        $datas = Box::query()->where('id','>',0);
        if ($request->search) $datas = $datas->where('name','like','%'.$search.'%');
        $datas = $datas->orderBy('id', 'desc')->get();
        return self::success_responses($datas);
    }

    public function store(Request $request){
        $datas = $request->all();
        $session_id = $request->get('auth')->user->id;

        $validator = Validator::make($datas, rules_lists(__CLASS__, __FUNCTION__));
        if($validator->fails()) return self::error_responses($validator->messages());

        $datas['creator_id'] = $session_id;

        $result = Box::create($datas);
        if($result)
            return self::success_responses($result->load(['car']));
        else
            return self::error_responses("Unknown Error");
    }

    public function update(Request $request, $id){
        $datas = $request->all();
        $session_id = $request->get('auth')->user->id;
        
        $validator = Validator::make($datas, rules_lists(__CLASS__, __FUNCTION__));
        if($validator->fails()) return self::error_responses($validator->messages());

        $result = Box::findOrFail($id);
        $result->update($datas);
        if($result)
            return self::success_responses($result->load(['car']));
        else
            return self::error_responses("Unknown Error");
    }

    public function destroy($id){
        $res = Box::findOrFail($id);
        if($request->has('hard')){
            if(filter_var(request()->hard, FILTER_VALIDATE_BOOLEAN)){
                $res->slots()->detach();
                $res->forceDelete();
                return self::success_responses("Success Delete Box");
            }
        }
        $res->delete();
        return self::success_responses("Success Delete Box");
    }

}
