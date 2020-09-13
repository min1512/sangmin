@extends("admin.pc.layout.basic")

@section("title")숙박업소관리-방막기@endsection

@section("scripts")
<script>
    $(function () {
        $("input[name='all_check[]']").click(function () {

            if($(this).prop("checked")===true){
                $("input[name^='custom_price_season["+$(this).val()+"]']").prop("checked",true);
                $('.button').show();
                $("input[name='block']").focus();
                $('#block_tel_show').hide();
                $('.submit2').hide();
            }else{
                $("input[name^='custom_price_season["+$(this).val()+"]']").prop("checked",false);
                $('.button').hide();
            }

        });

        $(function () {
            $("#no_block_tel_add").click(function () {
                $(this).parent().append("<p><input type='date' name='no_block_tel[]' /></p>");
            });

            $("button.r-calendar-head__arrow").click(function(){
                goUrl("{{ url()->current() }}?year="+$(this).data("year")+"&month="+$(this).data("month"));
            });
        });

        @foreach($room as $r)
            $("input[name='block_tel_all_check']").click(function () {
                if($(this).prop("checked")==true){
                    $("input[name^='custom_price_season[{{$r->id}}]']").prop("checked",true);
                }else{
                    $("input[name^='custom_price_season[{{$r->id}}]']").prop("checked",false);
                }
            });
        @endforeach

        var block_tel_start = $('block_tel_start').val();
        if(block_tel_start != ""){
            $('.button').hide();
        }

        $("button#btn_pop").click(function(){
            $("div.pop-module").show();
            $(".dim").show();
        });

        $(".pop-module__close").click(function(){
            $("div.pop-module").hide();
            $(".dim").hide();
        })
    });
</script>
@endsection

@section("styles")
<link rel="stylesheet" href="http://staff.einet.co.kr/asset/css/common-b.css?v=<?=time()?>">
<link rel="stylesheet" href="http://staff.einet.co.kr/asset/css/blade.css?v=<?=time() ?>">
@endsection

@section("contents")
    @php
        $curDate      = strtotime($year."-".$month."-1");
        $dayPerMonth  = date("t",$curDate);
        $yoilStart    = date("w",$curDate);

        $prevMonth    = strtotime("-1 month",$curDate);
        $nextMonth    = strtotime("+1 month",$curDate);
        $now_year = date("Y");
        $now_month = date("m");
        $now = date("d");

        $yoil_name = ["일","월","화","수","목","금","토"];
    @endphp

    <div class="r-calendar n-gothic">
        <form method="post" name="frmCalendarPrice" id="frmCalendarPrice" action="{{url()->current()}}">
        {{csrf_field()}}
        <div class="r-calendar-head">
            <div class="r-calendar-head__month">
                <button type="button" class="r-calendar-head__arrow type-prev va-m" data-year="{{date("Y",$prevMonth)}}" data-month="{{date("n",$prevMonth)}}"></button>
                <span class="va-m">{{ date("Y년 n월",$curDate) }}</span>
                <button type="button" class="r-calendar-head__arrow type-next va-m" data-year="{{date("Y",$nextMonth)}}" data-month="{{date("n",$nextMonth)}}"></button>
            </div>
            <p class="r-calendar-head__today">TODAY : {{ date("Y년 m월 d일(".$yoil_name[$yoilStart].")") }}</p>
            <div class="clb">
                <button type="button" class="r-calendar-head__btn btn-v2 fl" id="btn_pop">기간 지정 방막기</button>
                <button type="submit" class="r-calendar-head__btn btn-v1 fr">선택된 룸 변경하기</button>
            </div>
        </div>
        <div class="r-calendar__wrap type-table">
            <table class="r-calendar__table">
                <colgroup>
                    <col width="14%">
                    <col width="14%">
                    <col width="14%">
                    <col width="14%">
                    <col width="14%">
                    <col width="14%">
                    <col width="14%">
                </colgroup>
                <thead>
                <tr class="r-calendar__tr">
                    <th class="r-calendar__th type-sunday">일</th>
                    <th class="r-calendar__th">월</th>
                    <th class="r-calendar__th">화</th>
                    <th class="r-calendar__th">수</th>
                    <th class="r-calendar__th">목</th>
                    <th class="r-calendar__th">금</th>
                    <th class="r-calendar__th type-saturday">토</th>
                </tr>
                </thead>
                <tr>

                <tr class="r-calendar__tr">
                    @for($i=1,$j=$yoilStart; $i<=$yoilStart; $i++,$j--)
                    <td class="r-calendar__td {{$i==1?"type-sunday":($i==7?"type-saturday":"")}} type-end">
                        <div class="r-calendar__inbox">
                            <p class="r-calendar__date">{{date("d",strtotime("-".$j." days",strtotime($year."-".$month."-1")))}}</p>
                            <div class="r-calendar__inner type-end">
                                <span>마감</span>
                            </div>
                        </div>
                    </td>
                    @endfor
                    @for($i=1,$y=$yoilStart; $i<=$dayPerMonth; $i++,$y++)
                        {{--줄바꾸기--}}
                        @if($y%7==0) <tr class="r-calendar__tr"> @endif
                        @php if($i==$now && $now_month==date("m",$curDate) && $now_year==date("Y",$curDate)) $is_active = "is-active"; else $is_active = ""; @endphp
                        @if(date("Ymd",strtotime("+".($i-1)." days",$curDate))<date("Ymd"))
                        <td class="r-calendar__td {{$y%7==0?"type-sunday":($y%7==6?"type-saturday":"")}} type-end">
                            <div class="r-calendar__inbox">
                                <p class="r-calendar__date">{{$i}}</p>
                                <div class="r-calendar__inner type-end">
                                    <span>마감</span>
                                </div>
                            </div>
                        </td>
                        @else
                        <td class="r-calendar__td {{$is_active}} {{$y%7==0?"type-sunday":($y%7==6?"type-saturday":"")}}">
                            <div class="r-calendar__inbox">
                                <p class="r-calendar__date">{{$i}}</p>
                                <p class="r-calendar__allchk">
                                    <input type="checkbox" name="all_check[]" id="all_check_{{$i}}" class="checkbox-v3" /><label for="all_check_{{$i}}" class="c-999">전체선택</label>
                                </p>
                                <div class="r-calendar__inner">
                                    <ul class="block-room__list">
                                        @foreach($room as $r)
                                            @php
                                            if(isset($price_day[$i]) && count($price_day[$i][$r->id][$y%7])>1) {
                                                arsort($price_day[$i][$r->id][$y%7]);
                                                $tmp_key = key($price_day[$i][$r->id][$y%7]);
                                                print_r($price_day[$i][$r->id][$y%7]);
                                            }
                                            else {
                                                $tmp_key = 0;
                                            }
                                            $flag = \App\Models\BlockTable::where('day',date("Y-m-".sprintf("%20d",$i),$curDate))->where('room_id',$r->id)->first();
                                            if(isset($flag)) $flags = $flag->flag;
                                            @endphp
                                            <li class="clb block-room__item">
                                                <span class="fl block-room__name">{{$r->room_name}}</span>
                                                <span class="fr">
                                                    <input type="checkbox" name="custom_price_season[{{date("Y-m-".sprintf("%02d",$i), $curDate)}}][{{$r->id}}]" id="custom_price_season_{{date("Y-m-".sprintf("%02d",$i), $curDate)}}_{{$r->id}}" class="checkbox-v3">
                                                    <label for="custom_price_season_{{date("Y-m-".sprintf("%02d",$i), $curDate)}}_{{$r->id}}" class="{{!isset($flag)?"c-blue":($flag=="B"?"c-red":"c-green")}}">{{!isset($flag)?"방열기":($flag=="B"?"방막기":"전화문의")}}</label>
                                                </span>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </td>
                        @endif
                        @if($y%7==6) </tr> @endif
                    @endfor

                    @for($i=$y%7,$k=1; $i<7; $i++,$k++)
                        <td class="r-calendar__td {{$i==1?"type-sunday":($i==6?"type-saturday":"")}} type-end">
                            <div class="r-calendar__inbox">
                                <p class="r-calendar__date">{{date("d",strtotime("+".$k." days",strtotime($year."-".$month."-".$dayPerMonth)))}}</p>
                                <div class="r-calendar__inner type-end">
                                    <span>{{$k}}</span>
                                </div>
                            </div>
                        </td>
                        @if($i%7==6) </tr> @endif
                    @endfor
                </tbody>
            </table>
        </div>
        </form>
    </div>






{{--
    <div style="margin:0 auto; text-align:center; ">
        <a href="{{ url()->current() }}?year={{date("Y",$prevMonth)}}&month={{date("n",$prevMonth)}}">◀</a>
        {{ date("Y-m",$curDate) }}
        <a href="{{ url()->current() }}?year={{date("Y",$nextMonth)}}&month={{date("n",$nextMonth)}}">▶</a>
    </div>
    <form method="post" name="frmCalendarPrice" id="frmCalendarPrice" action="{{ url()->current() }}">
        {{ csrf_field() }}
        <a id='block_tel' class="mr-2 btn btn-focus">기간지정방막기/전화</a>
        <div id="block_tel_show">
            <div>기간 선택</div>
            <div><input type="date" name="block_tel_start">~<input type="date" name="block_tel_end"></div>
            <div>제외 날짜</div>
            <div><input type="date" name="no_block_tel[]"><a id="no_block_tel_add">추가</a></div>
            <div>기능 선택</div>
            <div>
                <input type="checkbox" name="block" value="B"><a class="mr-2 btn btn-focus">방막기</a>
                <input type="checkbox" name="none" value="N"><a class="mr-2 btn btn-focus">방열기</a>
                <input type="checkbox" name="Tel" value="T"><a class="mr-2 btn btn-focus">전화 문의</a>
            </div>
            <div>객실선택</div>
            <div><input type="checkbox" name="block_tel_all_check"> 전체 선택 </div>
            @foreach($room as $r)
                <div><input type="checkbox" name="custom_price_season[{{$r->id}}]">{{ $r->room_name }}</div>
            @endforeach
        </div>
        <table class="calc">
            <tr>
            @for($i=1,$j=$yoilStart; $i<=$yoilStart; $i++,$j--)
                <td style="border:1px solid #888; ">{{"-".$j}}</td>
            @endfor
            @for($i=1,$y=$yoilStart; $i<=$dayPerMonth; $i++,$y++)
                @if($y%7==0) <tr> @endif
                    @if($i==$now && $now_month==date("m",$curDate) && $now_year==date("Y",$curDate))
                        <td style="border:1px solid #888; background: navajowhite">
                    @else
                        <td style="border:1px solid #888; ">
                    @endif
                        {{$i}}
                        <input type="checkbox" name="all_check[]" value="{{date("Y-m-".sprintf("%02d",$i),$curDate)}}" />
                        @foreach($room as $r)
                            @php
                                if(isset($price_day[$i]) && count($price_day[$i][$r->id][$y%7])>1) {
                                    arsort($price_day[$i][$r->id][$y%7]);
                                    $tmp_key = key($price_day[$i][$r->id][$y%7]);
                                    print_r($price_day[$i][$r->id][$y%7]);
                                }
                                else {
                                    $tmp_key = 0;
                                }
                                $flag = \App\Models\BlockTable::where('day',date("Y-m-".sprintf("%02d",$i),$curDate))->where('room_id',$r->id)->first();
                                if (isset($flag)){
                                    $flags = $flag->flag;
                                }
                            @endphp
                            <p>
                                @if(isset($flag))
                                    <input type="checkbox" name="custom_price_season[{{date("Y-m-".sprintf("%02d",$i),$curDate)}}][{{$r->id}}]">
                                    @if($flags=="B")
                                        <p style="color: green">방막기</p>
                                    @elseif($flags=="T")
                                        <p style="color: brown">전화문의</p>
                                    @endif
                                    {{ $r->room_name }}
                                @else
                                    <input type="checkbox" name="custom_price_season[{{date("Y-m-".sprintf("%02d",$i),$curDate)}}][{{$r->id}}]">
                                    <p style="color: gray">방열기</p>
                                    {{ $r->room_name }}
                                @endif
                            </p>
                            <script>
                                $("input[name^='custom_price_season[{{date("Y-m-".sprintf("%02d",$i),$curDate)}}][{{$r->id}}]']").click(function () {

                                    if($(this).is(":checked")==true){
                                        console.log("show");
                                        $('.button').show();
                                        $("input[name='block']").focus();
                                        $('#block_tel_show').hide();
                                    }else{
                                        console.log("hide");
                                        $('.button').hide();
                                    }

                                })
                            </script>
                        @endforeach
                    </td>
                    @if($y%7==6) </tr> @endif
            @endfor

            @for($i=$y%7,$k=1; $i<7; $i++,$k++)
                <td style="border:1px solid #888; ">{{"+".$k}}</td>
                @if($i%7==6) </tr> @endif
            @endfor
        </table>
        <div class="button">
            <input type="checkbox" name="block" value="B"><a class="mr-2 btn btn-focus">방막기</a>
            <input type="checkbox" name="none" value="N"><a class="mr-2 btn btn-focus">방열기</a>
            <input type="checkbox" name="Tel" value="T"><a class="mr-2 btn btn-focus">전화 문의</a>
            <button type="submit" class="mr-2 btn btn-focus submit1">변경</button>
        </div>
        <button type="submit" class="mr-2 btn btn-focus submit2">변경</button>
    </form>
--}}

    <div class="pop-module n-gothic" style="display:none; ">
		<div class="pop-module__wrap">
			<div class="pop-module__box">
				<div class="pop-module__inbox" style="width:746px;">
					<div class="pop-module__head clb">
						<span class="pop-module__tit fl">기간지정방막기</span>
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
									<td class="table-a__td type-nobd type-right type-top pd-l-50 type-pop">
										<span class="">기간 선택</span>
									</td>
									<td class="table-a__td type-nobd type-pop type-left">
										<div class="input-wrap" >
											<div class="input-wrap" >
                                                <ul class="dateinputs-wrap">
                                                    <li class="dateinput fl"><input type="text" name="block_tel_start" id="over_discount_start" class="datepicker va-m noto" style="width:150px;" /></li>
                                                    <li class="dateinput fl"><input type="text" name="block_tel_end" id="over_discount_end" class="datepicker va-m noto" style="width:150px;" /></li>
                                                </ul>
                                            </div>
										</div>
									</td>
								</tr>
								<tr class="table-a__tr">
									<td class="table-a__td type-nobd type-right pd-l-50 type-pop">
										<p class="lh-28">제외날짜</p>
										<button type="button" class="btn-v2 type-icon type-add">추가 </button>

									</td>
									<td class="table-a__td type-nobd type-left pd-r-50 type-pop fs-0" id="except_add">
										<div class="input-wrap dp-b" >
											<div class="input-wrap" >
                                                <ul class="dateinputs-wrap mr-5">
                                                    <li class="dateinput fl"><input type="text" name="no_block_tel[]" class="datepicker va-m noto" style="width:150px;" /></li>
                                                </ul>
                                            </div>
											<input type="checkbox" name="chkdate" id="chkdate" class="checkbox-v2"><label for="chkdate">삭제</label>
										</div>
										<div class="input-wrap dp-b mt-5" >
											<div class="input-wrap" >
                                                <ul class="dateinputs-wrap mr-5">
                                                    <li class="dateinput fl"><input type="text" name="over_discount_start" id="over_discount_start" class="datepicker va-m noto" style="width:150px;"></li>
                                                </ul>
                                            </div>
											<input type="checkbox" name="chkdate-1" id="chkdate-1" class="checkbox-v2"><label for="chkdate-1">삭제</label>
										</div>
									</td>
								</tr>
								<tr class="table-a__tr">
									<td class="table-a__td type-nobd type-right pd-l-50 type-pop">
										기능 선택
									</td>
                                    <td class="table-a__td type-nobd type-left type-pop">
                                        <ul class="block-chk__list">
                                            <li class="block-chk__item">
                                                <input type="radio" name="block" id="open" class="radio-v1"><label for="open" class="c-blue n-gothic">방열기</label>
                                            </li>
                                            <li class="block-chk__item">
                                                <input type="radio" name="none" id="close" class="radio-v1"><label for="close" class="c-red n-gothic">방막기</label>
                                            </li>
                                            <li class="block-chk__item">
                                                <input type="radio" name="Tel" id="call" class="radio-v1"><label for="call" class="c-green n-gothic">전화문의</label>
                                            </li>
                                        </ul>
                                    </td>
                                </tr>
								<tr class="table-a__tr">
									<td class="table-a__td type-nobd type-right type-top pd-l-50 type-pop">
										<span>객실 선택</span>
									</td>
									<td class="table-a__td type-nobd type-left pd-r-50 type-pop">
										<p>
											<input type="checkbox" id="check_all" class="checkbox-v2" />
											<label for="check_all">모두선택</label>
										</p>
										<div class="rchoice-group clb">
											<ul class="rchoice-group__list clb">
                                                @foreach($room as $r)
												<li class="rchoice-group__item fl">
													<input type="checkbox" name="custom_price_season[{{$r->id}}]" id="custom_price_season_{{$r->id}}" class="checkbox-v2" />
													<label for="custom_price_season_{{$r->id}}">{{$r->room_name}}</label>
												</li>
                                                @endforeach
											</ul>
										</div>
									</td>
								</tr>
							</table>
						</div>
						<div class="btn-wrap mt-10">
							<button type="button" class="btn-v4 type-save">저장</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection


