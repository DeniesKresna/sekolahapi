<?php

namespace App\Http\Controllers\v1\Device;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CampaignController extends ApiController
{
    public function generate(Request $request){
        if($request->has('mode')){
            if($request->mode=="hourly"){
                $this->generate_hourly();
            }else{
                $this->generate_all();
            }
        }
        else{
            $this->generate_all();
        }
        return response()->json(['status'=>'ok']);
    }

    private function generate_all(){
        $campaign_impressions = DB::table('slot_impressions')
                                ->where('calculated_status',0)
                                ->groupBy('campaign_id')
                                ->select(DB::raw('*,COUNT(id) as slot_played'))
                                ->get();
        foreach ($campaign_impressions as $campaign_impression) {
            $res = DB::table('campaign_summaries')->insert([
                'campaign_id'=>$campaign_impression->campaign_id,
                'slot_played'=>$campaign_impression->slot_played,
                'created_at'=>date("Y-m-d H:i:s"),
                'updated_at'=>date("Y-m-d H:i:s"),
            ]);
            if($res){
                $res2 = DB::table('slot_impressions')
                                ->where('calculated_status',0)
                                ->where('campaign_id',$campaign_impression->campaign_id)
                                ->update([
                                    'calculated_status'=>1,
                                    'updated_at'=>date('Y-m-d H:i:s')
                                ]);
            }
        }
    }

    private function generate_hourly(){
        return response()->json(['message'=>'no action yet']);
    }
}
