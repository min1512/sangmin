<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Language" content="en">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>@yield("title")</title>
    <meta name="viewport"
          content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no"/>
    <meta name="description" content="This is an example dashboard created using build-in elements and components.">
    <meta name="msapplication-tap-highlight" content="no">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="{{ asset('asset/js/jquery.sortable.js') }}"></script>
    <script src="{{ asset('asset/js/jquery.datetimepicker.full.min.js') }}"></script>
    <link href="{{ asset('asset/css/jquery.datetimepicker.css') }}" rel="stylesheet">
    <link href="{{ asset('asset/css/admin_pc_common.css') }}" rel="stylesheet">
    <link href="{{ asset('asset/fontawesomepro/css/all.css') }}" rel="stylesheet">
	<!-- 여기까지 추가 -->
	<link rel="stylesheet" href="http://staff.einet.co.kr/asset/css/common-b.css?v=<?=time()?>">
	<link rel="stylesheet" href="http://staff.einet.co.kr/asset/css/blade.css?v=<?=time() ?>">
	<link rel="stylesheet" href="http://staff.einet.co.kr/asset/css/jjh-style.css">
    <script src="{{ asset('asset/js/common.js') }}"></script>
    <script src="{{ asset('asset/js/form.js') }}"></script>
    <script src="https://t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>
    @yield("scripts")
    @yield("styles")
    <script>
        $(function(){
            $("ul.add-img__list").sortable();
        })
    </script>
</head>
<body>
    <div id="wrap">
        <div id="container">
            <div id="sidebar">
                <div class="change_client"><span>계정전환 <i class="fal fa-angle-down"></i></span></div>
                @php
                    $url = $_SERVER["HTTP_HOST"];
                    $url = str_replace(".einet.co.kr","",$url);

                    $hh = explode(".",$_SERVER["HTTP_HOST"]);
                    if($hh[0]=="staff") $tmp_user = \App\Models\UserStaff::where('user_id',Auth::user()->id)->select('permit_id')->first();
                    elseif($hh[0]=="agency") $tmp_user = \App\Models\UserAgency::where('user_id',Auth::user()->id)->select('permit_id')->first();
                    elseif($hh[0]=="client") $tmp_user = \App\Models\UserClient::where('user_id',Auth::user()->id)->select('permit_id')->first();

                    $permit = \App\Models\ConfigPermitView::where('permit_id',$tmp_user->permit_id)->get();
                    $category = \App\Http\Controllers\Controller::getCategory();
                    $uri = \Illuminate\Support\Facades\Request::route()->uri();
                    $uri = explode("/",$uri);
                @endphp
                <div class="gnb">
                    <ul>
{{--
                        <li>
                            <span class="menu"><i class="fal fa-calendar-alt"></i>예약관리</span>
                            <span class="block_arrow"><i class="fal fa-angle-down"></i></span>
                            <p><i class="fal fa-angle-right"></i> 111111</p>
                            <p><i class="fal fa-angle-right"></i> 222222</p>
                            <p><i class="fal fa-angle-right"></i> 333333</p>
                            <p><i class="fal fa-angle-right"></i> 444444</p>
                        </li>
                        <li>
                            <span class="menu on"><i class="fal fa-calendar-alt"></i>요금관리</span>
                            <span class="block_arrow"><i class="fal fa-angle-up"></i></span>
                            <p><i class="fal fa-angle-right"></i> 가동률/예약통계</p>
                            <p><i class="fal fa-angle-right"></i> 매출통계</p>
                            <p><i class="fal fa-angle-right"></i> 정산현황</p>
                            <p><i class="fal fa-angle-right"></i> 현금영수증</p>
                        </li>
--}}
                        @foreach($category as $k => $v)
                            @php
                                $tmpCnt = \App\Models\ConfigPermitView::where('permit_id',$tmp_user->permit_id)->where('code_admin',$v['code'])->count();
                                if($tmpCnt<1) continue;
                                $tmp_code_0 = str_replace("_",".",str_replace("admin_","",$v['code']));
                                $tmp_path_0 = explode(".",$tmp_code_0);
                            @endphp
                            <li>
                                @if(isset($v['sub']))
                                    <span class="menu"><i class="fal fa-{{$v['icon']}}"></i>{{ $v['name'] }}</span>
                                    <span class="block_arrow"><i class="fal fa-angle-down"></i></span>
                                    @foreach($v['sub'] as $k2 => $v2)
                                        @php
                                            $tmpCnt = \App\Models\ConfigPermitView::where('permit_id',$tmp_user->permit_id)->where('code_admin',$v2['code'])->count();
                                            if($tmpCnt<1) continue;
                                            $tmp_code = str_replace("_",".",str_replace("admin_","",$v2['code']));
                                            $tmp_path = explode(".",$tmp_code);
                                        @endphp
                                        <p style="display:none; "><a href="{{ route($tmp_code) }}"><i class="fal fa-angle-right"></i> {{ $v2['name'] }}</a></p>
                                    @endforeach
                                @else
                                    <span class="menu"><a href="{{ route($tmp_code_0) }}"><i class="fal fa-{{$v['icon']}}"></i>{{ $v['name'] }}</a></span>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div id="header">
                <div class="logo">
                    <img src="{{asset('asset/images/logo_einet.png')}}" />
                    <span>이아이넷 펜션(본점)</span>
                </div>
                <div class="search">
                    <input type="text" name="" class="keyword" placeholder="예약자/연락처/요청/메모" />
                    <button class="btn_reservation" id="btn_top_reservation"><i class="fal fa-calendar"></i> 직접예약</button>
                    <button class="btn_search"><i class="fal fa-search"></i> 검색</button>
                </div>
            </div>
            <div id="content">
			<div class="wrap">
                <div class="quick">
                    <ul>
                        <li>사이트바로가기</li>
                        <li><a href="http://api.einet.co.kr/test" target="_BLANK">실시간예약창</a></li>
                        <li>내정보</li>
                    </ul>
                </div>
              @yield("contents")
			  </div>
            </div>
        </div>
    </div>
    <div class="dim">dim</div>
    <div style="position:fixed; right:0; top:0; bottom:0; width:600px; background-color:#fff; border:3px solid #e32450; z-index:9999; display:none;" id="top_reservation">
        @php $clientList = \App\Models\UserClient::leftJoin('users','users.id','=','user_client.user_id')->where('users.flag_use','Y')->get(); @endphp
		<div id="i_direct_reser_popup">
            <form method="post" name="frmTopReserve" action="{{route('call.client.room.reserve')}}">
			<div class="pop-module__inbox" style="width:100%;">
				<div class="pop-module__head clb">
					<span class="pop-module__tit fl">직접예약하기</span>
					<span class="pop-module__close fr">닫기</span>
				</div>
				<div class="pop-module__body">
					<div class="table-a noto">
						<div class="select-wrap dp-ib" style="width:266px; margin-left:calc(50% - 133px);">
							<select name="top_client" id="top_client" class="select-v1 noto">
                                <option value="">::펜션선택::</option>
                                @foreach($clientList as $c)
                                <option value="{{$c->user_id}}">{{$c->client_name}}</option>
                                @endforeach
							</select>
						</div>
						<div class="table-a__inbox type-line">
							<input type="text" name="top_reserve_date" class="datepicker va-m noto" id="datetimepicker3" />
						</div>
					</div><!-- table-a noto -->
				</div>
			</div><!-- pop-module__inbox -->
			<div class="list_blade">
				<div class="table-a noto">
                    <table class="table-a__table" id="top_reserve_room_list">
                        <colgroup>
                            <col width="20%"/>
                            <col width="15%"/>
                            <col width="*"/>
                            <col width="15%"/>
                        </colgroup>
                        <thead>
                        <tr class="table-a__tr type-th">
                            <th class="table-a__th">객실명</th>
                            <th class="table-a__th">숙박</th>
                            <th class="table-a__th">인원</th>
                            <th class="table-a__th">판매객실가</th>
                        </tr>
                        </thead>

                        <!--자동호출(객실,부대시설)-->
                        <tbody>
                        </tbody>
                    </table>
                    <table class="table-a__table" style="margin:10px 0 0 0;">
                        <colgroup>
                            <col width="">
                        </colgroup>
                        <tr class="table-a__tr type-th">
                            <th class="table-a__th">예약자명</th>
                            <td class="table-a__td">
                                <div class="input-wrap">
                                    <input type="text" name="top_order_name" class="input-v1" placeholder="홍길동" />
                                </div>
{{--
                                <div class="table-a__inbox table-a__span type-2">
                                    <span>홍길동</span>
                                </div>
--}}
                            </td>
                        </tr>

                        <tr class="type-th">
                            <th class="table-a__th">연락처</th>
                            <td class="table-a__td">
                                <div class="input-wrap">
                                    <input type="text" name="top_order_hp" class="input-v1" placeholder="010-0000-0000" />
                                </div>
{{--
                                <div class="table-a__inbox table-a__span type-2">
                                    <input type="text" name="top_order_hp" class="input-v1" value="010 - 0000 - 0000" />
                                </div>
--}}
                            </td>
                        </tr>

{{--
                        <tr class="type-th">
                            <th class="table-a__th">예약상태</th>
                            <td class="table-a__td">
                                <div class="table-a__inbox table-a__span type-2">
                                    <span>예약완료</span>
                                </div>
                            </td>
                        </tr>
--}}

                        <tr class="type-th">
                            <th class="table-a__th">유입경로</th>
                            <td class="table-a__td">
                                @php $root_type = \App\Http\Controllers\Controller::getCode("route_type"); @endphp
                                <div class="table-a__inbox table-a__span type-2">
                                    <div class="select-wrap">
                                        <select name="top_route_type" class="select-v1">
                                            <option value="">::선택::</option>
                                            @foreach($root_type as $rt)
                                                <option value="{{$rt->code}}">{{$rt->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <tr class="type-th">
                            <th class="table-a__th">추가요금</th>
                            <td class="table-a__td">
                                <div class="input-wrap">
                                    <input type="text" name="top_order_price_etc" id="top_order_price_etc" class="input-v1" value="0" /><span>원</span>
                                </div>
{{--
                                <div class="table-a__inbox table-a__span type-2" >
                                    <input type="text" name="top_order_price_etc" class="input-v1" value="100,000" /><span>원</span>
                                </div>
--}}
                            </td>
                        </tr>

                        <tr class="type-th">
                            <th class="table-a__th">고객요청사항</th>
                            <td class="table-a__td" style="text-align:left;">
                                <span><input type="text" name="top_request" class="input-v1" value="" /></span>
{{--
                                <input type="checkbox" id="choice1-4" class="checkbox-v2" name="choice4" value="0" checked="">
                                <label for="choice1-4">픽업</label>
                                <input type="checkbox" id="choice1-5" class="checkbox-v2" name="choice4" value="0" checked="">
                                <label for="choice1-5">조식</label>
--}}
                            </td>
                        </tr>

                        <tr class="type-th">
                            <th class="table-a__th">관리자메모</th>
                            <td class="table-a__td">
                                <div class="input-wrap">
                                    <input type="text" name="top_request_memo" class="input-v1">
                                </div>
                            </td>
                        </tr>

                        <tr class="type-th">
                            <th class="table-a__th">미입금 자동취소</th>
                            <td class="table-a__td" style="text-align:left;">
                                <input type="radio" id="top_account_cancel_y" class="radio-v1" name="top_account_cancel" value="Y">
                                <label for="top_account_cancel_y">사용</label>
                                <input type="radio" id="top_account_cancel_n" class="radio-v1" name="top_account_cancel" value="N">
                                <label for="top_account_cancel_n">사용안함</label>
                            </td>
                        </tr>

                        <tr class="type-th">
                            <th class="table-a__th">입금안내</th>
                            <td class="table-a__td" style="text-align:left;">
                                <input type="checkbox" id="top_account_intro_kakao" class="checkbox-v2" name="top_account_intro[]" value="kakao" />
                                <label for="top_account_intro_kakao">카톡</label>
                                <input type="checkbox" id="top_account_intro_sms" class="checkbox-v2" name="top_account_intro[]" value="sms" />
                                <label for="top_account_intro_sms">문자</label>
                            </td>
                        </tr>

                    </table>

                    <table class="table-a__table">
                        <colgroup>
                            <col width="">
                        </colgroup>
                        <tr class="table-a__tr type-th"
                            style="border-top:2px solid #333; border-bottom:2px solid #333;">
                            <th class="table-a__th">총금액</th>
                            <td class="table-a__td">
                                <div class="table-a__inbox table-a__span type-2 all_price">
									<div class="input-wrap">
										<input type="text" class="input-v1" name="top_price_total" id="top_price_total" value="0" />
										<span>원</span>
									</div>

                                    <div class="ta-r" style="display:inline-block;">
                                        <button type="button" class="detail_btn">상세보기</button>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </table>

                    <div class="ta-r"><button type="button" class="b-calendar-head__btn btn-v1" onclick="frmTopReserveCheck()">저장</button></div>
				</div>
			</div>
            </form>
		</div><!-- i_direct_reser_popup -->
    </div>

    <script>
        jQuery('#datetimepicker3').datetimepicker({
            format:'d.m.Y H:i',
            inline:true,
        });

        function callClientRoom() {
            $.post(
                '{{route('call.client.room')}}',
                {
                    _token: '{{csrf_token()}}',
                    client_id: $("select[name=top_client]").val(),
                    ymd: $("input[name=top_reserve_date]").val()
                },
                function (data) {
                    var tmp_html = "";
                    for (var i in data.room) {
                        var item = data.room[i];

                        cnt_day = 0;
                        if(item.day_0==0) cnt_day++;
                        if(item.day_1==0 && cnt_day==1) cnt_day++;
                        if(item.day_2==0 && cnt_day==2) cnt_day++;
                        if(item.day_3==0 && cnt_day==3) cnt_day++;
                        if(item.day_4==0 && cnt_day==4) cnt_day++;
                        if(item.day_5==0 && cnt_day==5) cnt_day++;

                        tmp_html += "<tr class='table-a__tr'>";
                            tmp_html += "<td class='table-a__td'>";
                                tmp_html += "<input type='checkbox' id='choice_"+i+"_"+item.id+"' class='radio-v2' name='room["+item.id+"]' onclick='chgTopPrice()' data-cnt-basic='"+item.room_cnt_basic+"' data-cnt-max='"+item.room_cnt_max+"' />";
                                tmp_html += "<label for='choice_"+i+"_"+item.id+"'>" + item.room_name + "</label>";
                            tmp_html += "</td>";

                            tmp_html += "<td class='table-a__td lodge'>";
                                tmp_html += "<div class='input-wrap'>";
                                    tmp_html += "<div class='select-wrap'>";
                                        tmp_html += "<select name='overday["+item.id+"]' id='room_"+i+"_"+item.id+"' class='select-v1 noto' onchange='chgTopPrice()'>";
                                        for(var i=1; i<=cnt_day; i++) {
                                            if(i==1) var price_sales = item.price_sales_0;
                                            else if(i==2) var price_sales = item.price_sales_1;
                                            else if(i==3) var price_sales = item.price_sales_2;
                                            else if(i==4) var price_sales = item.price_sales_3;
                                            else if(i==5) var price_sales = item.price_sales_4;
                                            else if(i==6) var price_sales = item.price_sales_5;
                                            tmp_html += "<option value='"+i+"' data-price='"+(!price_sales?"":price_sales)+"'>"+i+"</option>";
                                        }
                                        tmp_html += "</select>";
                                    tmp_html += "</div>";
                                tmp_html += "</div>";
                            tmp_html += "</td>";

                            tmp_html += "<td class='table-a__td people'>";
                                tmp_html += "<div class='input-wrap'>";
                                    tmp_html += "<div class='select-wrap'>";
                                        tmp_html += "<select name='cnt_adult["+item.id+"]' id='cnt_adult_"+i+"_"+item.id+"' class='select-v1 noto' onchange='chgTopPrice()'>";
                                            tmp_html += "<option value='0'>성인</option>";
                                            for(var i=0; i<item.room_cnt_max; i++){
                                                tmp_html += "<option value='"+(parseInt(i)+1)+"'>"+(parseInt(i)+1)+"</option>";
                                            }
                                        tmp_html += "</select>";
                                    tmp_html += "</div>";
                                tmp_html += "</div>";
                                tmp_html += "<div class='input-wrap'>";
                                    tmp_html += "<div class='select-wrap'>";
                                        tmp_html += "<select name='cnt_child["+item.id+"]' id='cnt_child_"+i+"_"+item.id+"' class='select-v1 noto' onchange='chgTopPrice()'>";
                                            tmp_html += "<option value='0'>아동</option>";
                                            if(item.flag_child=="Y") {
                                                for (var i = 0; i < item.room_cnt_max; i++) {
                                                    tmp_html += "<option value='" + (parseInt(i) + 1) + "'>" + (parseInt(i) + 1) + "</option>";
                                                }
                                            }
                                        tmp_html += "</select>";
                                    tmp_html += "</div>";
                                tmp_html += "</div>";
                                tmp_html += "<div class='input-wrap'>";
                                    tmp_html += "<div class='select-wrap'>";
                                        tmp_html += "<select name='cnt_baby["+item.id+"]' id='cnt_baby_"+i+"_"+item.id+"' class='select-v1 noto' onchange='chgTopPrice()'>";
                                            tmp_html += "<option value='0'>유아</option>";
                                            if(item.flag_baby=="Y") {
                                                for (var i = 0; i < item.room_cnt_max; i++) {
                                                    tmp_html += "<option value='" + (parseInt(i) + 1) + "'>" + (parseInt(i) + 1) + "</option>";
                                                }
                                            }
                                        tmp_html += "</select>";
                                    tmp_html += "</div>";
                                tmp_html += "</div>";
                            tmp_html += "</td>";
                            tmp_html += "<td class='table-a__td type-td-point'>";
                                tmp_html += "<div class='table-a__inbox'>";
                                    tmp_html += "<span class='type-point type-line' id='price1_"+item.id+"'>"+(!item.price_sales_0?"-":item.price_sales_0.format())+"</span>";
                                tmp_html += "</div>";
                            tmp_html += "</td>";
                        tmp_html += "</tr>";

                        var code_facility = item.code_facility.split(/,/gi);
                        var facility = item.facility.split(/,/gi);

                        if(data.facility[item.id]) {
                            tmp_html += "<tr class='table-a__tr'>";
                            tmp_html += "<td colspan='4' class='table-a__td2 type-nobd type-left' style='border-bottom:1px solid #dddddd;'>";
                            tmp_html += "<div class='facility-group clb'>";
                            tmp_html += "<ul class='facility-group__list fl clb'>";
                            for (var f in data.facility[item.id]) {
                                console.log(data.facility[item.id][f]);
                                tmp_html += "<li class='facility-group__item fl'>";
                                tmp_html += "<input type='checkbox' id='fg1_" + item.id + "_" + f + "' class='checkbox-v3' name='facility[" + item.id + "][]' value='" + data.facility[item.id][f].id + "' data-price='"+data.facility[item.id][f].etc_price+"' onclick='chgTopPrice()'>";
                                tmp_html += "<label for='fg1_" + item.id + "_" + f + "'>" + data.facility[item.id][f].etc_content + "/"+data.facility[item.id][f].etc_dan+"</label>";
                                tmp_html += "</li>";
                            }
                            tmp_html += "</ul>";
                            tmp_html += "</div>";
                            tmp_html += "</td>";
                            tmp_html += "</tr>";
                        }
                    }

                    $("table#top_reserve_room_list tbody").html(tmp_html);
                },
                "json"
            );

        }

        function chgTopPrice() {
            var total = 0;
            var etc_price = 0;
            $("input[name^='room[']").each(function(){
                var tmp_key = $(this).attr("name").replace('room[','').replace(']','');
                var room_price = 0;
                var select_person = 0;

                if($(this).prop("checked")) {
                    select_person = parseInt(select_person) + parseInt($("select[name='cnt_adult["+tmp_key+"]']").val());
                    select_person = parseInt(select_person) + parseInt($("select[name='cnt_child["+tmp_key+"]']").val());
                    select_person = parseInt(select_person) + parseInt($("select[name='cnt_baby["+tmp_key+"]']").val());

                    if($(this).data('cnt-max')<select_person) {
                        alert("최대인원을 넘었습니다. 다시 선택해주세요.");
                        $("select[name='cnt_adult["+tmp_key+"]']").val(2);
                        $("select[name='cnt_child["+tmp_key+"]']").val(0);
                        $("select[name='cnt_baby["+tmp_key+"]']").val(0);
                        return false;
                    }

                    var cnt_over = $("select[name^='overday["+tmp_key+"]']").val();
                    $("select[name^='overday["+tmp_key+"]'] > option").each(function(){
                        if($(this).index()<cnt_over){
                            total += $(this).data("price"); //전체 금액
                            room_price += $(this).data("price"); //객실별 금액
                        }
                    });

                    $("input[name='facility["+tmp_key+"][]']").each(function(){
                        if($(this).prop("checked")) {
                            etc_price += $(this).data("price")*cnt_over;
                            total += $(this).data("price")*cnt_over;
                        }
                    })
                }
                //$("#price1_"+tmp_key).text(room_price.format());
            });
            $("#top_order_price_etc").val(etc_price.format());
            $("#top_price_total").val(total.format());
        }
    </script>
</body>
</html>
