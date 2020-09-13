@extends("admin.pc.layout.basic")

@section("title")숙박업소관리-연박설정@endsection

@section("styles")
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="http://staff.einet.co.kr/asset/css/common-b.css?v=<?=time()?>">
<link rel="stylesheet" href="http://staff.einet.co.kr/asset/css/blade.css?v=<?=time() ?>">
@endsection

@section("scripts")
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
    function callOver(type, id) {
        if(type=="O"){//연박만 받기
            $("div#content .wrap").append($("script#html_over").html());
        }else if(type=="D"){//할인설정
            $("div#content .wrap").append($("script#html_discount").html());
        }
        $.post(
            "{{ route('client.over.call',['id'=>$id]) }}", {
                _token: '{{csrf_token()}}',
                id: id
            },
            function(data) {
                $("input#id").val(data.id);
                $("input#over_start").val(data.over_start);
                $("input#over_end").val(data.over_end);
                var tmp_day = data.target_day;
                if (tmp_day != null) {
                    var tmp_day2 = tmp_day.split(',');
                    $("input[name^='target_day[]']").each(function() {
                        if ($.inArray($(this).val(), tmp_day2) != -1) $(this).prop("checked", true);
                        else $(this).prop("checked", false);
                    });
                }
                $("select#over_day").val(data.over_day);
                var tmp_room = data.room_id;
                if (tmp_room != null) {
                    var tmp_room2 = tmp_room.split(',');
                    $("input[name^='room[]']").each(function() {
                        if ($.inArray($(this).val(), tmp_room2) != -1) $(this).prop("checked", true);
                        else $(this).prop("checked", false);
                    });
                }

                $("input#over_discount_name").val(data.over_discount_name);
                $("input#over_discount_start").val(data.over_discount_start);
                $("input#over_discount_end").val(data.over_discount_end);
                $("select#over_discount_type").val(data.over_discount_type);
                $("input#over_discount_price").val(data.over_discount_price);
                $("select#over_discount_unit").val(data.over_discount_unit);

                pickerReload();
                $(".dim").show();
            }, "json"
        )
    }

    $(function(){
        $(".over_info").click(function(){
            callOver($(this).data("type"),$(this).data("id"));
        });
    })
</script>
@endsection

@section("contents")
{{--@include("admin.pc.include.price.season_search",['search'=>isset($search)?$search:[]])--}}
<div class="table-a noto type-bb">
    <div class="table-a__head clb">
        <p class="table-a__tit fl">연박만 받기 설정</p>
        <div class="table-a_inbox type-head fr">
            <button type="button" class="btn-v1 js-pop-btn js-type-btb" data-over="O">연박만 받기 등록</button>
        </div>
    </div>
    <table class="table-a__table">
        <colgroup>
            <col width="">
            <col width="">
            <col width="">
            <col width="">
            <col width="">
        </colgroup>
        <tr class="table-a__tr type-th">
            <th class="table-a__th">번호</th>
            <th class="table-a__th">객실명</th>
            <th class="table-a__th">연박적용기간</th>
            <th class="table-a__th">연박일수</th>
            <th class="table-a__th">관리</th>
        </tr>
        @foreach($over as $k1 => $o)
        <tr class="table-a__tr type-point js-pop-btn js-type-btb" data-over="O" data-id="{{ $o->id }}">
            <td class="table-a__td">
                <div class="table-a__inbox">
                    <span>{{ $over->total()-($over->currentPage()-1)*$over->perPage()-$k1 }}</span>
                </div>
            </td>
            <td class="table-a__td">
                <div class="table-a__inbox">
                    <span class="type-point type-line">객실01</span>
                </div>
            </td>
            <td class="table-a__td">
                <div class="table-a__inbox">
                    <span class="type-point type-line">{{ $o->over_start }} ~ {{ $o->over_end }}(대상요일 : {{ $o->target_day }})</span>
                </div>
            </td>
            <td class="table-a__td">
                <div class="table-a__inbox">
                    <span class="type-point">{{ $o->over_day }}</span>
                </div>
            </td>
            <td class="table-a__td">
                <div class="table-a__inbox">
                    <button type="button" class="table-a__btn type-info btn-v2 over_info" data-type="O" data-id="{{$o->id}}">정보</button>
                    <button type="button" class="table-a__btn type-info btn-v2" data-type="O" data-id="{{$o->id}}">삭제</button>
                </div>
            </td>
        </tr>
        @endforeach
    </table>
    <div class="btn-wrap type-fg">
{{--        <button type="button" class="btn-v4 type-save">저장</button>--}}
        <button type="button" class="btn-v1 status-rb js-pop-btn js-type-btb" data-over="O">연박만 받기 등록</button>
        {{ $over->appends(['over'=>$over->currentPage(), 'discount'=>$discount->currentPage()])->links('admin.pc.pagination.default') }}
    </div>
</div>

<div class="table-a noto mt-50">
    <div class="table-a__head clb">
        <p class="table-a__tit fl">연박 할인 설정</p>
        <div class="table-a_inbox type-head fr">
            <button type="button" class="btn-v1 js-pop-btn js-type-sale" data-over="D">연박 할인 등록</button>
        </div>
    </div>
    <table class="table-a__table">
        <colgroup>
            <col width="">
            <col width="">
            <col width="">
            <col width="">
            <col width="">
        </colgroup>
        <tr class="table-a__tr type-th">
            <th class="table-a__th">번호</th>
            <th class="table-a__th">객실명</th>
            <th class="table-a__th">예약기간</th>
            <th class="table-a__th">연박적용기간</th>
            <th class="table-a__th">연박일수</th>
            <th class="table-a__th">관리</th>
        </tr>
        @foreach($discount as $k2 => $d)
        <tr class="table-a__tr type-point js-pop-btn js-type-sale" data-over="D" data-id="{{ $d->id }}">
            <td class="table-a__td">
                <div class="table-a__inbox">
                    <span>{{ $discount->total()-($discount->currentPage()-1)*$discount->perPage()-$k2 }}</span>
                </div>
            </td>
            <td class="table-a__td">
                <div class="table-a__inbox">
                    <span class="type-point type-line">{{ $d->over_discount_name }}</span>
                </div>
            </td>
            <td class="table-a__td">
                <div class="table-a__inbox">
                    <span class="type-point type-line">{{ $d->over_discount_start }} ~ {{ $d->over_discount_end }}</span>
                </div>
            </td>
            <td class="table-a__td">
                <div class="table-a__inbox">
                    <span class="type-point type-line">{{ $d->over_start }} ~ {{ $d->over_end }}(대상요일 : {{ $d->target_day }})</span>
                </div>
            </td>
            <td class="table-a__td">
                <div class="table-a__inbox">
                    <span class="type-point">{{ $d->over_day }}</span>
                </div>
            </td>
            <td class="table-a__td">
                <div class="table-a__inbox">
                    <button type="button" class="table-a__btn type-info btn-v2 over_info" data-type="D" data-id="{{$d->id}}">정보</button>
                    <button type="button" class="table-a__btn type-info btn-v2" data-type="D" data-id="{{$d->id}}">삭제</button>
                </div>
            </td>
        </tr>
        @endforeach
    </table>
    <div class="btn-wrap type-fg">
{{--        <button type="button" class="btn-v4 type-save">저장</button>--}}
        <button type="button" class="btn-v1 status-rb js-pop-btn js-type-sale" data-over="D">연박 할인 등록</button>
        {{ $discount->appends(['over'=>$over->currentPage(), 'discount'=>$discount->currentPage()])->links('admin.pc.pagination.default') }}
    </div>

</div>

<!--팝업 1-->
<script type=text/template id="html_over">
    <form method="post" name="frmOver" action="{{route('client.over',['id'=>$id])}}">
        {{csrf_field()}}
        <input type="hidden" name="over_type" value="O" />
        <input type="hidden" name="id" id="id" value="" />
        <div class="pop-module js-pop js-pop-btb">
            <div class="pop-module__wrap">
                <div class="pop-module__box">
                    <div class="pop-module__inbox" style="width:746px;">
                        <div class="pop-module__head clb">
                            <span class="pop-module__tit fl">연박 등록하기</span>
                            <span class="pop-module__close fr">닫기</span>
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
                                            <span class="lh-33">기간 선택</span>
                                        </td>
                                        <td class="table-a__td type-nobd type-pop type-left">
                                            <div class="input-wrap" >
                                                <ul class="dateinputs-wrap">
                                                    <li class="dateinput fl"><input type="text" name="over_start" id="over_start" class="datepicker va-m noto" style="width:150px;"></li>
                                                    <li class="dateinput fl"><input type="text" name="over_end" id="over_end" class="datepicker va-m noto" style="width:150px;"></li>
                                                </ul>

                                            </div>
                                            <div class="checkbox-fl">
                                            <ul class="checkbox-fl__list clb">
                                                @php $yoil = ["일요일","월요일","화요일","수요일","목요일","금요일","토요일"]; @endphp
                                                @for($i=0; $i<7; $i++)
                                                <li class="checkbox-fl__item fl">
                                                    <input type="checkbox" name="target_day[]" id="days_{{$i}}" class="checkbox-v2" value="{{$i}}" />
                                                    <label for="days_{{$i}}">{{$yoil[$i]}}</label>
                                                </li>
                                                @endfor
                                            </ul>
                                        </div>
                                        </td>
                                    </tr>
                                    <tr class="table-a__tr">
                                        <td class="table-a__td type-nobd type-right  type-pop">
                                            <span class="">연박 일수</span>
                                        </td>
                                        <td class="table-a__td type-nobd type-left pd-r-50 type-pop">
                                            <span class="c-777">위 기간동안</span>
                                            <div class="select-wrap dp-ib" style="width:75px;">
                                                <select name="over_day" id="over_day" class="select-v1 noto">
                                                    @for($i=1; $i<10; $i++)
                                                    <option value="{{$i}}">{{$i}}</option>
                                                    @endfor
                                                </select>
                                            </div>
                                            <span class="c-777">이상만 숙박가능</span>
                                        </td>
                                    </tr>

                                    <tr class="table-a__tr">
                                        <td class="table-a__td type-nobd type-right type-top  type-pop">
                                            <span>객실 선택</span>
                                        </td>
                                        <td class="table-a__td type-nobd type-left pd-r-50 type-pop">
                                            <p>
                                                <input type="checkbox" id="chk5-1" class="checkbox-v2" name="allCheckRoom" />
                                                <label for="chk5-1">모두선택</label>
                                            </p>
                                            <div class="rchoice-group clb">
                                                <ul class="rchoice-group__list clb">
                                                    @foreach($room as $r)
                                                    <li class="rchoice-group__item fl">
                                                        <input type="checkbox" id="chk5-{{$r->id}}" class="checkbox-v2" name="room[]" value="{{$r->id}}" />
                                                        <label for="chk5-{{$r->id}}">{{$r->room_name}}</label>
                                                    </li>
                                                    @endforeach
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
                    </div>
                </div>
            </div>
        </div>
    </form>
</script>
<!--  팝업2 -->
<script type=text/template id="html_discount">
    <form method="post" name="frmOver" action="{{route('client.over',['id'=>$id])}}">
        {{csrf_field()}}
        <input type="hidden" name="over_type" value="D" />
        <input type="hidden" name="id" id="id" value="" />
        <div class="pop-module js-pop js-pop-sale">
            <div class="pop-module__wrap">
                <div class="pop-module__box">
                    <div class="pop-module__inbox" style="width:746px;">
                        <div class="pop-module__head clb">
                            <span class="pop-module__tit fl">연박 할인 등록하기</span>
                            <span class="pop-module__close fr">닫기</span>
                        </div>
                        <div class="pop-module__body">
                            <div class="table-a noto">
                                <table class="table-a__table type-top">
                                    <colgroup>
                                        <col width="120px">
                                        <col width="">
                                    </colgroup>
                                    <tr class="table-a__tr">
                                        <td class="table-a__td type-nobd type-right  type-pop"><span>할인명</span></td>
                                        <td class="table-a__td type-nobd type-left pd-r-50 type-pop">
                                            <div class="input-wrap" style="width:150px;">
                                                <input type="text" name="over_discount_name" id="over_discount_name" class="input-v1">
                                            </div>
                                        </td>
                                    </tr>
                                    <tr class="table-a__tr">
                                        <td class="table-a__td type-nobd type-right type-top  type-pop">
                                        <span class="lh-33">예약기간</span>
                                        </td>
                                        <td class="table-a__td type-nobd type-pop type-left">
                                            <div class="input-wrap" >
                                                <ul class="dateinputs-wrap">
                                                    <li class="dateinput fl"><input type="text" name="over_discount_start" id="over_discount_start" class="datepicker va-m noto" style="width:150px;"></li>
                                                    <li class="dateinput fl"><input type="text" name="over_discount_end" id="over_discount_end" class="datepicker va-m noto" style="width:150px;"></li>
                                                </ul>

                                            </div>
                                        </td>
                                    </tr>
                                    <tr class="table-a__tr">
                                        <td class="table-a__td type-nobd type-right type-top  type-pop">
                                            <span class="lh-33">할인 적용기간</span>
                                        </td>
                                        <td class="table-a__td type-nobd type-pop type-left">
                                            <div class="input-wrap" >
                                                <ul class="dateinputs-wrap">
                                                    <li class="dateinput fl"><input type="text" name="over_start" id="over_start" class="datepicker va-m noto" style="width:150px;"></li>
                                                    <li class="dateinput fl"><input type="text" name="over_end" id="over_end" class="datepicker va-m noto" style="width:150px;"></li>
                                                </ul>

                                            </div>
                                            <div class="checkbox-fl mt-5">
                                            <ul class="checkbox-fl__list clb">
                                                @php $yoil = ["일요일","월요일","화요일","수요일","목요일","금요일","토요일"]; @endphp
                                                @for($i=0; $i<7; $i++)
                                                    <li class="checkbox-fl__item fl">
                                                        <input type="checkbox" name="target_day[]" id="days_{{$i}}" class="checkbox-v2" value="{{$i}}" />
                                                        <label for="days_{{$i}}">{{$yoil[$i]}}</label>
                                                    </li>
                                                @endfor
                                            </ul>
                                        </div>
                                        </td>
                                    </tr>
                                    <tr class="table-a__tr">
                                        <td class="table-a__td type-nobd type-right  type-pop">
                                            <span>할인내용</span>

                                        </td>
                                        <td class="table-a__td type-nobd type-left pd-r-50 type-pop">
                                            <div class="select-wrap dp-ib" style="width:125px;">
                                                <select name="over_discount_type" id="over_discount_type" class="select-v1 noto"  >
                                                    <option value="ALL">총 객실가</option>
                                                    <option value="PER">객실가(박)</option>
                                                </select>
                                            </div><div class="input-wrap dp-ib ml-10" style="width:125px;">
                                                <input type="text" name="over_discount_price" id="over_discount_price" class="input-v1">
                                            </div>
                                            <div class="select-wrap dp-ib" style="width:64px;">
                                                <select name="over_discount_unit" id="over_discount_unit" class="select-v1 noto"  >
                                                    <option value="원">원</option>
                                                    <option value="%">%</option>
                                                </select>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr class="table-a__tr">
                                        <td class="table-a__td type-nobd type-right  type-pop">
                                            <span class="">연박 일수</span>

                                        </td>
                                        <td class="table-a__td type-nobd type-left pd-r-50 type-pop">
                                            <span class="c-777">위 기간동안</span>
                                            <div class="select-wrap dp-ib" style="width:75px;">
                                                <select name="over_day" id="over_day" class="select-v1 noto"  >
                                                    <option value="1">1</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                    <option value="4">4</option>
                                                    <option value="5">5</option>
                                                </select>
                                            </div>
                                            <span class="c-777">이상만 숙박가능</span>
                                        </td>
                                    </tr>

                                    <tr class="table-a__tr">
                                        <td class="table-a__td type-nobd type-right type-top  type-pop">
                                            <span>객실 선택</span>
                                        </td>
                                        <td class="table-a__td type-nobd type-left pd-r-50 type-pop">
                                            <p>
                                                <input type="checkbox" id="chk5-1" class="checkbox-v2" name="">
                                                <label for="chk5-1">모두선택</label>
                                            </p>
                                            <div class="rchoice-group clb">
                                                <ul class="rchoice-group__list clb">
                                                    @foreach($room as $r)
                                                        <li class="rchoice-group__item fl">
                                                            <input type="checkbox" id="chk5-{{$r->id}}" class="checkbox-v2" name="room[]" value="{{$r->id}}" />
                                                            <label for="chk5-{{$r->id}}">{{$r->room_name}}</label>
                                                        </li>
                                                    @endforeach
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
                    </div>
                </div>
            </div>
        </div>
    </form>
</script>

<script>
    $(document).ready(function(){
        $("button.js-pop-btn").click(function(){
            $(".pop-module.js-pop").remove();
            if($(this).data("over")=="O"){//연박만 받기
                callOver('O',$(this).data("id"));
            }else if($(this).data("over")=="D"){//할인설정
                callOver('D',$(this).data("id"));
            }
        });
    });

    $(document).on("click",".pop-module__close",function(){
        $(".pop-module.js-pop").remove();
        $(".dim").fadeOut(300);
    });
    $(document).on("click",".pop-module__inbox",function(){
        //e.stopPropagation();
    });

    $(document).on("click","input[type=checkbox][name=allCheckRoom]",function(){
        $("input[name='room[]']").prop("checked",$(this).prop("checked"));
    });

</script>

@endsection
