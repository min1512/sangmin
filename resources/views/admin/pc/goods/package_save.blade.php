@extends("admin.pc.layout.basic")

@section("title")상품(패키지)관리@endsection

@section("scripts")
    @php $list_amanity = []; $list_service = []; @endphp
    @if(isset($amanity)&&sizeof($amanity)>0)
    @foreach($amanity as $a)
        @php $list_amanity[] = $a->code_amanity; @endphp
    @endforeach
    @endif
    @if(isset($service)&&sizeof($service)>0)
    @foreach($service as $s)
        @php $list_service[] = $s->code_service; @endphp
    @endforeach
    @endif
    <script>
        $(document).ready(function(){
            @if(isset($goods))
            callInfo('{{$goods->client_id}}','{{$goods->room_id}}','{{join(",",$list_amanity)}}','{{join(",",$list_service)}}');
            @endif
        })
        $(function(){
            $("select#client_id").change(function(){
                callInfo($(this).val());
            });

            $("input[id=allday]").click(function(){
                if($(this).prop("checked")) $("input[name^='goods_days[]']").prop("checked",true);
                else $("input[name^='goods_days[]']").prop("checked",false);
            })
        });

        function callInfo(client_id,room_id,list_amanity,list_service){
            if(!room_id) room_id = "";
            if(!list_amanity) list_amanity = "";
            if(!list_service) list_service = "";
            $.post(
                '/goods/rooms/'+client_id
                ,{
                    _token: '{{csrf_token()}}'
                }
                ,function(data){
                    if(data.rooms.length>0){
                        var option = '<option value="">::객실을 선택하세요::</option>';
                        for(var i in data.rooms){
                            var item = data.rooms[i];
                            option += '<option value="'+item.id+'" '+(item.id==room_id?'selected':'')+'>'+item.room_name+'</option>';
                        }
                        $("select#room_id").empty().html(option);
                    }
                }
                ,"json"
            );
            $.post(
                '/goods/facility/'+client_id
                ,{
                    _token: '{{csrf_token()}}'
                }
                ,function(data){
                    if(data.amanity.length>0){
                        var amanity = "";
                        list_amanity = list_amanity.split(/,/);
                        for(var i in data.amanity){
                            var item = data.amanity[i];
                            amanity += '<li class="facility-group__item fl type-170">';
                                amanity += '<input type="checkbox" id="amanity_'+item.id+'" class="checkbox-v2" name="amanity[]" value="'+item.code_amanity+'" '+(tmp_amanity.indexOf(item.code_amanity)>-1?'checked':'')+' />';
                                amanity += '<label for="amanity_'+item.id+'">'+item.code_name+'</label>';
                            amanity += '</li>';
                        }
                        $("ul#list_amanity").html(amanity);
                    }
                    if(data.service.length>0){
                        var service = "";
                        list_service = list_service.split(/,/);
                        for(var i in data.service){
                            var item = data.service[i];
                            service += '<li class="facility-group__item fl type-170">';
                                service += '<input type="checkbox" id="service_'+item.id+'" class="checkbox-v2" name="service[]" value="'+item.code_service+'" '+(list_service.indexOf(item.code_service)>-1?'checked':'')+' />';
                                service += '<label for="service_'+item.id+'">'+item.code_name+'</label>';
                            service += '</li>';
                        }
                        $("ul#list_service").html(service);
                    }
                }
                ,"json"
            );
        }
    </script>
@endsection

@section("styles")
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
@endsection

@section("contents")
<div class="cont-wrap">
    <form method="post" name="frmGoods" id="frmGoods" action="{{url()->current()}}">
    {{csrf_field()}}
    <div class="table-a noto">
        <div class="table-a__head clb">
            <p class="table-a__tit fl">상품 / 패키지 상세관리</p>
        </div>
        <table class="table-a__table">
        <colgroup>
            <col width="130px">
            <col width="*">
        </colgroup>
            <tr class="table-a__tr type-th">
                <td class="table-a__td type-nobd type-right type-top lh-33 type-grey">숙박업체</td>
                <td class="table-a__td type-nobd type-left pd-10">
                    <div class="table-a__inbox ta-l fs-0">
                        <select class="js-example-basic-single" name="client_id" id="client_id">
                            <option value="">::숙박업체를 선택하세요::</option>
                            @foreach($client as $c)
                            <option value="{{$c->user_id}}" {{isset($goods)&&$goods->client_id==$c->user_id?"selected":""}}>{{$c->client_name}}</option>
                            @endforeach
                        </select>
                        <span class="table-a__info">숙박업체를 선택하세요</span>
                    </div>
                </td>
{{--                <td class="table-a__td type-nobd type-left pd-10"></td>--}}
            </tr>
            <tr class="table-a__tr">
                <td class="table-a__td type-nobd type-right type-top lh-33 type-grey">객실</td>
                <td class="table-a__td type-nobd type-left pd-10">
                    <div class="table-a__inbox ta-l fs-0">
                        <select class="js-example-basic-single" name="room_id" id="room_id">
                            <option value="">::객실을 선택하세요::</option>
                        </select>
                        <span class="table-a__info">객실명을 선택하세요</span>
                    </div>
                </td>
{{--                <td class="table-a__td type-nobd type-left pd-10"></td>--}}
            </tr>
            <tr class="table-a__tr ">
                <td class="table-a__td type-nobd type-right type-top lh-33 type-grey">상품(패키지)명</td>
                <td class="table-a__td type-nobd type-left pd-10">
                    <div class="input-wrap input-v2 noto" style="width:250px;">
                        <input type="text" name="goods_name" class="input-v2__input" value="{{ isset($goods)?$goods->goods_name:"" }}" />
                    </div>
                </td>
{{--
                <td class="table-a__td type-nobd type-left pd-10 type-info">
                    상품(패키지)명을 입력하세요
                </td>
--}}
            </tr>
            <tr class="table-a__tr">
                <td class="table-a__td type-nobd type-right type-top lh-33 type-grey">구비시설</td>
                <td class="table-a__td type-nobd type-left pd-10">
                    <div class="table-a__inbox ta-l">
                        <ul class="facility-group__list fl clb" id="list_amanity">
                        </ul>
                    </div>
                </td>
{{--
                <td class="table-a__td type-nobd type-left pd-10 type-info">
                    포함된 시설을 선택하세요.
                </td>
--}}
            </tr>
            <tr class="table-a__tr">
                <td class="table-a__td type-nobd type-right type-top lh-33 type-grey">서비스</td>
                <td class="table-a__td type-nobd type-left pd-10">
                    <div class="table-a__inbox ta-l">
                        <ul class="facility-group__list fl clb" id="list_service">
                        </ul>
                    </div>
                </td>
{{--
                <td class="table-a__td type-nobd type-left pd-10 type-info">
                    포함된 서비스를 선택하세요.
                </td>
--}}
            </tr>
            <tr class="table-a__tr ">
                <td class="table-a__td type-nobd type-right type-top lh-33 type-grey">가격정보</td>
                <td class="table-a__td type-nobd type-left pd-0">
                    <table cellpadding="0" cellspacing="0" class="table-a__table">
                        <colgroup>
                            <col width="10%" />
                            <col width="22.5%" />
                            <col width="22.5%" />
                            <col width="22.5%" />
                            <col width="22.5%" />
                        </colgroup>
                        <tr class="table-a__tr">
                            <td class="table-a__td">구분</td>
                            <td class="table-a__td">일요일(공휴일)</td>
                            <td class="table-a__td">주중</td>
                            <td class="table-a__td">금요일</td>
                            <td class="table-a__td">토요일(공휴일전날)</td>
                        </tr>
                        <tr class="table-a__tr">
                            <td class="table-a__td">정상가</td>
                            <td class="table-a__td">
                                <div class="input-wrap input-v2 noto" style="width:150px;">
                                    <input type="text" name="goods_price_origin[0]" class="input-v2__input type-percent-discount type-unit type-won" value="{{ isset($goods)?$goods->goods_price_origin_0:0 }}" /> 원
                                </div>
                            </td>
                            <td class="table-a__td">
                                <div class="input-wrap input-v2 noto" style="width:150px;">
                                    <input type="text" name="goods_price_origin[1]" class="input-v2__input type-percent-discount type-unit type-won" value="{{ isset($goods)?$goods->goods_price_origin_1:0 }}" /> 원
                                </div>
                            </td>
                            <td class="table-a__td">
                                <div class="input-wrap input-v2 noto" style="width:150px;">
                                    <input type="text" name="goods_price_origin[5]" class="input-v2__input type-percent-discount type-unit type-won" value="{{ isset($goods)?$goods->goods_price_origin_5:0 }}" /> 원
                                </div>
                            </td>
                            <td class="table-a__td">
                                <div class="input-wrap input-v2 noto" style="width:150px;">
                                    <input type="text" name="goods_price_origin[6]" class="input-v2__input type-percent-discount type-unit type-won" value="{{ isset($goods)?$goods->goods_price_origin_6:0 }}" /> 원
                                </div>
                            </td>
                        </tr>
                        <tr class="table-a__tr">
                            <td class="table-a__td nobd-b">판매가</td>
                            <td class="table-a__td nobd-b">
                                <div class="input-wrap input-v2 noto" style="width:150px;">
                                    <input type="text" name="goods_price_sales[0]" class="input-v2__input type-percent-discount type-unit type-won" value="{{ isset($goods)?$goods->goods_price_sales_0:0 }}" /> 원
                                </div>
                            </td>
                            <td class="table-a__td nobd-b">
                                <div class="input-wrap input-v2 noto" style="width:150px;">
                                    <input type="text" name="goods_price_sales[1]" class="input-v2__input type-percent-discount type-unit type-won" value="{{ isset($goods)?$goods->goods_price_sales_1:0 }}" /> 원
                                </div>
                            </td>
                            <td class="table-a__td nobd-b">
                                <div class="input-wrap input-v2 noto" style="width:150px;">
                                    <input type="text" name="goods_price_sales[5]" class="input-v2__input type-percent-discount type-unit type-won" value="{{ isset($goods)?$goods->goods_price_sales_5:0 }}" /> 원
                                </div>
                            </td>
                            <td class="table-a__td nobd-b">
                                <div class="input-wrap input-v2 noto" style="width:150px;">
                                    <input type="text" name="goods_price_sales[6]" class="input-v2__input type-percent-discount type-unit type-won" value="{{ isset($goods)?$goods->goods_price_sales_6:0 }}" /> 원
                                </div>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
{{--
            <tr class="table-a__tr">
                <td class="table-a__td type-nobd type-right type-top lh-33 type-grey">할인가</td>
                <td class="table-a__td type-nobd type-left pd-10">
                    <div class="input-wrap input-v2 noto" style="width:150px;">
                        <input type="text" name="goods_price_sales_0" class="input-v2__input type-percent-discount type-unit type-won" value="{{ isset($goods)?$goods->goods_price_sales_0:0 }}"> 원
                    </div>
                </td>
            </tr>
--}}
            <tr class="table-a__tr">
                <td class="table-a__td type-nobd type-right type-top lh-33 type-grey">판매일자</td>
                <td class="table-a__td type-nobd type-left pd-10">
                    <div class="table-a__inbox type-line type-left">
                        <p class="dp-wrap dp-ib type-able disable-wrap">
                            <input type="text" class="datepicker va-m noto db_right_now_add" name="goods_date_start" id="goods_date_start" value="{{ isset($goods)?$goods->goods_date_start:'' }}" />
                        </p>
                        &nbsp;-&nbsp;
                        <p class="dp-wrap dp-ib type-able disable-wrap">
                            <input type="text" class="datepicker va-m noto db_right_now_add" name="goods_date_end" id="goods_date_end" value="{{ isset($goods)?$goods->goods_date_end:'' }}" />
                        </p>
                    </div>
                    <div class="table-a__inbox ta-l mt-5">
                        <ul class="facility-group__list fl clb">
                            <li class="facility-group__item fl" style="width:100px;">
                                <input type="checkbox" id="allday" class="checkbox-v2 js-days js-type-all" />
                                <label for="allday">전체</label>
                            </li>
                            @php
                                $chkYoil = [];
                                $yoil = ['일요일','월요일','화요일','수요일','목요일','금요일','토요일'];
                                if(isset($goods->goods_days)) $chkYoil = explode(",",$goods->goods_days);
                            @endphp
                            @foreach($yoil as $k => $v)
                            <li class="facility-group__item fl" style="width:100px;">
                                <input type="checkbox" id="yoil_{{$k}}" class="checkbox-v2 js-days js-type-day" name="goods_days[]" value="{{$k}}" {{in_array($k,$chkYoil)?"checked":""}} />
                                <label for="yoil_{{$k}}">{{$v}}</label>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </td>
{{--
                <td class="table-a__td type-nobd type-left pd-10 type-info">
                    판매기간과 요일을 선택하세요.
                </td>
--}}
            </tr>
            <tr class="table-a__tr">
                <td class="table-a__td type-nobd type-right type-top lh-33 type-grey">판매제외일자</td>
                <td class="table-a__td type-nobd type-left pd-10">
                    <div class="table-a__inbox ta-l ">
                        <button type="button" class="btn-v2 type-icon type-add js-add-date">추가</button>
                        <div class="date-list">
                            <ul class="clb date-list__list">
                                @if(isset($except) && sizeof($except)>0)
                                    @foreach($except as $e)
                                    <li class='fl date-list__item clb'>
                                        <input type='text' class='datepicker va-m noto type-remove' name='date_except[]' value='{{$e->date}}' />
                                        <button type='button' class='date-list__remove fr sign-span type-no js-add-remove'></button>
                                    </li>
                                    @endforeach
                                @endif
                            </ul>
                        </div>
                    </div>
                </td>
{{--
                <td class="table-a__td type-nobd type-left pd-10 type-info">
                    판매제외 일자를 등록하세요.
                </td>
--}}
            </tr>
            <tr class="table-a__tr">
                <td class="table-a__td type-nobd type-right type-top lh-33 type-grey">판매여부</td>
                <td class="table-a__td type-nobd type-left pd-10">
                    <input type="radio" id="flag_use_Y" class="radio-v1" name="flag_use" value="Y" {{!isset($goods)||$goods->flag_use=="Y"?"checked":""}} />
                    <label for="flag_use_Y" class="mar20">판매</label>
                    <input type="radio" id="flag_use_N" class="radio-v1" name="flag_use" value="N" {{isset($goods)&&$goods->flag_use=="N"?"checked":""}} />
                    <label for="flag_use_N">판매중지</label>
                </td>
{{--                <td class="table-a__td type-nobd type-left pd-10"></td>--}}
            </tr>
        </table>
    </div>
    <div class="btn-wrap type-mt">
        <button type="submit" class="btn-v4 type-save">저장</button>
        <div class="btn-wrap__inner type-right">
            <a href="http://staff.einet.co.kr/goods" class="btn-v2">목록</a>
            <a href="http://staff.einet.co.kr/goods" class="btn-v2">취소</a>
        </div>
    </div>
    </form>
</div>

<script>
    //판매제외일자 추가
    $(".js-add-date").click(function(){
        var add_box = $(this).closest(".table-a__inbox").find(".date-list__list");
        var input_date = "<li class='fl date-list__item clb'><input type='text' class='datepicker va-m noto type-remove' name='date_except[]' /> <button type='button' class='date-list__remove fr sign-span type-no js-add-remove'></button></li>"

        $(add_box).prepend(input_date);
        pickerReload();

        $(add_box).find("li:first-child input").focus();

    });
    //판매 제외 일자 삭제
    $(document).on("click",".js-add-remove",function(){
        $(this).closest("li").remove();
    });

    $(document).ready(function() {//로드구역
         //셀렉트검색
        $('.js-example-basic-single').select2();

        //요일체크박스
        $("input.js-days").change(function(){
            if($(this).hasClass("js-type-all")){//전체선택일때
                if($(this).prop("checked")){
                     $("input.js-days.js-type-day").prop("checked",true);
                }else{
                     $("input.js-days.js-type-day").prop("checked",false);
                }
            }else{//일반 요일일때
                var day_length = $("input.js-type-day:checked").length;
                if(day_length >= 7){//전체 체크되었을때
                    $("input.js-days.js-type-all").prop("checked",true);
                }else{//그 이하의 갯수 체크
                    $("input.js-days.js-type-all").prop("checked",false);
                }
            }
        });//요일체크박스
    });//로드구역
</script>

@endsection
