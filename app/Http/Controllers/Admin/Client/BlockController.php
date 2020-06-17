<?php

namespace App\Http\Controllers\Admin\Client;

use App\Http\Controllers\Controller;
use App\Models\BlockTable;
use App\Models\ClientSeason;
use App\Models\ClientSeasonTerm;
use App\Models\ClientTypeRoom;
use App\Models\ClientTypeRoomPrice;
use App\Models\ClientTypeRoomPriceCustom;
use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;

class BlockController extends Controller
{
    protected $data = [];
    protected $phone = true;

    public function __construct() {
        $agent = new Agent();
        $this->phone = $agent->isPhone()?"mobile":"pc";

        $this->data['code'] = 200;
        $this->data['message'] = 'Success';
    }

    public function getBlock(Request $request){
        $this->data['year']     = $request->query("year",date("Y"));
        $this->data['month']    = $request->query("month",date("n"));
        $this->data['day']      = $request->query("day",date("j"));
        $this->data['id'] =$request->id;
        $this->data['room']     = ClientTypeRoom::where('user_id',$this->data['id'])->orderby('type_id','asc')->orderby('room_name','asc')->get();
        $this->data['season']   = ClientSeason::wherein('user_id',[0,$this->data['id']])->where('flag_use','Y')->orderby('id','asc')->get();

        //일자별 요금 호출 (시즌)
        $tmp_basic_date = strtotime($this->data['year']."-".$this->data['month']."-".$this->data['day']);
        for($i=1; $i<=date("t",$tmp_basic_date); $i++){
            $tmp_date = date("Y-m-".$i,$tmp_basic_date);
            $tmp_union = ClientSeasonTerm::where('user_id',0);
            $tmp_season = ClientSeasonTerm::where('user_id',$this->data['id'])
                ->where('season_start','<=',date("Y-m-d",strtotime($tmp_date)))
                ->where('season_end','>=',date("Y-m-t",strtotime($tmp_date)))
                ->unionAll($tmp_union)
                ->get();
            foreach($this->data['room'] as $r) {
                foreach ($tmp_season as $ts) {
                    $price = ClientTypeRoomPrice::where(['user_id'=>$this->data['id'], 'season_id'=>$ts->season_id, 'room_id'=>$r->id])->select('price_day_'.date('w',strtotime($tmp_date)))->first();
                    $this->data['price_day'][$i][$r->id][date('w',strtotime($tmp_date))][$ts->season_id] = isset($price)?$price->{'price_day_'.date('w',strtotime($tmp_date))}:0;
                }
                $this->data['price_custom'][$i][$r->id] = ClientTypeRoomPriceCustom::where(['user_id'=>$this->data['id'], 'room_id'=>$r->id, 'custom_date'=>date("Y-m-d",strtotime($tmp_date))])->first();
            }

        }

        return view('admin.'.$this->phone.'.client.client_block', $this->data);
    }

    public function postBlock(Request $request){

        $user_id = $request->id;
        $custom_price_season = $request->custom_price_season;
        $block = $request->block;
        $Tel = $request->Tel;
        $None = $request->none;
        $block_tel_start = $request->block_tel_start;
        $block_tel_end = $request->block_tel_end;
        $no_block_tel = $request->no_block_tel;

        $tmp = [];
        $tmp1 = [];
        if($block_tel_start == "") {
            foreach ($custom_price_season as $k => $v) {
                foreach ($v as $k2 => $v2) {
                    $isset = BlockTable::where('day', $k)->where('room_id', $k2)->first();
                    if (isset($isset)) {
                        $BlockTable = BlockTable::where('day', $k)->where('room_id', $k2)->first();
                    } else {
                        $BlockTable = new BlockTable();
                        $BlockTable->user_id = $user_id;
                        $BlockTable->room_id = $k2;
                        $type_id = ClientTypeRoom::where('user_id', $BlockTable->user_id)->where('id', $BlockTable->room_id)->value('type_id');
                        $BlockTable->type_id = $type_id;
                        $BlockTable->day = $k;
                    }
                    if ($block == "B") {
                        $BlockTable->flag = $block;
                    } elseif ($Tel == "T") {
                        $BlockTable->flag = $Tel;
                    } elseif ($None == "N") {
                        $BlockTable->flag = $None;
                        $tmp[] = $BlockTable->id;
                    }
                    $BlockTable->save();
                }
            }
            BlockTable::WhereIn('id', $tmp)->where('user_id', $user_id)->delete();
            BlockTable::where('flag', "N")->delete();
        }else{
            foreach ($custom_price_season as $k =>$v){
                for($i=strtotime($block_tel_start); $i<=strtotime($block_tel_end); $i+=86400){
                    if(!in_array(date("Y-m-d",$i),$no_block_tel)) {
                        $isset = BlockTable::where('day', date("Y-m-d",$i))->where('room_id', $k)->where('user_id',$user_id)->first();
                        if (isset($isset)) {
                            $BlockTable = BlockTable::where('day', date("Y-m-d",$i))->where('room_id', $k)->where('user_id',$user_id)->first();
                        } else {
                            $BlockTable = new BlockTable();
                            $BlockTable->user_id = $user_id;
                            $BlockTable->room_id = $k;
                            $type_id = ClientTypeRoom::where('user_id', $BlockTable->user_id)->where('id', $BlockTable->room_id)->value('type_id');
                            $BlockTable->type_id = $type_id;
                            $BlockTable->day = date("Y-m-d",$i);
                        }
                        if ($block == "B") {
                            $BlockTable->flag = $block;
                        } elseif ($Tel == "T") {
                            $BlockTable->flag = $Tel;
                        } elseif ($None == "N") {
                            $BlockTable->flag = $None;
                            $tmp1[] = $BlockTable->id;
                        }
                        $BlockTable->save();
                    }
                }
            }

            BlockTable::WhereIn('id', $tmp1)->where('user_id', $user_id)->delete();
            BlockTable::where('flag', "N")->delete();
        }
        return redirect()->route('client.block',[$user_id]);
    }
}
