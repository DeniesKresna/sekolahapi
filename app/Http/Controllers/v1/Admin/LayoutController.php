<?php

namespace App\Http\Controllers\v1\Admin;

use App\Http\Controllers\ApiController;
use App\Models\Layout;
use App\Models\LayoutBox;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class LayoutController extends ApiController
{

    /**
     * Accessing Location Data.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request){
        $page = !empty($request->page)?$request->page:1;
        $page_size = !empty($request->page_size)?$request->page_size:10;
        $datas = Layout::where('id','>',0);
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
        $layouts = Layout::all();
        return self::success_responses($layouts->load(['boxes','creator']));
    }

    public function show($id){
        $layout = Layout::findOrFail($id);
        if ($layout)
            return self::success_responses($layout->load('boxes'));
        else
            return self::error_responses("Unkown error");
    }

    public function store(Request $request){
        $datas = $request->all();
        $session_id = $request->get('auth')->user->id;
        $validator = Validator::make($datas, rules_lists(__CLASS__, __FUNCTION__));
        if($validator->fails()) return self::error_responses($validator->messages());

        $datas['creator_id'] = $session_id;

        $res = Layout::create($datas);
        if($res){
            if(!empty($datas['boxes'])){
                $unusedBoxIds = $res->boxes->pluck('id')->toArray();
                foreach($datas['boxes'] as $box){
                    $box['creator_id'] = $session_id;
                    $bx = null;
                    if(isset($box['id']))
                        $bx = LayoutBox::where('id',$box['id'])->first();
                    if($bx)
                        $bx->update($box);
                    else{
                        $bx = $res->boxes()->create($box);
                    }
                    if (($key = array_search($bx->id, $unusedBoxIds)) !== false) {
                        unset($unusedBoxIds[$key]);
                    }
                }
                LayoutBox::whereIn('id',$unusedBoxIds)->delete();
            }
            return self::success_responses($res->load('boxes','creator'));
        } else{
            return self::error_responses("Unknown Error");
        }
    }

    public function update(Request $request, $id){
        $datas = $request->all();
        $session_id = $request->get('auth')->user->id;
        $validator = Validator::make($datas, rules_lists(__CLASS__, __FUNCTION__));
        if($validator->fails()) return self::error_responses($validator->messages());

        $datas['creator_id'] = $session_id;

        $res = Layout::findOrFail($id);
        $res->update($datas);
        if($res){
            $unusedBoxIds = $res->boxes->pluck('id')->toArray();
            foreach($datas['boxes'] as $box){
                $box['creator_id'] = $session_id;
                $bx = null;
                if(isset($box['id']))
                    $bx = LayoutBox::where('id',$box['id'])->first();
                if($bx)
                    $bx->update($box);
                else{
                    $bx = $res->boxes()->create($box);
                }
                if (($key = array_search($bx->id, $unusedBoxIds)) !== false) {
                    unset($unusedBoxIds[$key]);
                }
            }
            LayoutBox::whereIn('id',$unusedBoxIds)->delete();
            return self::success_responses($res->load('boxes'));
        } else{
            return self::error_responses("Unknown error");
        }
    }

    public function destroy($id){
        $res = Layout::findOrFail($id);
        $res->boxes()->delete();
        $res->delete();
        return self::success_responses("Success delete Layout");
    }
}