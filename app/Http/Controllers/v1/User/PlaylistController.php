<?php

namespace App\Http\Controllers\v1\User;

use App\Http\Controllers\ApiController;
use App\Models\Playlist;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Validator;

class PlaylistController extends ApiController
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $session_id = $request->get('auth')->user->id;
        $page = !empty($request->page)?$request->page:1;
        $page_size = !empty($request->page_size)?$request->page_size:10;
        $user_id = $request->get('auth')->user->id;
        $datas = Playlist::query()->where('customer_id',$session_id)->orderBy("id","desc")->with(['contents' => function($q){
            $q->orderBy('order_no');
        }])->paginate($page_size,["*"],"page",$page);
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
        $data = Playlist::with(['contents' => function($q){
            $q->orderBy('order_no');
        }])->findOrFail($id);
        if($data->customer_id == $session_id)
            return self::success_responses($data);
        else
            return self::error_responses("This Playlist is not belonging to you");
    }

    public function store(Request $request){
        $datas = $request->all();
        $session_id = $request->get('auth')->user->id;
        $datas["customer_id"] = $session_id;

        $validator = Validator::make($datas, rules_lists(__CLASS__, __FUNCTION__));
        if($validator->fails()) return self::error_responses($validator->messages());

        $playlist = Playlist::create($datas);
        if($playlist){
            if($request->file_ids){
                $sync_data = [];
                $order_no = 1;
                foreach($request->file_ids as $file_id){
                    $sync_data[$file_id] = array('order_no'=>$order_no);
                    $order_no++;
                }
                $playlist->contents()->sync($sync_data);
            }
        }
        else
            return self::error_responses("Unknown error");

        return self::success_responses($playlist->load(['contents' => function($q){
            $q->orderBy('order_no');
        }]));
    }

    public function update(Request $request, $id){
        $datas = $request->all();
        $res = Playlist::findOrFail($id);
        $session_id = $request->get('auth')->user->id;
        $datas["customer_id"] = $session_id;

        $validator = Validator::make($datas, rules_lists(__CLASS__, __FUNCTION__));
        if($validator->fails()) return self::error_responses($validator->messages());

        $playlist = Playlist::findOrFail($id);
        if($playlist->customer_id == $session_id){
            if($request->file_ids){
                $sync_data = [];
                $order_no = 1;
                foreach($request->file_ids as $file_id){
                    $sync_data[$file_id] = array('order_no'=>$order_no);
                    $order_no++;
                }
                $playlist->contents()->sync($sync_data);
            }
        }
        else
            return self::error_responses("This Playlist is not belonging to you");

        $playlist->update($datas);
        return self::success_responses($playlist->load(['contents' => function($q){
            $q->orderBy('order_no');
        }]));
    }

    public function destroy(Request $request, $id){
        $res = Playlist::findOrFail($id);
        $session_id = request()->get('auth')->user->id;

        if($res->customer_id == $session_id){
            $res->contents()->detach();
            $res->delete();
            return self::success_responses("Success delete playlist");
        } else {
            return self::error_responses("This Playlist is not belonging to you");
        }
    }
}

