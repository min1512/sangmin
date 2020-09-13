@extends("admin.pc.layout.basic")

@section("title")일자별 요금정보@endsection

@section("scripts")
@endsection

@section("styles")
<!--
    <link rel="stylesheet" href="http://staff.einet.co.kr/asset/css/common-b.css?v=<?=time()?>">
<link rel="stylesheet" href="http://staff.einet.co.kr/asset/css/blade.css?v=<?=time() ?>">
-->
@endsection

@section("contents")
    @php
        $curDate      = strtotime($year."-".$month."-".$day);
        $dayPerMonth  = date("t",$curDate);
        $yoilStart    = date("w",strtotime($year."-".$month."-1"));

        $prevMonth    = strtotime("-1 month",$curDate);
        $nextMonth    = strtotime("+1 month",$curDate);
        $today = date("d");
        $listDayName = ["일요일","월요일","화요일","수요일","목요일","금요일","토요일"];
    @endphp

    <div class="b-calendar n-gothic">
                    <form method="post" name="frmCalendarPrice" id="frmCalendarPrice" action="{{ url()->current() }}">
                        {{ csrf_field() }}
							<div class="b-calendar-head">
								<div class="b-calendar-head__month">
									<button type="button" class="b-calendar-head__arrow type-prev va-m" onclick="location.href='{{ url()->current() }}?year={{date("Y",$prevMonth)}}&month={{date("n",$prevMonth)}}'" ></button>
									<span class="va-m">{{ date("Y-m",$curDate) }}</span>
									<button type="button" class="b-calendar-head__arrow type-next va-m" onclick="location.href='{{ url()->current() }}?year={{date("Y",$nextMonth)}}&month={{date("n",$nextMonth)}}'"></button>
								</div>
								<p class="b-calendar-head__today">TODAY : {{ date("Y") }}년 {{ date("m") }}월 {{ date("d") }}일( {{ $listDayName[date("w")] }})</p>
								<div class="ta-r"><button type="submit" class="b-calendar-head__btn btn-v1">변경</button></div>
							</div>
							<div class="b-calendar__wrap type-table">
								<table class="b-calendar__table">
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
										<tr class="b-calendar__tr">
											<th class="b-calendar__th type-sunday">일</th>
											<th class="b-calendar__th">월</th>
											<th class="b-calendar__th">화</th>
											<th class="b-calendar__th">수</th>
											<th class="b-calendar__th">목</th>
											<th class="b-calendar__th">금</th>
											<th class="b-calendar__th type-saturday">토</th>
										</tr>
									</thead>
									<tbody>
                                    <tr class="b-calendar__tr">
                                    @for($i=1,$j=$yoilStart; $i<=$yoilStart; $i++,$j--)
                                        <td class="b-calendar__td"></td>
                                    @endfor
                                    @for($i=1,$y=$yoilStart; $i<=$dayPerMonth; $i++,$y++)
                                    @if($y%7==0&&$y>0)<tr class="b-calendar__tr">@endif
                                        <td class="b-calendar__td {{$y%7==0?"type-sunday":($y%7==6?"type-saturday":"")}}" style="{{date("Y-m-d",strtotime($year."-".$month."-".$i))==date("Y-m-d")?"background:navajowhite;":""}}">
                                            <div class="b-calendar__inbox">
                                                <p class="b-calendar__date">{{$i}}</p>
                                                <div class="b-calendar__inner ">
                                                    <ul class="b-calendar__list">
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
                                                            @endphp
                                                            <li class="b-calendar__item">
                                                                <p class="b-calendar__room">{{ $r->room_name }}</p>
                                                                <input type="hidden" name="price_season[{{date("Y-m-".sprintf("%02d",$i),$curDate)}}][{{$r->id}}]" value="{{ $tmp_key }}" />{{--일자에 해당되는 시즌 ID--}}
                                                                <input type="hidden" name="price_daily[{{date("Y-m-".sprintf("%02d",$i),$curDate)}}][{{$r->id}}]" value="{{ $y%7>0&&$y%7<5?1:$y%7 }}" />{{--일자에 해당되는 요일 ID--}}

                                                                <select name="custom_price_season[{{date("Y-m-".sprintf("%02d",$i),$curDate)}}][{{$r->id}}]" id="season_{{$i}}_{{$r->id}}" class="select-v2 type-calendar">
                                                                    @foreach($season as $s)
                                                                        <option value="{{$s->id}}" {{ isset($price_custom[$i][$r->id])&&$price_custom[$i][$r->id]->season_id==$s->id?"selected":"" }}>{{$s->season_name}}</option>
                                                                    @endforeach
                                                                </select>

                                                                <select name="custom_price_daily[{{date("Y-m-".sprintf("%02d",$i),$curDate)}}][{{$r->id}}]" id="yoil_{{$i}}_{{$r->id}}" class="select-v2 type-calendar">
                                                                    <option value="">::요일::</option>
                                                                    <option value="0" {{ isset($price_custom[$i][$r->id])&&$price_custom[$i][$r->id]->price_day==0?"selected":($y%7==0?"selected":"") }}>일요일</option>
                                                                    <option value="1" {{ isset($price_custom[$i][$r->id])&&$price_custom[$i][$r->id]->price_day==1?"selected":($y%7>0&&$y%7<5?"selected":"") }}>주중</option>
                                                                    <option value="5" {{ isset($price_custom[$i][$r->id])&&$price_custom[$i][$r->id]->price_day==5?"selected":($y%7==5?"selected":"") }}>금요일</option>
                                                                    <option value="6" {{ isset($price_custom[$i][$r->id])&&$price_custom[$i][$r->id]->price_day==6?"selected":($y%7==6?"selected":"") }}>토요일</option>
                                                                </select>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </div>
                                        </td>
                                    @if($y%7==6) </tr> @endif
                                    @endfor
                                    </tbody>
                                </table>
                            </div>
                    </form>
                </div>




{{--    <div style="margin:0 auto; text-align:center; ">--}}
{{--        <a href="{{ url()->current() }}?year={{date("Y",$prevMonth)}}&month={{date("n",$prevMonth)}}">◀</a>--}}
{{--        {{ date("Y-m",$curDate) }}--}}
{{--        <a href="{{ url()->current() }}?year={{date("Y",$nextMonth)}}&month={{date("n",$nextMonth)}}">▶</a>--}}
{{--    </div>--}}
{{--    <form method="post" name="frmCalendarPrice" id="frmCalendarPrice" action="{{ url()->current() }}">--}}
{{--        {{ csrf_field() }}--}}
{{--        <button type="submit">변경</button>--}}
{{--        <table class="calc">--}}
{{--            <thead>--}}
{{--                <th style="border:1px solid #888; ">일</th>--}}
{{--                <th style="border:1px solid #888; ">월</th>--}}
{{--                <th style="border:1px solid #888; ">화</th>--}}
{{--                <th style="border:1px solid #888; ">수</th>--}}
{{--                <th style="border:1px solid #888; ">목</th>--}}
{{--                <th style="border:1px solid #888; ">금</th>--}}
{{--                <th style="border:1px solid #888; ">토</th>--}}
{{--            </thead>--}}
{{--            <tr>--}}
{{--            @for($i=1,$j=$yoilStart; $i<=$yoilStart; $i++,$j--)--}}
{{--                <td style="border:1px solid #888; ">{{"-".$j}}</td>--}}
{{--            @endfor--}}
{{--            @for($i=1,$y=$yoilStart; $i<=$dayPerMonth; $i++,$y++)--}}
{{--                @if($y%7==0) <tr> @endif--}}
{{--                @if($i==$today) <td style="border:1px solid #888; background: navajowhite"> @else <td style="border:1px solid #888; "> @endif--}}
{{--                     {{$i}}--}}
{{--                    @foreach($room as $r)--}}
{{--                        @php--}}
{{--                            if(isset($price_day[$i]) && count($price_day[$i][$r->id][$y%7])>1) {--}}
{{--                                arsort($price_day[$i][$r->id][$y%7]);--}}
{{--                                $tmp_key = key($price_day[$i][$r->id][$y%7]);--}}
{{--                                print_r($price_day[$i][$r->id][$y%7]);--}}
{{--                            }--}}
{{--                            else {--}}
{{--                                $tmp_key = 0;--}}
{{--                            }--}}
{{--                        @endphp--}}
{{--                        <p>--}}
{{--                            {{ $r->room_name }}--}}
{{--                            <input type="hidden" name="price_season[{{date("Y-m-".sprintf("%02d",$i),$curDate)}}][{{$r->id}}]" value="{{ $tmp_key }}" />--}}{{--일자에 해당되는 시즌 ID--}}
{{--                            <input type="hidden" name="price_daily[{{date("Y-m-".sprintf("%02d",$i),$curDate)}}][{{$r->id}}]" value="{{ $y%7>0&&$y%7<5?1:$y%7 }}" />--}}{{--일자에 해당되는 요일 ID--}}
{{--                            <select name="custom_price_season[{{date("Y-m-".sprintf("%02d",$i),$curDate)}}][{{$r->id}}]">--}}
{{--                                @foreach($season as $s)--}}
{{--                                    <option value="{{$s->id}}" {{ isset($price_custom[$i][$r->id])&&$price_custom[$i][$r->id]->season_id==$s->id?"selected":"" }}>{{$s->season_name}}</option>--}}
{{--                                @endforeach--}}
{{--                            </select>--}}
{{--                            <select name="custom_price_daily[{{date("Y-m-".sprintf("%02d",$i),$curDate)}}][{{$r->id}}]">--}}
{{--                                <option value="">::요일::</option>--}}
{{--                                <option value="0" {{ isset($price_custom[$i][$r->id])&&$price_custom[$i][$r->id]->price_day==0?"selected":($y%7==0?"selected":"") }}>일요일</option>--}}
{{--                                <option value="1" {{ isset($price_custom[$i][$r->id])&&$price_custom[$i][$r->id]->price_day==1?"selected":($y%7>0&&$y%7<5?"selected":"") }}>주중</option>--}}
{{--                                <option value="5" {{ isset($price_custom[$i][$r->id])&&$price_custom[$i][$r->id]->price_day==5?"selected":($y%7==5?"selected":"") }}>금요일</option>--}}
{{--                                <option value="6" {{ isset($price_custom[$i][$r->id])&&$price_custom[$i][$r->id]->price_day==6?"selected":($y%7==6?"selected":"") }}>토요일</option>--}}
{{--                            </select>--}}
{{--                        </p>--}}
{{--                    @endforeach--}}
{{--                </td>--}}
{{--                @if($y%7==6) </tr> @endif--}}
{{--            @endfor--}}

{{--            @for($i=$y%7,$k=1; $i<7; $i++,$k++)--}}
{{--                <td style="border:1px solid #888; ">{{"+".$k}}</td>--}}
{{--                @if($i%7==6) </tr> @endif--}}
{{--            @endfor--}}
{{--        </table>--}}
{{--    </form>--}}

@endsection
