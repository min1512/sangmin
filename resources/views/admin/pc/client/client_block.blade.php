@extends("admin.pc.layout.basic")

@section("title")숙박업소관리-방막기@endsection

@section("scripts")
<script>
    $(function () {
        $('#block_tel_show').hide();
        $('#block_tel').click(function () {
            $('#block_tel_show').show();
            $('.button').hide();
            $('.submit2').show();
            $("input[name='all_check[]']").each(function () {
                $("input[name^='custom_price_season["+$(this).val()+"]']").prop("checked",false);
                $(this).prop("checked",false);
            });
            $('.submit2').click(function () {
                var tcnt=0;
                $("input[name^='block_tel_start']").each(function (index) {
                    if (
                        ($("input[name^='block_tel_start']").eq(index).val() > $("input[name^='block_tel_end']").eq(index).val())
                    ) {
                        alert("기간 입력이 잘못 되었습니다");
                        tcnt++;
                    } else if (
                        ($("input[name^='block_tel_start']").eq(index).val() == "" || $("input[name^='block_tel_end']").eq(index).val() == "")
                    ) {
                        alert("기간을 입력해 주세요");
                        tcnt++;
                    }
                });
                var block = $("input:checkbox[name=block]").is(":checked")==false
                var none = $("input:checkbox[name=none]").is(":checked")==false
                var Tel = $("input:checkbox[name=Tel]").is(":checked")==false
                if($("input:checkbox[name^=custom_price_season]:checked").length<1) {
                    alert("1개 이상의 객실을 선택해주세요");
                    tcnt++;
                }else if(block==true && none==true && Tel==true ){
                    alert("기능 선택을 체크 해주세요");
                    tcnt++;
                }

                if(tcnt >0 ){
                    return false;
                }else{
                    return true;
                }
            })
        });

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
            })
        })

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

    });
</script>
@endsection

@section("styles")
@endsection

@section("contents")
    @php
        $curDate      = strtotime($year."-".$month."-".$day);
        $dayPerMonth  = date("t",$curDate);
        $yoilStart    = date("w",strtotime($year."-".$month."-1"));

        $prevMonth    = strtotime("-1 month",$curDate);
        $nextMonth    = strtotime("+1 month",$curDate);
        $now_year = date("Y");
        $now_month = date("m");
        $now = date("d");
    @endphp
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
            <thead>
            <th style="border:1px solid #888; ">일</th>
            <th style="border:1px solid #888; ">월</th>
            <th style="border:1px solid #888; ">화</th>
            <th style="border:1px solid #888; ">수</th>
            <th style="border:1px solid #888; ">목</th>
            <th style="border:1px solid #888; ">금</th>
            <th style="border:1px solid #888; ">토</th>
            </thead>
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
@endsection
