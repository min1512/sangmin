@extends("admin.pc.layout.basic")

@section("title")현황관리@endsection

@section("scripts")
    <script src="http://staff.einet.co.kr/asset/js/jquery.matchHeight-min.js"></script>
    <script>
        var yoil = ['일','월','화','수','목','금','토'];
    </script>
@endsection

@section("styles")
@endsection

@section("contents")

<div class="monthly-room">
    <div class="table-a__head clb">
        <p class="table-a__tit fl">월별 객실현황</p>
        <div class="table-a_inbox type-head fr">
            <div class="room-label">
                <span class="room-label__item type-able">예약가능</span>
                <span class="room-label__item type-wait">예약대기</span>
                <span class="room-label__item type-reserved">예약완료</span>
                <span class="room-label__item type-phone">전화문의</span>
            </div>
        </div>
    </div>
    <div class="clb">
        <div class="monthly-room__left fl js-height">
            <div class="monthly-room__head type-month">{{date("Y.m",strtotime($date['start']))}}</div>
            <div class="monthly-room__cont type-left">
                <ul class="monthly-room__list">
                    @foreach($rooms as $k => $r)
                    <li class="monthly-room__item type-left ellipsis">{{$r->room_name}}</li>
                    @endforeach
                </ul>
            </div>
        </div>
        <button type="button" class="monthly-btn type-prev fl js-height js-days-btn" data-date="{{strtotime($date['start'])}}">이전날</button>
        <div class="monthly-days fl js-height">
            <ul class="monthly-days__list clb js-days-box">
                @for($dt=strtotime($date['start']); $dt<=strtotime($date['end']); $dt+=86400)
                <li class="monthly-days__item">
                    <div class="monthly-room__head type-date">
                        <p class="va-m">{{date("d",$dt)=="01"?date("m.d",$dt):date("d",$dt)}}<br>{{$yoil[date("w",$dt)]}}</p>
                    </div>
                    <div class="monthly-room__cont type-days">
                        <ul class="monthly-room__list">
                            @foreach($rooms as $k => $v)
                                @if(isset($order[date("Y-m-d",$dt)][$v->id])&&$order[date("Y-m-d",$dt)][$v->id]['name']!="")
                                    <li class="monthly-room__item type-days type-reserved js-hover-btn"
                                        data-reserve_checkin="{{date("m.d",strtotime($order[date("Y-m-d",$dt)][$v->id]['over_start']))}}"
                                        data-reserve_checkout="{{date("m.d",strtotime("+1 days",strtotime($order[date("Y-m-d",$dt)][$v->id]['over_end'])))}}"
                                        data-reserve_name="{{$order[date("Y-m-d",$dt)][$v->id]['name']}}"
                                        data-reserve_hp="{{$order[date("Y-m-d",$dt)][$v->id]['hp']}}"
                                        data-price_reserve="{{$order[date("Y-m-d",$dt)][$v->id]['price_reserve']}}"
                                        data-price_charge="{{$order[date("Y-m-d",$dt)][$v->id]['price_charge']}}"
                                        data-price_scene="{{$order[date("Y-m-d",$dt)][$v->id]['price_scene']}}"
                                    >
                                        <div class="monthly-room__state">{{$order[date("Y-m-d",$dt)][$v->id]['name']}}</div>
                                    </li>
                                @else
                                    <li class="monthly-room__item type-days type-able">
                                        <div class="monthly-room__state"></div>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                </li>
                @endfor

            </ul>
            <!-- 호버박스 -->
        </div>
        <button type="button" class="monthly-btn type-next fl js-height js-days-btn" data-date_prev="0" data-date="{{date("Y-m-d",strtotime("+1 days",strtotime($date['end'])))}}">다음날</button>

        <div class="monthly-box noto js-hover-btn-box" id="box_hover">
            <div class="monthly-box__wrap">
                <ul class="monthly-box__list">
                    <li class="monthly-box__item type-date clb">
                        <div class="monthly-box__inner type-date type-left fl">
                            <p class="monthly-box__name type-date">체크인</p>
                            <p class="monthly-box__val type-date" id="pop_date_checkin">09.05</p>
                        </div>
                        <div class="monthly-box__inner type-date type-right fl">
                            <p class="monthly-box__name type-date">체크아웃</p>
                            <p class="monthly-box__val type-date" id="pop_date_checkout">09.11</p>
                        </div>
                        <span class="monthly-box__days">1박</span>
                    </li>
                    <li class="monthly-box__item type-customer">
                        <ol class="monthly-customer__list">
                            <li class="monthly-customer__item">
                                <span class="monthly-box__name type-customer">예약자</span><span class="monthly-box__val type-customer" id="pop_reserve_name">홍길동</span>
                            </li>
                            <li class="monthly-customer__item">
                                <span class="monthly-box__name type-customer">연락처</span><span class="monthly-box__val type-customer" id="pop_reserve_hp">010-1234-1354</span>
                            </li>
                        </ol>
                        <div class="monthly-box__inner type-customer monthly-price">
                            <ol class="monthly-price__list">
                                <li class="monthly-price__item clb">
                                    <span class="fl monthly-box__val type-price">예약금액</span>
                                    <span class="fr monthly-box__val type-price"><span class="monthly-box__span type-point" id="pop_price_reserve">600,000</span> 원</span>
                                </li>
                                <li class="monthly-price__item clb">
                                    <span class="fl monthly-box__val type-price">결제금액</span>
                                    <span class="fr monthly-box__val type-price"><span class="monthly-box__span type-point" id="pop_price_charge">500,000</span> 원</span>
                                </li>
                                <li class="monthly-price__item clb">
                                    <span class="fl monthly-box__val type-price">현장결제</span>
                                    <span class="fr monthly-box__val type-price"><span class="monthly-box__span type-point" id="pop_price_scene">100,000</span> 원</span>
                                </li>
                            </ol>
                        </div>
                    </li>
                    <li class="monthly-box__item type-info">
                        <p class="monthly-box__name type-customer">부대시설</p>
                        <p class="monthly-box__val type-customer" id="pop_facility">실내수영장, 실내전기그릴, 조식(2일), 실내수영장, 실내전기그릴</p>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>





<script>
    $(document).ready(function() {
        var chk = 0;
        $('.js-height, .js-height2').matchHeight({
            byRow: true,
            target: null
        });
        $(".js-days-btn").click(function() {
            var box_margin = $(".js-days-box").css("margin-left");
            box_margin = Number(box_margin.replace(/px/g, ""));
            if (box_margin == 0) {
                if ($(this).hasClass("type-next")) { //다음날
                    $(this).data("date_prev",$(this).data("date"));
                    postInfoMore("next",$(this).data("date"));
                    box_margin -= 50 * 7;
                    $(".js-days-box").css("margin-left", box_margin + "px");
                }
            } else {
                if ($(this).hasClass("type-next")) { //다음날
                    $(this).data("date_prev",$(this).data("date"));
                    postInfoMore("next",$(this).data("date"));
                    box_margin -= 50 * 7;
                    $(".js-days-box").css("margin-left", box_margin + "px");
                } else if ($(this).hasClass("type-prev")) { //이전날
                    // postInfoMore("prev",$(this).data("date"));
                    $(this).data("date_prev",$(this).data("date"));
                    box_margin += 50 * 7;
                    $(".js-days-box").css("margin-left", box_margin + "px");
                }
            }
        });

        //호버박스
        $(".js-hover-btn").hover(function(){
            $("#pop_date_checkin").text($(this).data("reserve_checkin"));
            $("#pop_date_checkout").text($(this).data("reserve_checkout"));
            $("#pop_reserve_name").text($(this).data("reserve_name"));
            $("#pop_reserve_hp").text($(this).data("reserve_hp"));
            $("#pop_price_reserve").text($(this).data("price_reserve"));
            $("#pop_price_charge").text($(this).data("price_charge"));
            $("#pop_price_scene").text($(this).data("price_scene"));
            $("#pop_facility").text("구비시설, 서비스.....");

			var box_top = ($(this).position().top) + 30;
			var box_left = ($(this).position().left) + 25;

            $(".monthly-box").css("left",box_left + "px");
            $(".monthly-box").css("top",box_top + "px");
            $(".monthly-box").show();
		},function(){
			$(".monthly-box").hide();
        });

    });

    function postInfoMore(type,date){
        $.post(
            '{{route('state.order.more',['id'=>$id])}}'
            ,{
                _token: '{{csrf_token()}}'
                , type: type
                , date: date
            }
            ,function(data){
                console.log(data);
                var html = '';
                var date_st = new Date(data.date.start);
                var date_en = new Date(data.date.end);
                var tmp_month = date_st.getMonth();
                for(var i = date_st; i<=date_en; i = new Date(i.setDate(i.getDate()+1))) {
                    html += '<li class="monthly-days__item">';
                        html += '<div class="monthly-room__head type-date">';
                            html += '<p class="va-m">'+(tmp_month==i.getMonth()?'':(i.getMonth()+1)+'-')+i.getDate()+'<br>'+yoil[i.getDay()]+'</p>';
                        html += '</div>';
                        html += '<div class="monthly-room__cont type-days">';
                            html += '<ul class="monthly-room__list">';
                            for(var k = 0; k<data.rooms.length; k++){
                                html += '<li class="monthly-room__item type-days type-able">';
                                    html += '<div class="monthly-room__state"></div>';
                                html += '</li>';
                            }
                            html += '</ul>';
                        html += '</div>';
                    html += '</li>';
                    tmp_month = i.getMonth();
                }
                if(type=="next"){
                    $("ul.monthly-days__list").append(html);
                    $(".type-next").data("date",i.getFullYear()+'-'+(i.getMonth()+1)+'-'+i.getDate());
                }
                // else if(type=="prev"){
                //     $("ul.monthly-days__list").prepend(html);
                // }

            }
            ,"json"
        )
    }

</script>
@endsection
