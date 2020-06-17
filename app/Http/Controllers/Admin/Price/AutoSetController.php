<?php

namespace App\Http\Controllers\Admin\Price;

use App\Http\Controllers\Controller;
use App\Models\AutosetDiscount;
use App\Models\AutosetDiscountHowmuch;
use App\Models\AutosetDiscountRoom;
use App\Models\ClientDiscount;
use App\Models\ClientTypeRoom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Jenssegers\Agent\Agent;

class AutoSetController extends Controller
{
    protected $data = [];
    protected $phone = true;

    public function __construct() {
        $agent = new Agent();
        $this->phone = $agent->isPhone()?"mobile":"pc";

        $this->data['code'] = 200;
        $this->data['message'] = 'Success';
    }

    public function discount($user_id=""){
        if($user_id==""){
            $user_id = Auth::user()->id;
            $client = 'client';
        }
        //id값 빈 공간값(discount.blade.php 파일에서 파라메터 값을 넘겨야 해서 빈 공간으로 둠)
        //uid값 staff에서 넘겨줄 user_id값
//        $uid = Auth::user()->id;
        $discountList = AutosetDiscount::where('user_id',$user_id)
            ->selectraw('
                autoset_discount.*
                    , ifnull((select group_concat(room_id separator ",") from autoset_discount_room where autoset_id=autoset_discount.id),null) as room_id
                ')
            ->get();
        $Client_type_room = AutosetDiscountRoom::where('user_id',$user_id)
            ->selectraw('
                autoset_discount_room.*
                ,ifnull((select group_concat(room_name separator ",") from client_type_room where id=autoset_discount_room.room_id),null) as room_name
            ')
            ->get();

        return view('admin.pc.price.autodiscount',[
            'client'=> isset($client)?$client:""
            ,'user_id'=>$user_id
            , 'discountList' => $discountList
            , 'Client_type_room'=>$Client_type_room
        ]);
    }

    public function getDiscountClient(Request $request, $did=""){
        $auto_discount = self::discount_view($request->all(),"", $did);

        return view('admin.pc.price.autodiscount_insert',$auto_discount);
    }
    public function getDiscountStaff(Request $request, $user_id, $did=""){
        $auto_discount = self::discount_view($request->all(), $user_id, $did);

        return view('admin.pc.price.autodiscount_insert',$auto_discount);
    }

    public function discount_view($data=[], $user_id="", $did="" ){

        $auto_discount = [];
        if($user_id==""){
            $user_id= Auth::user()->id;
        }

        if($did==""){
            $did=0;
        }
        //did값은 자동 할인 시즌의 아이디 값임.
        $auto_discount['did'] = $did;
        $auto_discount['curPath'] = "/info/season";


        $auto_discount['Autoset_Discount_Howmuch'] = AutosetDiscountHowmuch::where('user_id',$user_id)->where('autoset_id',$did)->orderby('date')->get();
        $auto_discount['Autoset_Discount'] = AutosetDiscount::where('user_id',$user_id)->where('id',$did)->first();
        $auto_discount['ClientTypeRoom'] = ClientTypeRoom::where('client_type_room.user_id',$user_id)
            ->selectraw('
                client_type_room.*
                , (select room_id from autoset_discount_room where room_id=client_type_room.id and autoset_id='.$did.') as room_id
                , (select room_id from autoset_discount_room where room_id=client_type_room.id and autoset_id='.$did.') as room_id
                ')
            ->get();
        $auto_discount['isset'] = AutosetDiscount::find($did);

        return $auto_discount;
    }

    public function discount_save(Request $request, $did=""){
        $term_check = $request->input('term_check');
        $autoset_check = $request->input('autoset_check');
        $isset = AutosetDiscount::find($did);

        if(isset($isset)){
            $AutosetDiscount = AutosetDiscount::find($did);
        }else{
            $AutosetDiscount = new AutosetDiscount();
            $AutosetDiscount->user_id = Auth::user()->id;
        }
        $AutosetDiscount->term_check = $term_check;
        if($term_check=="Y"){
            $AutosetDiscount->discount_start = $request->input('start_date');
            $AutosetDiscount->discount_end = $request->input('end_date');
        }else if($term_check=="N"){
            $AutosetDiscount->discount_start = null;
            $AutosetDiscount->discount_end = null;
        }
        $AutosetDiscount->autoset_check = $autoset_check;
        $AutosetDiscount->day = implode(",",$request->input('day'));
        $AutosetDiscount->save();

        $tmpDeleteAutosetDiscountHowMuch = [];
        foreach ($request->input('discount_howmuch') as $k=>$v){
            $isset = AutosetDiscountHowmuch::find($did);
            if(isset($isset)){
                $AutosetDiscountHowmuch = AutosetDiscountHowmuch::find($did);
            }else{
                $AutosetDiscountHowmuch = new AutosetDiscountHowmuch();
                $AutosetDiscountHowmuch->user_id = Auth::user()->id;
                $AutosetDiscountHowmuch->autoset_id = $AutosetDiscount->id;
            }
            $AutosetDiscountHowmuch->autoset_discount_howmuch =$v;
            $AutosetDiscountHowmuch->date =$k;
            $AutosetDiscountHowmuch->save();
            $tmpDeleteAutosetDiscountHowMuch[] = $AutosetDiscountHowmuch->id;
        }
        AutosetDiscountHowmuch::WhereNotIn('id',$tmpDeleteAutosetDiscountHowMuch)->where('user_id',Auth::user()->id)->where('autoset_id',$did)->delete();

        $tmpDeleteAutosetRoomId= [];
        foreach ($request->input('room_id') as $k=>$v){
            $isset = AutosetDiscountRoom::find($did);
            if(isset($isset)){
                $AutosetDiscountRoom = AutosetDiscountRoom::find($did);
            }else{
                $AutosetDiscountRoom = new AutosetDiscountRoom();
                $AutosetDiscountRoom->user_id = Auth::user()->id;
                $AutosetDiscountRoom->autoset_id = $AutosetDiscount->id;
            }
            $AutosetDiscountRoom->room_id = $v;
            $AutosetDiscountRoom->save();
            $tmpDeleteAutosetRoomId[] = $AutosetDiscountRoom->id;
        }
        AutosetDiscountRoom::WhereNotIn('id',$tmpDeleteAutosetRoomId)->where('user_id',Auth::user()->id)->where('autoset_id',$did)->delete();
        return redirect()->route('info.autoset');
    }

    public function staff_discount_save(Request $request, $user_id="", $did=""){

        $term_check = $request->input('term_check');
        $autoset_check = $request->input('autoset_check');
        $isset = AutosetDiscount::find($did);

        if(isset($isset)){
            $AutosetDiscount = AutosetDiscount::find($did);
        }else{
            $AutosetDiscount = new AutosetDiscount();
            $AutosetDiscount->user_id = $user_id;
        }
        $AutosetDiscount->term_check = $term_check;
        if($term_check=="Y"){
            $AutosetDiscount->discount_start = $request->input('start_date');
            $AutosetDiscount->discount_end = $request->input('end_date');
        }else if($term_check=="N"){
            $AutosetDiscount->discount_start = null;
            $AutosetDiscount->discount_end = null;
        }
        $AutosetDiscount->autoset_check = $autoset_check;
        $AutosetDiscount->day = implode(",",$request->input('day'));
        $AutosetDiscount->save();

        $tmpDeleteAutosetDiscountHowMuch = [];
        foreach ($request->input('discount_howmuch') as $k=>$v){
            $isset = AutosetDiscountHowmuch::where('autoset_id',$did)->where('user_id',$user_id)->where('date',$k)->where('autoset_discount_howmuch',$v)->first();
            $autoset_discount_howmuch_id = AutosetDiscountHowmuch::where('autoset_id',$did)->where('user_id',$user_id)->where('date',$k)->where('autoset_discount_howmuch',$v)->value('id');
            if(isset($isset)){
                $AutosetDiscountHowmuch = AutosetDiscountHowmuch::find($autoset_discount_howmuch_id);
            }else{
                $AutosetDiscountHowmuch = new AutosetDiscountHowmuch();
                $AutosetDiscountHowmuch->user_id = $user_id;
                $AutosetDiscountHowmuch->autoset_id = isset($did) && $did != "" ?$did:$AutosetDiscount->id;
            }
            $AutosetDiscountHowmuch->autoset_discount_howmuch =$v;
            $AutosetDiscountHowmuch->date =$k;
            $AutosetDiscountHowmuch->save();
            $tmpDeleteAutosetDiscountHowMuch[] = $AutosetDiscountHowmuch->id;
        }
        AutosetDiscountHowmuch::WhereNotIn('id',$tmpDeleteAutosetDiscountHowMuch)->where('user_id',$user_id)->where('autoset_id',isset($did) && $did != "" ?$did:$AutosetDiscount->id)->delete();

        $tmpDeleteAutosetRoomId= [];
        foreach ($request->input('room_id') as $k=>$v){
            $isset = AutosetDiscountRoom::where('autoset_id',$did)->where('user_id',$user_id)->where('room_id',$v)->first();
            $AutosetDiscountRoom_id = AutosetDiscountRoom::where('autoset_id',$did)->where('user_id',$user_id)->where('room_id',$v)->value('id');
            if(isset($isset)){
                $AutosetDiscountRoom = AutosetDiscountRoom::find($AutosetDiscountRoom_id);
            }else{
                $AutosetDiscountRoom = new AutosetDiscountRoom();
                $AutosetDiscountRoom->user_id = $user_id;
                $AutosetDiscountRoom->autoset_id = isset($did) && $did != "" ?$did:$AutosetDiscount->id;
            }
            $AutosetDiscountRoom->room_id = $v;
            $AutosetDiscountRoom->save();
            $tmpDeleteAutosetRoomId[] = $AutosetDiscountRoom->id;
        }
        AutosetDiscountRoom::WhereNotIn('id',$tmpDeleteAutosetRoomId)->where('user_id',$user_id)->where('autoset_id',isset($did) && $did != "" ?$did:$AutosetDiscount->id)->delete();

        return redirect()->route('price.autoset',['user_id'=>$user_id]);
    }
}
