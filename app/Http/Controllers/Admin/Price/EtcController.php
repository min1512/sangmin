<?php

namespace App\Http\Controllers\Admin\Price;

use App\Http\Controllers\Controller;
use App\Models\AdditionEtcPrice;
use App\Models\AdditionEtcPriceCode;
use App\Models\AdditionEtcPriceRoom;
use App\Models\AutosetDiscount;
use App\Models\AutosetDiscountHowmuch;
use App\Models\ClientTypeRoom;
use App\Models\Code;
use App\Models\UserClientFacility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EtcController extends Controller
{
    public function etc($user_id=""){
        if($user_id=="") $user_id=Auth::user()->id;
        //id값 빈 공간값(discount.blade.php 파일에서 파라메터 값을 넘겨야 해서 빈 공간으로 둠)
        //uid값 staff에서 넘겨줄 user_id값

        $additionetcprice = AdditionEtcPrice::where('user_id',$user_id)->paginate(15);
        $clientFacility = UserClientFacility::leftJoin('code','code.code','=','user_client_facility.code_facility')
            ->where('user_client_facility.user_id',$user_id)
            ->where('user_client_facility.flag_use','Y')
            ->selectRaw('user_client_facility.*, code.code_name')
            ->get();
        $clientRoom = ClientTypeRoom::where('user_id',$user_id)->get();

        return view('admin.pc.price.etc1',[
            'additionetcprice'=>$additionetcprice
            , 'list_facility'=>$clientFacility
            , 'clientRoom'=>$clientRoom
            , 'user_id'=>$user_id
        ]);
    }

    public function etc_view($data=[], $user_id="", $did="") {
        $etc=[];
        //did값은 기타이용 요금의 아이디 값임.
        $etc['curPath'] = "/info/season";
        if($user_id=="") $user_id= Auth::user()->id;
        if($did=="") $did=0;

        $etc['isset'] = AdditionEtcPrice::find($did);
        $etc['room'] = AdditionEtcPriceRoom::where('addition_etc_price_id',$did)
            ->selectRaw("group_concat(room_id separator ',') as list_room")
            ->first();

        return $etc;
    }

    public function getEtcClient(Request $request, $did=""){
        $etc = self::etc_view($request->all(),"", $did);

        return view('admin.pc.include.price.etc1_view',$etc);
    }
    public function postEtcStaff(Request $request, $user_id, $did=""){
        $etc = self::etc_view($request->all(), $user_id, $did);

        //return view('admin.pc.include.price.etc1_view',$etc);
        return response()->json($etc);
    }

    public function etc_save(Request $request, $did=""){
        //dd($request->all());
        $etc_name = $request->input('etc_name');
        $content = $request->input('content');
        $price = $request->input('price');
        $dan = $request->input('dan');
        $etc_min = $request->input('etc_min');
        $etc_max = $request->input('etc_max');
        $room_id = $request->input('room_id');
        $etc_payment_flag = $request->input('etc_payment_flag');
        $etc_reservation_flag = $request->input('etc_reservation_flag');
        $right_now_value = $request->input('right_now_value');

        $etc_flag = $request->input('etc_flag');

        $tempAdditionEtcPrice = [];
        $AdditionEtcPrice = AdditionEtcPrice::find($did);
        if(!$AdditionEtcPrice){
            $AdditionEtcPrice = new AdditionEtcPrice();
            $AdditionEtcPrice->user_id = Auth::user()->id;
        }

        if($etc_name=="Right"){
            $AdditionEtcPrice->etc_name = $right_now_value;
            $AdditionEtcPrice->code = null;
        }else{
            $AdditionEtcPrice->code = $etc_name;
            $AdditionEtcPrice->etc_name = null;
        }
        $AdditionEtcPrice->etc_content = $content;
        $AdditionEtcPrice->etc_price = $price;
        $AdditionEtcPrice->etc_dan = $dan;
        $AdditionEtcPrice->etc_min = $etc_min;
        $AdditionEtcPrice->etc_max = $etc_max;
        $AdditionEtcPrice->etc_payment_flag = $etc_payment_flag;
        $AdditionEtcPrice->etc_reservation_flag = $etc_reservation_flag;
        $AdditionEtcPrice->etc_flag = $etc_flag;
        $AdditionEtcPrice->save();
        $tempAdditionEtcPrice[] = $AdditionEtcPrice->id;

        AdditionEtcPrice::WhereNotIn('id',$tempAdditionEtcPrice)->where('user_id',Auth::user()->id)->where('id',$did)->delete();

        $tempAdditionEtcPriceRoom =[];
        foreach ($room_id as $v){
            $isset = AdditionEtcPriceRoom::where('addition_etc_price_id',$did)->where('room_id',$v)->first();
            if($isset==""){
                $AdditionEtcPriceRoom = new AdditionEtcPriceRoom();
                $AdditionEtcPriceRoom->user_id = Auth::user()->id;
            }else{
                $AdditionEtcPriceRoom=AdditionEtcPriceRoom::where('addition_etc_price_id',$did)->where('room_id',$v)->first();
            }
            $AdditionEtcPriceRoom->addition_etc_price_id =$AdditionEtcPrice->id;
            $AdditionEtcPriceRoom->room_id = $v;
            $AdditionEtcPriceRoom->save();
            $tempAdditionEtcPriceRoom[] = $AdditionEtcPriceRoom->id;
        }
        AdditionEtcPriceRoom::WhereNotIn('id',$tempAdditionEtcPriceRoom)->where('user_id',Auth::user()->id)->where('addition_etc_price_id',$did)->delete();
        return redirect()->route('info.etc');
    }

    public function Staff_etc_save(Request $request, $user_id="", $did=""){
        $did = $request->input("addition_id",$did);

        $AdditionEtcPrice = AdditionEtcPrice::find($did);
        if(!$AdditionEtcPrice){
            $AdditionEtcPrice = new AdditionEtcPrice();
            $AdditionEtcPrice->user_id = $user_id;
        }

        if($request->input('facility','')=='') {
            $AdditionEtcPrice->etc_name = $request->input('etc_name','');
            $AdditionEtcPrice->code = null;
        }
        else {
            $AdditionEtcPrice->code = $request->input('facility','');
            $AdditionEtcPrice->etc_name = null;
        }
        $AdditionEtcPrice->etc_content = $request->input('etc_content',null);
        $AdditionEtcPrice->etc_price = $request->input('etc_price');
        $AdditionEtcPrice->etc_dan = $request->input('etc_dan');
        $AdditionEtcPrice->etc_min = $request->input('etc_min');
        $AdditionEtcPrice->etc_max = $request->input('etc_max');
        $AdditionEtcPrice->etc_payment_flag = $request->input('etc_payment_flag','Y');
        $AdditionEtcPrice->etc_reservation_flag = $request->input('etc_reservation_flag','Y');
        $AdditionEtcPrice->etc_flag = $request->input('etc_flag','Y');
        $AdditionEtcPrice->save();

//        $tempAdditionEtcPrice[] = $AdditionEtcPrice->id;
//        AdditionEtcPrice::WhereNotIn('id',$tempAdditionEtcPrice)->where('user_id',$user_id)->where('id',$did)->delete();

        $tempAdditionEtcPriceRoom =[];
        foreach ($request->input("client_room") as $v){
            $AdditionEtcPriceRoom = AdditionEtcPriceRoom::where('addition_etc_price_id',$did)->where('room_id',$v)->first();
            if(!isset($AdditionEtcPriceRoom)){
                $AdditionEtcPriceRoom = new AdditionEtcPriceRoom();
                $AdditionEtcPriceRoom->user_id = $user_id;
            }
            $AdditionEtcPriceRoom->addition_etc_price_id =$AdditionEtcPrice->id;
            $AdditionEtcPriceRoom->room_id = $v;
            $AdditionEtcPriceRoom->save();
            $tempAdditionEtcPriceRoom[] = $AdditionEtcPriceRoom->id;
        }

        AdditionEtcPriceRoom::WhereNotIn('id',$tempAdditionEtcPriceRoom)->where('user_id',$user_id)->where('addition_etc_price_id',$did)->delete();

        return redirect()->route('price.facility',['user_id'=>$user_id]);
    }
}
