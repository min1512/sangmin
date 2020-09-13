@extends("admin.pc.layout.basic")

@section("title")
@endsection

@section("scripts")
<script>
    $(document).ready(function(){
        //로딩후 disabled로 변경
        $(".inner-table.type-disable").find("input,textarea,select").attr("disabled","true");

        $(".js-tr-btn").click(function(){//상세버튼
            var next = $(this).closest("tr").next();

            if($(next).css("display") == "none"){
                $(next).toggle();
            }else{
                var who1 = $(next).find(".inner-table");
                $(who1).addClass("type-disable");
                trig_dis(who1);
                $(next).toggle();
            }
        });
        $(".inner-table__edit").click(function(){//변경버튼
            var who2 = $(this).closest(".inner-table");
            $(who2).removeClass("type-disable");
            trig_dis(who2);
        });

        $(".js-edit-cancel").click(function(){//변경취소버튼
             var who3 = $(this).closest(".inner-table");
            $(who3).addClass("type-disable");
            trig_dis(who3);
        });
    });

    function trig_dis(who){//안의 인풋들 disabled제어 함수
        if($(who).hasClass("type-disable")){
            $(who).find("input,textarea,select").attr("disabled",true);
        }else{
            $(who).closest(".inner-table").find("input.js-chg,textarea.js-chg,select.js-chg").attr("disabled",false);
        }
    }

    function chgPrice(oid, iid) {
        /** oid : 주문번호 */
        var price_total = 0;
        var price_discount = 0;
        var price_reserve = 0;
        var price_scene = 0;
        $("input[id^='room_info_"+oid+"_']").each(function(){
            var tmp = $(this).attr("id").split(/_/);
            $(this).data("price"); //객실예약금액
            var cntDay = dateDiff($("#reserve_date_end_"+tmp[2]+"_"+tmp[3]).val(),$("#reserve_date_start_"+tmp[2]+"_"+tmp[3]).val());
            cntDay++; //객실 숙박 일수

            //객실가격
            var add_price_room = 0;
            add_price_room += parseInt($("#room_price_"+tmp[2]+"_"+tmp[3]).val().replace(/,/gi,""));

            //인원추가비용
            var add_price_person = 0;
            var tmp_price_adult = parseInt($("#cnt_adult_"+tmp[2]+"_"+tmp[3]).val().replace(/,/gi,"")) * parseInt($("#cnt_adult_"+tmp[2]+"_"+tmp[3]).data('price_adult'));
            var tmp_price_child = parseInt($("#cnt_child_"+tmp[2]+"_"+tmp[3]).val().replace(/,/gi,"")) * parseInt($("#cnt_child_"+tmp[2]+"_"+tmp[3]).data('price_child'));
            var tmp_price_baby = parseInt($("#cnt_baby_"+tmp[2]+"_"+tmp[3]).val().replace(/,/gi,"")) * parseInt($("#cnt_baby_"+tmp[2]+"_"+tmp[3]).data('price_baby'));
            $("#price_adult_"+tmp[2]+"_"+tmp[3]).val(tmp_price_adult.format());
            $("#price_child_"+tmp[2]+"_"+tmp[3]).val(tmp_price_child.format());
            $("#price_baby_"+tmp[2]+"_"+tmp[3]).val(tmp_price_baby.format());
            add_price_person = parseInt(add_price_person) + parseInt(tmp_price_adult) * cntDay;
            add_price_person = parseInt(add_price_person) + parseInt(tmp_price_child) * cntDay;
            add_price_person = parseInt(add_price_person) + parseInt(tmp_price_baby) * cntDay;

            //부가서비스비용
            var add_price_facility = 0;
            var add_price_facility_scene = 0;
            $("input[type=checkbox][id^='list_facility_"+tmp[2]+"_"+tmp[3]+"_']").each(function(){
                if($(this).prop("checked")) {
                    if($(this).data("etc_payment_flag")=="Y") add_price_facility += $(this).data("price")&&$(this).data("price")!=""?parseInt($(this).data("price")) * cntDay:0;
                    else add_price_facility_scene += $(this).data("price")&&$(this).data("price")!=""?parseInt($(this).data("price")) * cntDay:0;
                }
            });
            $("input[type=checkbox][id^='list_facility2_"+tmp[2]+"_"+tmp[3]+"_']").each(function(){
                if($(this).prop("checked")) {
                    if($(this).data("etc_payment_flag")=="Y") add_price_facility += $(this).data("price")&&$(this).data("price")!=""?parseInt($(this).data("price")) * cntDay:0;
                    else add_price_facility_scene += $(this).data("price")&&$(this).data("price")!=""?parseInt($(this).data("price")) * cntDay:0;
                }
            });

            price_reserve = parseInt(price_reserve) + parseInt(add_price_room);
            price_reserve = parseInt(price_reserve) + parseInt(add_price_person);
            price_reserve = parseInt(price_reserve) + parseInt(add_price_facility);
            price_reserve = parseInt(price_reserve) + parseInt(add_price_facility_scene);

            console.log("room: "+add_price_room);
            console.log("person: "+add_price_person);
            console.log("facility: "+add_price_facility);
            console.log("room_person_facility: "+price_reserve);
            console.log("scene: "+parseInt(add_price_facility_scene));

            price_total = parseInt(price_total) + parseInt(price_reserve);
            price_total = parseInt(price_total) + parseInt(price_scene);
            price_scene = parseInt(price_scene) + parseInt(add_price_facility_scene);
        });
        $("#reserve_total_"+oid).val(price_total.format());
        $("#reserve_scene_"+oid).val(price_scene.format());
    }
</script>
@endsection

@section("styles")
@endsection

@section("contents")
	@include("admin.pc.include.order.search",['search'=>isset($search)?$search:[]])

    <div class="list_blade">
        <div class="table-a noto">
            <div class="table-a__head clb">
                <p class="table-a__tit fl">예약목록</p>
            </div>
            <table class="table-a__table">
                <colgroup>
                    <col width="">
                    <col width="">
                    <col width="">
                    <col width="">
                    <col width="">
                    <col width="">
                    <col width="">
                    <col width="">
                    <col width="6%">
                </colgroup>
                <tr class="table-a__tr type-th">
                    <th class="table-a__th">번호</th>
                    <th class="table-a__th">펜션명</th>
                    <th class="table-a__th">주문자</th>
                    <th class="table-a__th">예약자</th>
                    <th class="table-a__th">연락처</th>
                    <th class="table-a__th">예약일(박)</th>
                    <th class="table-a__th">예약인원</th>
                    <th class="table-a__th">상태</th>
                    <th class="table-a__th">관리</th>
                </tr>
                @foreach($order as $k => $o)
                    <tr class="table-a__tr">
                        <td class="table-a__td">
                            <div class="table-a__inbox">
                                <span>{{ $order->total()-($order->currentPage()-1)*$order->perPage()-$k }}</span>
                            </div>
                        </td>
                        <td class="table-a__td">
                            <div class="table-a__inbox">
                                <span class="ellipsis dp-ib" style="width:100%">{{$o->client_name}}</span>
                            </div>
                        </td>
                        <td class="table-a__td type-td-point">
                            <div class="table-a__inbox">
                                <span class="type-point type-line">{{ $o->order_name }}</span>
                            </div>
                        </td>
                        <td class="table-a__td">
                            <div class="table-a__inbox">
                                <span>{{ $o->reserve_name }}</span>
                            </div>
                        </td>
                        <td class="table-a__td">
                            <div class="table-a__inbox">
                                <span>{{ $o->reserve_hp }}</span>
                            </div>
                        </td>
                        <td class="table-a__td">
                            <div class="table-a__inbox">
                                <span>{{$o->checkin_date}} ({{$o->cnt_over}}박)</span>
                            </div>
                        </td>
                        <td class="table-a__td">
                            <div class="table-a__inbox" style="max-width:300px">
                                <span class="ellipsis dp-ib" style="width:100%">{{$o->cnt_adult+$o->cnt_child+$o->cnt_baby}}</span>
                            </div>
                        </td>
                        <td class="table-a__td">
                            <div class="table-a__inbox">
                                <span class="ellipsis dp-ib" style="width:100%">{{$state[$o->state]}}</span>
                            </div>
                        </td>
                        <td class="table-a__td">
                            <div class="table-a__inbox">
                                <button type="button" class="table-a__btn type-info btn-v2 js-tr-btn"
                                        data-id="{{$o->id}}">상세
                                </button>
                            </div>
                        </td>
                    </tr>
                    <tr class="table-a__tr type-grey type-more">
                        <td colspan="9" class="">
                            <div class="inner-table type-disable">
                                <form method="post" name="frmOrderDetail_{{$o->id}}" action="{{route('order.save',['id'=>$o->id])}}">
                                    {{csrf_field()}}
                                    <input type="hidden" name="order_id" value="{{$o->id}}" />
                                    <table class="inner-table__table">
                                        <colgroup>
                                            <col width="90" />
                                            <col width="*" />
                                            <col width="90" />
                                            <col width="*" />
                                            <col width="90" />
                                            <col width="*" />
                                            <col width="90" />
                                            <col width="*" />
                                        </colgroup>
                                        <tr class="inner-table__tr">
                                            <th class="inner-table__th">펜션명</th>
                                            <td class="inner-table__td"><input type="text" name="client_name[{{$o->id}}]" id="client_name_{{$o->id}}" class="input-v1" value="{{$o->client_name}}" placeholder="펜션명" /></td>
                                            <th class="inner-table__th">예약 상태</th>
                                            <td class="inner-table__td">
                                                <div class="select-wrap w-170">
                                                    <select name="client_status[{{$o->id}}]" id="client_status_{{$o->id}}" class="select-v1 noto js-chg">
                                                        @php $list_state = \App\Http\Controllers\Controller::getCode('order_state'); @endphp
                                                        @foreach($list_state as $ls)
                                                            <option value="{{$ls->code}}">{{$ls->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </td>
                                            <th class="inner-table__th">예약자</th>
                                            <td class="inner-table__td"><input type="text" name="order_name[{{$o->id}}]" id="order_name_{{$o->id}}" class="input-v1" value="{{$o->order_name}}" placeholder="예약자명을 입력하세요" /></td>
                                            <th class="inner-table__th">예약자 연락처</th>
                                            <td class="inner-table__td"><input type="text" name="order_hp[{{$o->id}}]" id="order_hp_{{$o->id}}" class="input-v1" value="{{$o->order_hp}}" placeholder="예약자 연락처를 입력하세요" /></td>
                                        </tr>
                                        <tr class="inner-table__tr">
                                             <th class="inner-table__th">결제방법</th>
                                            <td class="inner-table__td" colspan="3">{{$o->charge_method}}</td>
                                            <th class="inner-table__th">방문자</th>
                                            <td class="inner-table__td"><input type="text" name="reserve_name[{{$o->id}}]" id="reserve_name_{{$o->id}}" class="input-v1 js-chg" value="{{$o->reserve_name}}" placeholder="방문자명을 입력하세요" /></td>
                                            <th class="inner-table__th">방문자 연락처</th>
                                            <td class="inner-table__td"><input type="text" name="reserve_hp[{{$o->id}}]" id="reserve_hp_{{$o->id}}" class="input-v1 js-chg" value="{{$o->reserve_hp}}" placeholder="방문자 연락처를 입력하세요" /></td>
                                        </tr>
                                        <tr class="inner-table__tr">
                                            <th class="inner-table__th">요청사항</th>
                                            <td class="inner-table__td" colspan="3">
                                                <textarea name="reserve_request[{{$o->id}}]" id="reserve_request_{{$o->id}}" style="width:100%; " class="textarea-v1 ">{{$o->reserve_request}}</textarea>
                                            </td>
                                            <th class="inner-table__th">관리자메모</th>
                                            <td class="inner-table__td" colspan="3">
                                                <textarea name="reserve_memo[{{$o->id}}]" id="reserve_memo_{{$o->id}}" style="width:100%; " class="textarea-v1 js-chg">{{$o->reserve_memo}}</textarea>
                                            </td>
                                        </tr>
                                        <tr class="inner-table__tr">
                                            <th class="inner-table__th">전체가격</th>
                                            <td class="inner-table__td"><input type="text" name="reserve_total[{{$o->id}}]" id="reserve_total_{{$o->id}}" class="input-v1 type-important" value="{{number_format($o->reserve_total)}}" readonly /></td>
                                            <th class="inner-table__th">할인가격</th>
                                            <td class="inner-table__td"><input type="text" name="reserve_discount[{{$o->id}}]" id="reserve_discount_{{$o->id}}" class="input-v1 type-important" value="{{number_format($o->reserve_discount)}}" readonly /></td>
                                            <th class="inner-table__th">결제금액</th>
                                            <td class="inner-table__td"><input type="text" name="reserve_price[{{$o->id}}]" id="reserve_price_{{$o->id}}" class="input-v1 type-important" value="{{number_format($o->reserve_price)}}" readonly /></td>
                                            <th class="inner-table__th">현장결제</th>
                                            <td class="inner-table__td"><input type="text" name="reserve_scene[{{$o->id}}]" id="reserve_scene_{{$o->id}}" class="input-v1 type-important" value="{{number_format($o->reserve_scene)}}" readonly /></td>
                                        </tr>
                                        <tr class="inner-table__tr type-margin">
                                            <td colspan="4" class="inner-table__td type-margin"></td>
                                        </tr>
                                        <tr class="inner-table__tr">
                                            <td colspan="8">
                                                <div class="inner-table__list">
                                                    @foreach($detail[$o->id] as $d)
                                                        <div class="table-a inner-table type-inner">
                                                            <table class="table-a__table">
                                                                <colgroup>
                                                                    <col width="90px">
                                                                    <col width="">
                                                                    <col width="90px">
                                                                    <col width="">
                                                                    <col width="90px">
                                                                    <col width="">
                                                                    <col width="90px">
                                                                    <col width="">
                                                                </colgroup>
                                                                <tr class="table-a__tr">
                                                                    <th class="table-a__th pd-lr-0 ta-r">객실명</th>
                                                                    <td class="table-a__td nobd-b">
                                                                        <input type="text" class="input-v1"
                                                                               name="room_info[{{$o->id}}][{{$d->id}}]"
                                                                               id="room_info_{{$o->id}}_{{$d->id}}"
                                                                               data-oid = "{{$o->id}}"
                                                                               data-did = "{{$d->id}}"
                                                                               data-total="{{$d->room_total}}" {{--룸정상금액--}}
                                                                               data-discount="{{$d->room_discount}}" {{--룸할인금액--}}
                                                                               data-price="{{$d->room_price}}" {{--룸판매금액--}}
                                                                               value="{{$d->room_name}}"/>
                                                                    </td>
                                                                    <th class="table-a__th pd-lr-0 ta-r">이용기간</th>
                                                                    <td class="table-a__td nobd-b" colspan="3">
                                                                        <div
                                                                            class="table-a__inbox type-line type-left wh-nw">
                                                                            <p class="dp-wrap dp-ib type-able disable-wrap">
                                                                                <input type="text"
                                                                                       class="datepicker va-m noto db_right_now_add js-chg"
                                                                                       name="reserve_date_start[{{$o->id}}][{{$d->id}}]"
                                                                                       id="reserve_date_start_{{$o->id}}_{{$d->id}}"
                                                                                       value="{{$d->reserve_date}}"/>
                                                                            </p>
                                                                            &nbsp;~&nbsp;
                                                                            <p class="dp-wrap dp-ib type-able disable-wrap">
                                                                                <input type="text"
                                                                                       class="datepicker va-m noto db_right_now_add js-chg"
                                                                                       name="reserve_date_end[{{$o->id}}][{{$d->id}}]"
                                                                                       id="reserve_date_end_{{$o->id}}_{{$d->id}}"
                                                                                       value="{{$d->reserve_date_end}}"/>
                                                                            </p>
                                                                        </div>
                                                                    </td>
                                                                    <th class="table-a__th pd-lr-0 ta-r">해당객실금액</th>
                                                                    <td class="table-a__td nobd-b ta-l">
                                                                        <div class="input-wrap" style="width:130px">
                                                                            <input type="text" name="room_total[{{$o->id}}][{{$d->id}}]"
                                                                                   id="room_total_{{$o->id}}_{{$d->id}}"
                                                                                   data-room_total=""
                                                                                   class="input-v1 js-chg ta-r"
                                                                                   value="200,000" readonly />
                                                                        </div>원
                                                                    </td>
                                                                </tr>
                                                                <tr class="table-a__tr">
                                                                    <th class="table-a__th pd-lr-0 ta-r">추가숙박인원</th>
                                                                    <td colspan="7" class="table-a__td nobd-b">
                                                                        <div class="inner-table__inbox fl">
                                                                            <ul class="person-num__list clb fl">
                                                                                <li class="person-num__item fl type-icon">
                                                                                    <label for="">성인:</label>
                                                                                    <input type="text"
                                                                                           name="cnt_adult[{{$o->id}}][{{$d->id}}]"
                                                                                           id="cnt_adult_{{$o->id}}_{{$d->id}}"
                                                                                           class="input-v1 person-num__input js-chg va-m"
                                                                                           data-price_adult="{{$d->price_adult}}"
                                                                                           value="{{$d->cnt_adult}}"
                                                                                           onkeyup="chgPrice('{{$o->id}}','{{$d->id}}')"
                                                                                           onkeydown="chgPrice('{{$o->id}}','{{$d->id}}')"
                                                                                           onblur="chgPrice('{{$o->id}}','{{$d->id}}')"
                                                                                    />명
                                                                                    × {{number_format($d->price_adult)}}원 &nbsp;=
                                                                                    <div class="input-wrap"
                                                                                         style="width:90px;vertical-align:middle">
                                                                                        <input type="text"
                                                                                               id="price_adult_{{$o->id}}_{{$d->id}}"
                                                                                               class="input-v1 js-chg ta-r"
                                                                                               value="{{$d->cnt_adult*$d->price_adult}}"
                                                                                               readonly
                                                                                        />
                                                                                    </div>
                                                                                    원
                                                                                </li>
                                                                                <li class="person-num__item fl type-icon">
                                                                                    <label for="">어린이:</label>
                                                                                    <input type="text"
                                                                                           name="cnt_child[{{$o->id}}][{{$d->id}}]"
                                                                                           id="cnt_child_{{$o->id}}_{{$d->id}}"
                                                                                           class="input-v1 person-num__input js-chg va-m"
                                                                                           data-price_child="{{$d->price_child}}"
                                                                                           value="{{$d->cnt_child}}"
                                                                                           onkeyup="chgPrice('{{$o->id}}','{{$d->id}}')"
                                                                                           onkeydown="chgPrice('{{$o->id}}','{{$d->id}}')"
                                                                                           onblur="chgPrice('{{$o->id}}','{{$d->id}}')"
                                                                                    />명
                                                                                    × {{number_format($d->price_child)}}원 &nbsp;=
                                                                                    <div class="input-wrap"
                                                                                         style="width:90px;vertical-align:middle">
                                                                                        <input type="text"
                                                                                               id="price_child_{{$o->id}}_{{$d->id}}"
                                                                                               class="input-v1 js-chg ta-r"
                                                                                               value="{{$d->cnt_child*$d->price_child}}"
                                                                                               readonly
                                                                                        />
                                                                                    </div>
                                                                                    원
                                                                                </li>
                                                                                <li class="person-num__item fl type-icon">
                                                                                    <label for="">유아:</label>
                                                                                    <input type="text"
                                                                                           name="cnt_baby[{{$o->id}}][{{$d->id}}]"
                                                                                           id="cnt_baby_{{$o->id}}_{{$d->id}}"
                                                                                           class="input-v1 person-num__input js-chg va-m"
                                                                                           data-price_baby="{{$d->price_baby}}"
                                                                                           value="{{$d->cnt_baby}}"
                                                                                           onkeyup="chgPrice('{{$o->id}}','{{$d->id}}')"
                                                                                           onkeydown="chgPrice('{{$o->id}}','{{$d->id}}')"
                                                                                           onblur="chgPrice('{{$o->id}}','{{$d->id}}')"
                                                                                    />명 ×
                                                                                    {{number_format($d->price_baby)}}원 &nbsp;=
                                                                                    <div class="input-wrap"
                                                                                         style="width:90px;vertical-align:middle">
                                                                                        <input type="text"
                                                                                               id="price_baby_{{$o->id}}_{{$d->id}}"
                                                                                               class="input-v1 js-chg ta-r"
                                                                                               value="{{$d->cnt_baby*$d->price_baby}}"
                                                                                               readonly
                                                                                        />
                                                                                    </div>
                                                                                    원
                                                                                </li>
                                                                            </ul>
                                                                            <span class="inner-table__info fl">(기준{{$d->room_cnt_basic}}명/최대{{$d->room_cnt_max}}명)</span>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <tr class="table-a__tr">
                                                                    <th class="table-a__th pd-lr-0 ta-r">객실가격</th>
                                                                    <td class="table-a__td nobd-b ta-l">
                                                                        <div class="input-wrap" style="width:130px">
                                                                            <input type="text"
                                                                                   name="room_price[{{$o->id}}][{{$d->id}}]"
                                                                                   id="room_price_{{$o->id}}_{{$d->id}}"
                                                                                   class="input-v1 js-chg ta-r"
                                                                                   value="200,000" />
                                                                        </div>
                                                                        원
                                                                    </td>
                                                                    <th class="table-a__th pd-lr-0 ta-r">인원추가비용</th>
                                                                    <td class="table-a__td nobd-b ta-l">
                                                                        <div class="input-wrap" style="width:130px">
                                                                            <input type="text"
                                                                                   name="person_price[{{$o->id}}][{{$d->id}}]"
                                                                                   id="person_price_{{$o->id}}_{{$d->id}}"
                                                                                   class="input-v1 js-chg ta-r"
                                                                                   value="200,000"/>
                                                                        </div>
                                                                        원
                                                                    </td>
                                                                    <th class="table-a__th pd-lr-0 ta-r">부가서비스비용</th>
                                                                    <td class="table-a__td nobd-b ta-l">
                                                                        <div class="input-wrap" style="width:130px">
                                                                            <input type="text"
                                                                                   name="etc_price[{{$o->id}}][{{$d->id}}]"
                                                                                   id="etc_price_{{$o->id}}_{{$d->id}}"
                                                                                   class="input-v1 js-chg ta-r"
                                                                                   value="200,000"/>
                                                                        </div>
                                                                        원
                                                                    </td>
                                                                    <th class="table-a__th pd-lr-0 ta-r">현장결제비용</th>
                                                                    <td class="table-a__td nobd-b ta-l">
                                                                        <div class="input-wrap" style="width:130px">
                                                                            <input type="text"
                                                                                   name="scene_price[{{$o->id}}][{{$d->id}}]"
                                                                                   id="scene_price_{{$o->id}}_{{$d->id}}"
                                                                                   class="input-v1 js-chg ta-r"
                                                                                   value="200,000"/>
                                                                        </div>
                                                                        원
                                                                    </td>
                                                                </tr>
                                                                <tr class="table-a__tr">
                                                                    <th class="table-a__th va-t pd-lr-0 ta-r">부가서비스</th>
                                                                    <td class="table-a__td nobd-b ta-l" colspan="7">
                                                                        <div class="inner-table__inbox fl">
                                                                            <ul class="facility-group__list fl clb"
                                                                                style="width:100%;">
                                                                                @php
                                                                                    $list_facility = \App\Models\ClientTypeFacility::leftJoin('code','code.code','=','client_type_facility.code_facility')
                                                                                    ->leftJoin('addition_etc_price','addition_etc_price.code','=','code.code')
                                                                                    ->where('client_type_facility.user_id',$d->client_id)
                                                                                    ->where('client_type_facility.type_id',$d->client_type_id)
                                                                                    ->where('client_type_facility.flag_use','Y')
                                                                                    ->selectRaw('client_type_facility.*, code.code_name, ifnull(addition_etc_price.etc_price,0)')
                                                                                    ->get();

                                                                                    $list_facility2 = \App\Models\AdditionEtcPriceRoom::leftJoin('addition_etc_price','addition_etc_price_room.addition_etc_price_id','=','addition_etc_price.id')
                                                                                    ->where('addition_etc_price.code',null)
                                                                                    ->where('addition_etc_price_room.room_id',$d->room_id)
                                                                                    ->selectRaw('addition_etc_price.*, addition_etc_price_room.room_id, addition_etc_price_room.addition_etc_price_id, addition_etc_price_room.id as aid')
                                                                                    ->get();

                                                                                    $order_facility = explode(",",$d->room_facility_cont);
                                                                                    $arrFac = [];
                                                                                    $arrFac2 = [];
                                                                                    foreach($order_facility as $of){
                                                                                        $tmp = explode("^",$of);
                                                                                        $arrFac[] = \App\Models\UserClientFacility::where('id',$tmp[0])->value('code_facility');
                                                                                        $arrFac2[] = $tmp[0];
                                                                                    }
                                                                                @endphp
                                                                                @foreach($list_facility as $f)
                                                                                    <li class="facility-group__item fl type-inner-table">
                                                                                        <input type="checkbox"
                                                                                               name="code_facility[{{$o->id}}][{{$d->id}}][]"
                                                                                               id="list_facility_{{$o->id}}_{{$d->id}}_{{$f->code_facility}}"
                                                                                               class="checkbox-v2 js-chg"
                                                                                               data-price="{{$f->etc_price}}"
                                                                                               data-method="{{$f->etc_payment_flag}}"
                                                                                               value="{{$f->code_facility}}" {{in_array($f->code_facility,$arrFac)?"checked":""}}
                                                                                               onclick="chgPrice('{{$o->id}}','{{$d->id}}')"
                                                                                        />
                                                                                        <label
                                                                                            for="list_facility_{{$o->id}}_{{$d->id}}_{{$f->code_facility}}">{{$f->code_name}}</label>
                                                                                    </li>
                                                                                @endforeach
                                                                                {{--추가시설의 ID값은 addition_etc_price_room의 ID값--}}
                                                                                @foreach($list_facility2 as $f)
                                                                                    <li class="facility-group__item fl type-inner-table">
                                                                                        <input type="checkbox"
                                                                                               name="code_facility2[{{$o->id}}][{{$f->id}}][]"
                                                                                               id="list_facility2_{{$o->id}}_{{$d->id}}_{{$f->id}}"
                                                                                               class="checkbox-v2 js-chg"
                                                                                               data-price="{{$f->etc_price}}"
                                                                                               data-method="{{$f->etc_payment_flag}}"
                                                                                               value="{{$f->code}}" {{in_array($f->aid,$arrFac2)?"checked":""}}
                                                                                               onclick="chgPrice('{{$o->id}}','{{$f->id}}')"
                                                                                        />
                                                                                        <label
                                                                                            for="list_facility2_{{$o->id}}_{{$d->id}}_{{$f->id}}">{{$f->etc_name}}</label>
                                                                                    </li>
                                                                                @endforeach
                                                                            </ul>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                    <div class="inner-table__btn fs-0">
                                        <button type="button" class="btn-v1 type-middle inner-table__edit">변경</button>
                                        <button type="submit" class="btn-v1 type-middle inner-table__after ml-5">변경완료</button>
                                        <button type="button" class="btn-v1 type-middle type-red inner-table__after ml-5">예약취소</button>
                                        <button type="button" class="btn-v2 inner-table__after js-edit-cancel ml-5">변경취소</button>
                                    </div>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
        <div>{{ $order->links('admin.pc.pagination.default') }}</div>
    </div>



<!--
    <ul class="inner-table__list clb" >
                                                    @foreach($detail[$o->id] as $d)
                                                    <li class="inner-table__item">
                                                        <div class="inner-table__wrap type-height clb">
                                                            <div class="inner-table__inner clb fl">
                                                                <span class="inner-table__span fl">객실명</span>
                                                                <div class="inner-table__inbox fl" style="width:110px">
                                                                    <input type="text" class="input-v1"
                                                                           id="room_info_{{$d->id}}"
                                                                           data-total="{{$d->room_total}}" {{--룸정상금액--}}
                                                                           data-discount="{{$d->room_discount}}" {{--룸할인금액--}}
                                                                           data-price="{{$d->room_price}}" {{--룸판매금액--}}
                                                                           value="{{$d->room_name}}"/>
                                                                </div>
                                                            </div>
                                                            <div class="inner-table__inner clb fl">
                                                                <span class="inner-table__span fl">숙박인원</span>
                                                                <div class="inner-table__inbox fl">
                                                                    <ul class="person-num__list clb fl">
                                                                        <li class="person-num__item fl">
                                                                            <label for="">성인</label>
                                                                            <input type="text" name="cnt_adult[{{$d->id}}]" class="input-v1 person-num__input js-chg" data-price_adult="{{$d->price_adult}}" value="{{$d->cnt_adult}}" />
                                                                        </li>
                                                                        <li class="person-num__item fl">
                                                                            <label for="">어린이</label>
                                                                            <input type="text" name="cnt_child[{{$d->id}}]" class="input-v1 person-num__input js-chg" data-price_child="{{$d->price_child}}" value="{{$d->cnt_child}}" />
                                                                        </li>
                                                                        <li class="person-num__item fl">
                                                                            <label for="">유아</label>
                                                                            <input type="text" name="cnt_baby[{{$d->id}}]" class="input-v1 person-num__input js-chg" data-price_baby="{{$d->price_baby}}" value="{{$d->cnt_baby}}" />
                                                                        </li>
                                                                    </ul>
                                                                    <span class="inner-table__info fl">(기준{{$d->room_cnt_basic}}명/최대{{$d->room_cnt_max}}명)</span>
                                                                </div>
                                                            </div>
                                                            <div class="inner-table__inner clb fl">
                                                                <span class="inner-table__span fl">이용기간</span>
                                                                <div class="inner-table__inbox fl">
                                                                    <div class="table-a__inbox type-line type-left">
                                                                        <p class="dp-wrap dp-ib type-able disable-wrap">
                                                                            <input type="text" class="datepicker va-m noto db_right_now_add js-chg" name="reserve_date_start[{{$d->id}}]" id="reserve_date_start_{{$d->id}}" value="{{$d->reserve_date}}" />
                                                                        </p>
                                                                        &nbsp;~&nbsp;
                                                                        <p class="dp-wrap dp-ib type-able disable-wrap">
                                                                            <input type="text" class="datepicker va-m noto db_right_now_add js-chg" name="reserve_date_end[{{$d->id}}]" id="reserve_date_end_{{$d->id}}" value="{{$d->reserve_date_end}}" />
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="inner-table__inner clb fl">
                                                                <span class="inner-table__span fl">룸가격</span>
                                                                <div class="inner-table__inbox fl" style="width:110px">
                                                                    <input type="text" class="input-v1 js-chg" value="100,000원" />
                                                                </div>
                                                            </div>
                                                            <div class="inner-table__inner clb fl">
                                                                <span class="inner-table__span fl">인원추가비용</span>
                                                                <div class="inner-table__inbox fl" style="width:110px">
                                                                    성인: <span>1명</span>*<span>20,000원</span>=<input type="text" class="input-v1 js-chg" value="110,000" />원{{--after content 이용--}}
                                                                    , 아동: <span>1명</span>*<span>20,000원</span>=<input type="text" class="input-v1 js-chg" value="110,000" />원{{--after content 이용--}}
                                                                    , 유아: <span>1명</span>*<span>20,000원</span>=<input type="text" class="input-v1 js-chg" value="110,000" />원{{--after content 이용--}}
                                                                </div>
                                                            </div>
                                                            <div class="inner-table__inner clb fl">
                                                                <span class="inner-table__span fl">부대시설비용</span>
                                                                <div class="inner-table__inbox fl" style="width:110px">
                                                                    <input type="text" class="input-v1" value="110,000원" />
                                                                </div>
                                                            </div>
                                                            <div class="inner-table__inner clb fl">
                                                                <span class="inner-table__span fl">결제금액</span>
                                                                <div class="inner-table__inbox fl" style="width:110px">
                                                                    <input type="text" class="input-v1" value="200,000원" />
                                                                </div>
                                                            </div>
                                                            <div class="inner-table__inner clb fl" style="width:100%">
                                                                <span class="inner-table__span fl">부가서비스</span>
                                                                <div class="inner-table__inbox fl">
                                                                    <ul class="facility-group__list fl clb" style="width:100%;">
                                                                        @php
                                                                            $list_facility = \App\Models\ClientTypeFacility::leftJoin('code','code.code','=','client_type_facility.code_facility')
                                                                            ->leftJoin('addition_etc_price','addition_etc_price.code','=','code.code')
                                                                            ->where('client_type_facility.user_id',$d->client_id)
                                                                            ->where('client_type_facility.type_id',$d->client_type_id)
                                                                            ->where('client_type_facility.flag_use','Y')
                                                                            ->selectRaw('client_type_facility.*, code.code_name, ifnull(addition_etc_price.etc_price,0)')
                                                                            ->get();

                                                                            $list_facility2 = \App\Models\AdditionEtcPriceRoom::leftJoin('addition_etc_price','addition_etc_price_room.addition_etc_price_id','=','addition_etc_price.id')
                                                                            ->where('addition_etc_price.code',null)
                                                                            ->where('addition_etc_price_room.room_id',$d->room_id)
                                                                            ->selectRaw('addition_etc_price.*, addition_etc_price_room.room_id, addition_etc_price_room.addition_etc_price_id, addition_etc_price_room.id as aid')
                                                                            ->get();

                                                                            $order_facility = explode(",",$d->room_facility_cont);
                                                                            $arrFac = [];
                                                                            $arrFac2 = [];
                                                                            foreach($order_facility as $of){
                                                                                $tmp = explode("^",$of);
                                                                                $arrFac[] = \App\Models\UserClientFacility::where('id',$tmp[0])->value('code_facility');
                                                                                $arrFac2[] = $tmp[0];
                                                                            }
                                                                        @endphp
                                                                        @foreach($list_facility as $f)
                                                                            <li class="facility-group__item fl type-inner-table">
                                                                                <input type="checkbox"
                                                                                       name="code_facility[{{$d->id}}][]"
                                                                                       id="list_facility_{{$o->id}}_{{$d->id}}_{{$f->code_facility}}"
                                                                                       class="checkbox-v2 js-chg"
                                                                                       data-price="{{$f->etc_price}}"
                                                                                       value="{{$f->code_facility}}" {{in_array($f->code_facility,$arrFac)?"checked":""}} />
                                                                                <label
                                                                                    for="list_facility_{{$o->id}}_{{$d->id}}_{{$f->code_facility}}">{{$f->code_name}}</label>
                                                                            </li>
                                                                        @endforeach
                                                                        {{--추가시설의 ID값은 addition_etc_price_room의 ID값--}}
                                                                        @foreach($list_facility2 as $f)
                                                                            <li class="facility-group__item fl type-inner-table">
                                                                                <input type="checkbox"
                                                                                       name="code_facility2[{{$d->id}}][]"
                                                                                       id="list_facility2_{{$o->id}}_{{$d->id}}_{{$f->id}}"
                                                                                       class="checkbox-v2 js-chg"
                                                                                       data-price="{{$f->etc_price}}"
                                                                                       value="{{$f->code}}" {{in_array($f->aid,$arrFac2)?"checked":""}} />
                                                                                <label
                                                                                    for="list_facility2_{{$o->id}}_{{$d->id}}_{{$f->id}}">{{$f->etc_name}}</label>
                                                                            </li>
                                                                        @endforeach
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    @endforeach
                                                </ul>
-->
@endsection
