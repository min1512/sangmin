@php
    $path = $_SERVER["HTTP_HOST"];
    $path = str_replace(".einet.co.kr","",$path);
@endphp
<script>
    function btnSaveAdd(type,aid) {
        if(!aid) var aid = ""; else aid = "/"+aid;
        $(".dim").show();
        $(".etc1_list_blade_popup").removeClass(".bld-pop");
        $("#etc1_list_blade_popup").html($("#html_etc").html());

        if(type=="staff"){
            $.post(
                "{{route('price.facility.info',['user_id'=>$user_id])}}"+aid
                , {
                    _token: '{{csrf_token()}}'
                }
                , function(data){
                    console.log(data);
                    $("#addition_id").val(data.isset&&data.isset.id!=""?data.isset.id:'');
                    $("#facility").val(data.isset&&data.isset.code!=""?data.isset.code:'');
                    if(data.isset && data.isset.code!=null) $("#etc_name").prop("disabled",true); else $("#etc_name").prop("disabled",false);
                    $("#etc_name").val(data.isset&&data.isset.etc_name!=""?data.isset.etc_name:'');
                    $("#etc_content").html(data.isset&&data.isset.etc_content!=""?data.isset.etc_content:'');
                    $("#etc_price").val(data.isset&&data.isset.etc_price!=""?data.isset.etc_price:0);
                    $("#etc_dan").val(data.isset&&data.isset.etc_dan!=""?data.isset.etc_dan:'');
                    $(".chg_dan").text($("#etc_dan option:checked").text());
                    $("#etc_min").val(data.isset&&data.isset.etc_min!=""?data.isset.etc_min:'');
                    $("#etc_max").val(data.isset&&data.isset.etc_max!=""?data.isset.etc_max:'');

                    if(data.room.list_room) var tmp_room = data.room.list_room.split(/,/);
                    $("input[name='client_room[]']").each(function(){
                        if($.inArray($(this).val(),tmp_room)>-1) $(this).prop("checked",true);
                        else $(this).prop("checked",false);
                    });

                    if(data.isset && data.isset.etc_payment_flag!="") $("#etc_payment_flag_"+data.isset.etc_payment_flag).prop("checked",true);
                    if(data.isset && data.isset.etc_reserve_flag!="") $("#etc_reserve_flag_"+data.isset.etc_reserve_flag).prop("checked",true);
                    if(data.isset && data.isset.etc_flag!="") $("#etc_flag_"+data.isset.etc_flag).prop("checked",true);

                    $("#etc1_list_blade_popup").css("display","table");
                }
                , 'json'
            )
        }

        {{--if(type=="client")--}}
        {{--    var url = '{{route('info.etc.view',['did'=>isset($did)?$did:""])}}';--}}
        {{--else--}}
        {{--    var url = '{{route('price.facility.view',['user_id'=>isset($user_id)?$user_id:"", 'did'=>isset($did)?$did:""])}}';--}}
    }

    function popClose() {
        $("#etc1_list_blade_popup").empty("").hide();
        $(".dim").hide();
    }

    $(document).on("change",".etc_dan",function(){
        var unit_txt = $(this).find("option:selected");
        unit_txt = $(unit_txt).text();
        $(".chg_dan").text(unit_txt);
    });

    $(document).on("change",".js-facility-select",function(){
        if($(this).val() == "직접입력"){
            $(".js-facility-input").prop("disabled",false);
            $(".js-facility-input").focus();
        }else{
            $(".js-facility-input").prop("disabled",true);
        }

    });


</script>
<div class="list_blade">
    <div class="table-a noto">
        <div class="table-a__head clb">
            <p class="table-a__tit fl">추가 이용요금 설정</p>
            <div class="table-a_inbox type-head fr">
{{--                <button class="mr-2 btn btn-focus" onclick="goUrl('@if($path=="client") {{route('info.etc.view',['did'=>isset($did)?$did:""])}} @else {{route('price.facility.view',['user_id'=>isset($user_id)?$user_id:"", 'did'=>isset($did)?$did:""])}} @endif');">추가이용요금 등록</button>--}}
                <button type="button" class="btn-v1" onclick="btnSaveAdd('{{$path}}');">추가 이용요금 등록</button>
            </div>
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
                <col width="">
            </colgroup>
            <tr class="table-a__tr type-th">
                <th class="table-a__th">번호</th>
                <th class="table-a__th">할인명</th>
                <th class="table-a__th">금액</th>
                <th class="table-a__th">기본/최대 수량</th>
                <th class="table-a__th">판매객실</th>
                <th class="table-a__th">결제방법</th>
                <th class="table-a__th">당일예약</th>
				<th class="table-a__th">판매상태</th>
				<th class="table-a__th">관리</th>
            </tr>
            @foreach($additionetcprice as $k => $c)
            <tr class="table-a__tr">
                <td class="table-a__td">
                    <div class="table-a__inbox">
                        <span>{{$additionetcprice->total()-$k}}</span>
                    </div>
                </td>
                <td class="table-a__td type-td-point">
                    <div class="table-a__inbox">
                        <span class="type-point type-line" onclick="btnSaveAdd('{{$path}}',{{$c->id}})">
                            {{$c->etc_name==""&&$c->code!=""?\App\Http\Controllers\Controller::getCodeName($c->code):$c->etc_name}}
                        </span>
                    </div>
                </td>
                <td class="table-a__td">
                    <div class="table-a__inbox">
                        <span>{{number_format($c->etc_price)}}원</span>
                    </div>
                </td>
                <td class="table-a__td">
                    <div class="table-a__inbox">
                        <span>{{$c->etc_min}}/{{$c->etc_max}}</span>
                    </div>
                </td>
                <td class="table-a__td">
                    <div class="table-a__inbox">
                        <span>선택 객실</span>
                    </div>
                </td>
                <td class="table-a__td">
                    <div class="table-a__inbox" style="max-width:300px">
                        <span class="ellipsis dp-ib" style="width:100%">{{$c->etc_payment_flag=="Y"?"예약시 결제":"현장 결제"}}</span>
                    </div>
                </td>
				<td class="table-a__td">
                    <div class="table-a__inbox">
                        <span class="ellipsis dp-ib" style="width:100%">{{$c->etc_reserve_flag=="Y"?"가능":"불가능"}}</span>
                    </div>
                </td>
				<td class="table-a__td">
                    <div class="table-a__inbox">
                        <span class="ellipsis dp-ib" style="width:100%">{{$c->etc_flag=="Y"?"판매":"비공개"}}</span>
                    </div>
                </td>
                <td class="table-a__td">
                    <div class="table-a__inbox">
                        <button type="button" class="table-a__btn btn-v2" style="width:100%">삭제</button>
                    </div>
                </td>
            </tr>
            @endforeach
            <tfoot>
            <tr><td colspan="9">{{$additionetcprice->links('admin.pc.pagination.default')}}</td></tr>
            </tfoot>
        </table>
{{--
        <div class="btn-wrap type-fg">
            <button type="button" class="btn-v4 type-save">저장</button>
            <button type="button" class="btn-v1 status-rb" onclick="btnSaveAdd('{{$path}}');">추가 이용요금 등록</button>
        </div>
--}}
	</div>
</div>
<div class="pop-module js-pop etc1_list_blade_popup bld-pop" id="etc1_list_blade_popup">
<!--
    <div class="pop-module__wrap">
        <div class="pop-module__box">
            <div class="pop-module__inbox" id="etc1_list_blade_popup" style="width:746px; "></div>
        </div>
    </div>
-->
</div>
<script type=text/template id="html_etc">
    <div class="pop-module__wrap">
        <div class="pop-module__box">
            <div class="pop-module__inbox"style="width:746px; ">
                <form method="post" name="frmAddition" action="{{route('price.facility.save',['user_id'=>$user_id])}}">
                {{ csrf_field() }}
                <input type="hidden" name="addition_id" id="addition_id" />
                    <!-- 팝업 시작-->

                    <div class="pop-module__head clb">
                        <span class="pop-module__tit fl">추가 이용요금 등록하기</span>
                        <span class="pop-module__close fr" onclick="popClose()">닫기</span>
                    </div>
                    <div class="pop-module__body">
                        <div class="table-a noto">
                            <table class="table-a__table type-top">
                                <colgroup>
                                    <col width="120px">
                                    <col width="">
                                </colgroup>
                                <tr class="table-a__tr">
                                    <td class="table-a__td type-nobd type-right type-top  type-pop">
                                        <span>추가 이용명</span>
                                    </td>
                                    <td class="table-a__td type-nobd type-left pd-r-50 type-pop">
                                        <div class="select-wrap dp-ib" style="width:180px;">
                                            <select name="facility" id="facility" class="select-v1 noto js-facility-select"  >
                                                @foreach($list_facility as $lf)
                                                <option value="{{$lf->code_facility}}">{{$lf->code_name}}</option>
                                                @endforeach
                                                <option value="">직접입력</option>
                                            </select>
                                        </div>
                                        <div class="input-wrap dp-ib va-m ml-5">
                                             <input type="text" name="etc_name" id="etc_name" class="input-v1 js-facility-input type-mail" style="width:200px; " disabled="true" />
                                        </div>

                                    </td>
                                </tr>

                                <tr class="table-a__tr">
                                    <td class="table-a__td type-nobd type-right  type-pop"><span>상세 설명</span></td>
                                    <td class="table-a__td type-nobd type-left pd-r-50 type-pop">
                                        <div class="guide-box">
                                            <div class="guide-wrap">
                                                <!-- textarea-v1-->
                                                <textarea name="etc_content" id="etc_content" class="textarea-v1"></textarea>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="table-a__tr">
                                    <td class="table-a__td type-nobd type-right  type-pop">
                                        <span class="">기본 금액</span>
                                    </td>
                                    <td class="table-a__td type-nobd type-left pd-r-50 type-pop">
                                        <div class="input-wrap mr-5" style="width:150px;">
                                            <input type="text" name="etc_price" id="etc_price" class="input-v1 number" value="11" />
                                        </div><span class="c-777 dp-ib chg_dan ml-5" >원</span>
                                        <span class="c-777 dp-ib" style="margin-left:18px;">단위</span>
                                        <div class="select-wrap dp-ib" style="width:75px;">
                                            <select name="etc_dan" id="etc_dan" class="select-v1 noto etc_dan">
                                                @php $unit = \App\Http\Controllers\Controller::getCode('facility_unit'); @endphp
                                                @foreach($unit as $u)
                                                <option value="{{$u->code}}">{{$u->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </td>
                                </tr>

                                <tr class="table-a__tr">
                                    <td class="table-a__td type-nobd type-right  type-pop">
                                        <span class="dp-ib">기본 / 최대 수량</span>
                                    </td>
                                    <td class="table-a__td type-nobd type-left pd-r-50 type-pop">
                                        <span class="c-777" style="margin-right:10px;">기본</span>
                                        <div class="input-wrap" style="width:98px;">
                                            <input type="text" name="etc_min" id="etc_min" class="input-v1 ta-r" />
                                        </div><span class="c-777 dp-ib chg_dan ml-5" >원</span>
                                        <span class="c-777 dp-ib" style="margin-right:10px; margin-left:30px;">최대</span>
                                        <div class="input-wrap" style="width:98px;">
                                            <input type="text" name="etc_max" id="etc_max" class="input-v1 ta-r" />
                                        </div><span class="c-777 dp-ib chg_dan ml-5" >원</span>
                                    </td>
                                </tr>

                                <tr class="table-a__tr">
                                    <td class="table-a__td type-nobd type-right type-top  type-pop">
                                        <span>픽업</span>
                                    </td>
                                    <td class="table-a__td type-nobd type-left pd-r-50 type-pop">
                                        <div style="margin-bottom:5px;" class="ta-l">
                                            <span class="c-777"  >픽업 안내문구</span>
                                            <div class="input-wrap va-m dp-ib ml-5"  style="width:380px;">
                                                <input type="text" class="input-v1" />
                                            </div>
                                        </div>
                                        <ul class="clb">
                                            <li class=" fl">
                                                <span class="c-777" style="margin-right:20px;">입실픽업 가능 시간</span>
                                                <input type="checkbox" id="chk5-17" class="checkbox-v2" name="">
                                                <label for="chk5-17" style="margin-right:20px;">사용</label>
                                                <div class="select-wrap dp-ib" style="width:120px;">
                                                    <select name="" id="" class="select-v1 noto">
                                                        <option value="오전 09:30">오전 09:30</option>
                                                    </select>
                                                </div>
                                                <span class="c-777" style="margin:auto 10px;">~</span>
                                                <div class="select-wrap dp-ib" style="width:120px;">
                                                    <select name="" id="" class="select-v1 noto">
                                                        <option value="오전 09:30">오전 09:30</option>
                                                    </select>
                                                </div>
                                            </li>
                                        </ul>
                                    </td>
                                </tr>

                                <tr class="table-a__tr">
                                    <td class="table-a__td type-nobd type-right type-top  type-pop">
                                        <span>객실선택</span>
                                    </td>
                                    <td class="table-a__td type-nobd type-left pd-r-50 type-pop">
                                        <p>
                                            <input type="checkbox" id="chk5-18" class="checkbox-v2" name="">
                                            <label for="chk5-18">룸 전체 선택</label>
                                        </p>
                                        <div class="rchoice-group clb">
                                            <ul class="rchoice-group__list cl">
                                                @foreach($clientRoom as $cr)
                                                <li class="rchoice-group__item fl">
                                                    <input type="checkbox" id="client_room_{{$cr->id}}" class="checkbox-v2" name="client_room[]" value="{{$cr->id}}" />
                                                    <label for="client_room_{{$cr->id}}">{{$cr->room_name}}</label>
                                                </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="table-a__tr">
                                    <td class="table-a__td type-nobd type-right type-top  type-pop">
                                        <span>결제 방법</span>
                                    </td>
                                    <td class="table-a__td type-nobd type-left pd-r-50 type-pop">
                                        <div class="rchoice-group clb">
                                            <ul class="rchoice-group__list cl">
                                                <li class="rchoice-group__item fl">
                                                    <input type="radio" id="etc_payment_flag_Y" class="radio-v1" name="etc_payment_flag" value="Y" checked />
                                                    <label for="etc_payment_flag_Y">예약시 결제</label>
                                                </li>
                                                <li class="rchoice-group__item fl" >
                                                    <input type="radio" id="etc_payment_flag_N" class="radio-v1" name="etc_payment_flag" value="N" />
                                                    <label for="etc_payment_flag_N">현장결제</label>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="table-a__tr">
                                    <td class="table-a__td type-nobd type-right type-top  type-pop">
                                        <span>당일 예약</span>
                                    </td>
                                    <td class="table-a__td type-nobd type-left pd-r-50 type-pop">
                                        <div class="rchoice-group clb">
                                            <ul class="rchoice-group__list cl">
                                                <li class="rchoice-group__item fl">
                                                    <input type="radio" id="etc_reservation_flag_Y" class="radio-v1" name="etc_reservation_flag" value="Y" checked />
                                                    <label for="etc_reservation_flag_Y">가능</label>
                                                </li>
                                                <li class="rchoice-group__item fl" >
                                                    <input type="radio" id="etc_reservation_flag_N" class="radio-v1" name="etc_reservation_flag" value="N" />
                                                    <label for="etc_reservation_flag_N">불가능</label>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="table-a__tr">
                                    <td class="table-a__td type-nobd type-right type-top  type-pop">
                                        <span>판매 상태</span>
                                    </td>
                                    <td class="table-a__td type-nobd type-left pd-r-50 type-pop">
                                        <div class="rchoice-group clb">
                                            <ul class="rchoice-group__list cl">
                                                <li class="rchoice-group__item fl">
                                                    <input type="radio" id="etc_flag_Y" class="radio-v1" name="etc_flag" value="Y" checked />
                                                    <label for="etc_flag_Y">판매</label>
                                                </li>
                                                <li class="rchoice-group__item fl">
                                                    <input type="radio" id="etc_flag_N" class="radio-v1" name="etc_flag" value="N" />
                                                    <label for="etc_flag_N">비판매</label>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="btn-wrap mt-10">
                            <button type="submit" class="btn-v4 type-save">저장</button>
                        </div>
                    </div>
                <!-- 팝업 끝-->
                </form>
            </div>
        </div>
    </div>
</script>
