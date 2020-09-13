<script>
    function check_all(){
        var tcnt = 0;
        var tcnt1 = 0;
        var tcnt3 = 0;

            @php
                $path = $_SERVER["HTTP_HOST"];
                $path = explode(".",$path);
            @endphp

        var client = "client";
        var staff = "staff";
        if(client == "{{ $path[0] }}") {
            if (tcnt < 1 && tcnt1 <1 && tcnt3 <1) {
                $("form[name=teewetwer]").attr("action", '/info/auto_discount/save');
                return true;
            } else {
                return false;
            }
        }else if(staff == "{{ $path[0] }}"){
            if (tcnt < 1 && tcnt1 <1 && tcnt3 <1) {
                $("form[name=teewetwer]").attr("action", '{{url()->current()}}');
                return true;
            } else {
                return false;
            }
        }
    }
</script>

<script>
    $(function () {
        $("#term_check_Y").hide();
        $("input[name='term_check']:radio").change(function () {
            if($(this).val()=="Y"){
                $("#term_check_Y").show();
            }else{
                $("#term_check_Y").hide();
            }
        })
    })
</script>
<script>
    $(function () {
        $("#char_all").change(function () {
            var value = $(this).val();
            $('.change_select').val(value).prop("selected",true);
        })
    })
</script>

<script>
    function type_add() {
        var ord = $("input[name='discount_howmuch[]']").length;
        if (ord != 0) {
            $("#Autoset_Discount_Howmuch").append("" +
                "<li class='check_new mb-5' id='"+ord+"'>" +
                    "<span class='dp-ib' style='width: 80px;'>입실 " + ord + "일 전</span>" +
                    "<div class='input-wrap noto' style='width: 100px;'>" +
                        "<input type='text' name='discount_howmuch[]' class='input-v1 number' value=''>" +
                        "<a class='change_char'></a>" +
                    "</div>" +
                    "<div class='select-wrap dp-ib ml-5' style='width:150px;'>" +
                        "<select id='char_select_" + ord + "' name='char[]' class='select-v1 noto change_select'>" +
                            "<option value='%|discount'> 정률할인(%)</option>" +
                            "<option value='원|fixed'> 고정가 판매(원)</option>" +
                            "<option value='원|discount'>할인 판매(원)</option>" +
                        "</select>" +
                    "</div>" +
                    "<div class='input-wrap'>" +
                        "<label for='discount_delete_" + ord + "' class='ml-10 btn-v2' onclick='delete_value("+ord+")'>삭제</label>" +
                    "</div>" +
                "</li>"
            );
        } else {
            $("#Autoset_Discount_Howmuch").append("" +
                "<li class='check_new mb-5' id='"+ord+"'>" +
                    "<span class='dp-ib' style='width: 80px;'>입실 당일</span>" +
                    "<div class='input-wrap noto' style='width: 100px;'>" +
                        "<input type='text' name='discount_howmuch[]' class='input-v1 number' value=''>" +
                        "<a class='change_char'></a>" +
                        "</div>" +
                    "<div class='select-wrap dp-ib ml-5' style='width:150px;'>" +
                    "<select id='char_select_" + ord + "' name='char[]' class='select-v1 noto change_select'>" +
                        "<option value='%|discount'> 정률할인(%)</option>" +
                        "<option value='원|fixed'> 고정가 판매(원)</option>" +
                        "<option value='원|discount'>할인 판매(원)</option>" +
                    "</select>" +
                    "</div>" +
                    "<div class='input-wrap'>" +
                        "<label for='discount_delete_" + ord + "' class='ml-10 btn-v2' onclick='delete_value("+ord+")' >삭제</label>" +
                    "</div>" +
                "</li>"
            );
        }
    }
</script>
<script>
    $(function () {
        $("#rooms_id_all").click(function () {
            if($(this).is(":checked") == true){
                $("input[id^='room_id']").prop("checked",true);
            }else{
                $("input[id^='room_id']").prop("checked",false);
            }
        })
        $("#day_all").click(function () {
            if($(this).is(":checked") == true){
                $("input[id^='days']").prop("checked",true);
            }else{
                $("input[id^='days']").prop("checked",false);
            }
        })

        $("input[id^='days']").click(function () {

            if($("input[id^='days']").length == $("input[id^='days']:checked").length ){
                $("#day_all").prop("checked",true);
            }else{
                $("#day_all").prop("checked",false);
            }
        })

        $("input[id^='room_id']").click(function () {

            if($("input[id^='room_id']").length == $("input[id^='room_id']:checked").length ){
                $("#rooms_id_all").prop("checked",true);
            }else{
                $("#rooms_id_all").prop("checked",false);
            }
        })

    })



</script>

<script>
    @php
        $path = $_SERVER["HTTP_HOST"];
        $path = explode(".",$path);
    @endphp
    $(function () {
        $("[id^='staff']").click(function () {
            var tmp = $(this).attr('id');
            if(tmp != "staff") {
                var tmp2 = tmp.replace(/staff_/i,"");
                var season_id = $('#season_id_'+tmp2+'').val();
                $.ajax({
                    url: @if($path[0]=="client")  "/info/auto_discount/view/{{$s->id}}" @else "/price/autoset/view/{{$user_id}}/"+season_id + ""  @endif,
                    data: {
                        _token: "{{ csrf_token() }}",
                        user_id: {{ $user_id }},
                        discount_season_id: season_id
                    },
                    type: "get",
                    success: function (data) {
                        if(data.Autoset_Discount.term_check == "Y"){
                            $("#choice1").prop("checked",true);
                            $("#term_check_Y").show();
                            $("#discount_start").val(data.Autoset_Discount.discount_start);
                            $("#discount_end").val(data.Autoset_Discount.discount_end);
                        }else if(data.Autoset_Discount.term_check == "N"){
                            $("#choice2").prop("checked",true);
                            $("#term_check_Y").hide();
                        }

                        if(data.Autoset_Discount.autoset_check == "Y"){
                            $("input[name='autoset_check']").prop("checked",true);
                        }else{
                            $("input[name='autoset_check']").prop("checked",false);
                        }

                        $("#Autoset_Discount_Howmuch").show();
                        var html = "";
                        for (var i in data.Autoset_Discount_Howmuch) {
                            var item = data.Autoset_Discount_Howmuch[i];
                            if(i==0){
                                html += "<li class='check_new mb-5' id='"+i+"'>";
                                    html +="<span class=\"dp-ib\" style=\"width:80px\">입실 당일</span>"
                                    html +="<div class=\"input-wrap noto\" style=\"width:100px;\">"
                                        html +="<input type=\"text\" name=\"discount_howmuch[]\" id='discount_value_"+i+"' class=\"input-v1 number\" value=\""+item.autoset_discount_howmuch+"\">"
                                    html +="</div>"
                                    html +="<div class=\"select-wrap dp-ib ml-5\" style='width:150px;'>"
                                        html +="<select id='char_select_"+i+"' name=\"char[]\" class=\"select-v1 noto change_select\" >"
                                            html +="<option value=\"%|discount\">정률 할인(%)</option>"
                                            html +="<option value=\"원|fixed\">고정가 판매(원)</option>"
                                            html +="<option value=\"원|discount\">할인 판매(원)</option>"
                                        html +="</select>"
                                        html +="<input type='hidden' id='char_"+i+"' value="+item.autoset_discount_unit+"|"+item.autoset_discount_type+">"
                                    html +="</div>"
                                    html +="<div class=\"input-wrap\">"
                                        html +="<label for=\"discount_delete_"+i+"\" class=\"ml-10 delete btn-v2\" id=\"discount_delete_"+i+"\" onclick='delete_value("+i+")' >삭제</label>"
                                    html +="</div>"
                                html +="</li>"
                            }else if(i>=1){
                                html += "<li class='check_new mb-5' id='"+i+"'>";
                                    html += "<span class=\"dp-ib\" style=\"width:80px\">입실 "+i+"일 전</span>"
                                    html += "<div class=\"input-wrap noto\" style=\"width:100px;\">"
                                        html +="<input type=\"text\" name='discount_howmuch[]'  id='discount_value_"+i+"' class=\"input-v1 number\" value=\""+item.autoset_discount_howmuch+"\"> <a class=\"change_char\"></a>"
                                    html += "</div>"
                                    html +="<div class=\"select-wrap dp-ib ml-5\" style='width:150px;'>"
                                        html +="<select id='char_select_"+i+"' name=\"char[]\" class=\"select-v1 noto change_select\" >"
                                            html +="<option value=\"%|discount\">정률 할인(%)</option>"
                                            html +="<option value=\"원|fixed\">고정가 판매(원)</option>"
                                            html +="<option value=\"원|discount\">할인 판매(원)</option>"
                                        html +="</select>"
                                        html +="<input type='hidden' id='char_"+i+"' value="+item.autoset_discount_unit+"|"+item.autoset_discount_type+">"
                                    html +="</div>"
                                    html +="<div class=\"input-wrap\">"
                                        html +="<label for=\"discount_delete_"+i+"\" class=\"ml-10 delete btn-v2\"  id=\"discount_delete_"+i+"\" onclick='delete_value("+i+")'>삭제</label>"
                                    html +="</div>"
                                html += "</li>"
                            }
                        }
                        $('#Autoset_Discount_Howmuch').html(html);

                        $("input[id^='char']").each(function () {
                            var id = $(this).attr('id');
                            var k = id.replace("char_","");
                            var value = $(this).val();
                            $("#char_select_"+k+"").val(value).prop("selected",true);
                        })

                        //요일 값 넣기

                        var date_array = data.Autoset_Discount.day;
                        var date_array = date_array.split(',');

                        var tmp_yoil = ['일', '월', '화', '수', '목', '금', '토'];

                        for (var i in tmp_yoil) {
                            if ($.inArray(i, date_array) > -1) {
                                $('#days_' + i + '').prop("checked", true);
                            } else {
                                $('#days_' + i + '').prop("checked", false);
                            }
                        }
                        //여기서 끝

                        //다 체크 되면 전체 체크 박스 체크 되게...(요일)
                        if ($("input[name^='day']").length == $("input[name^='day']:checked").length) {
                            $("#day_all").prop("checked", true);
                        } else {
                            $("#day_all").prop("checked", false);
                        }
                        //

                        //방 정보값 넣기
                        for (var i in data.ClientTypeRoom) {
                            var item = data.ClientTypeRoom[i];
                            if (item.room_id != null) {
                                $('#room_id_' + i + '').prop("checked", true);
                            } else {
                                $('#room_id_' + i + '').prop("checked", false);
                            }
                        }
                        //여기서 끝

                        //다 체크 되면 전체 체크 박스 체크 되게...(방)
                        if ($("input[name^='room_id']").length == $("input[name^='room_id']:checked").length) {
                            $("#rooms_id_all").prop("checked", true);
                        } else {
                            $("#rooms_id_all").prop("checked", false);
                        }

                        //정보가 있을때 할인 id 값을 받아옴
                        var html = "";
                        html += "<input type='hidden' name='season_id' value=" + data.did + ">"
                        $("#autoset_discount_id").html(html);

                    }
                })
            }else{
                $("#choice2").prop("checked",true);
                $("#choice1").prop("checked",false);
                $("#term_check_Y").hide();

                $("#discount_start").val("");
                $("#discount_end").val("");
                $("input[name='autoset_check']").prop("checked",false);


                // $("input[id^='discount_value']").each(function () {
                //     $(this).val(0);
                // })

                $('.check_new').remove();

                $("#day_all").prop("checked",false);
                $("input[name^='day']").each(function () {
                    $(this).prop("checked",false);
                })

                $("#rooms_id_all").prop("checked",false);
                $("input[name^='room_id']").each(function () {
                    $(this).prop("checked",false);
                })

                $("input[name='season_id']").val("");

            }

        })
    })
</script>
<script>
    function delete_value(id){
        var id = id;
        $("#"+id+"").remove();

        $('.check_new').each(function () {
            if($(this).attr("id") > id){
                $(this).find("span.dp-ib").text("입실 "+(parseInt($(this).attr("id")) - 1)+"일전");
                $(this).attr("id",(parseInt($(this).attr("id")) - 1));
            }

        })

    }
</script>

<div class="row">
    <div class="main-card mb-3 card" style="width:100%; ">
        <div class="card-body"><h5 class="card-title bld">자동 할인 설정</h5>
           <div class="table-a noto">
               <div class="table-a__head clb">
                   <p class="table-a__tit fl">자동 할인 설정</p>
                   <div class="table-a_inbox type-head fr">
                       {{--<button class="mr-2 btn btn-focus btn-v1 js-pop-btn js-type-sale-auto" onclick="goUrl('{{ isset($client) && $client=="client" ? route('info.autoset.view',['did'=>isset($did)?$did:""]) : route('price.autoset.view',['user_id'=>isset($user_id)?$user_id:"", 'did'=>isset($did)?$did:""]) }}');">자동 할인 추가</button>--}}
                       <button type="button" id="staff" class="btn-v1 status-rb js-pop-btn js-type-sale-auto">할인 추가
                       </button>
                   </div>
               </div>

               <table class="mb-0 table table-hover table-a__table">
               <colgroup>
                   <col>
                   <col>
                   <col>
                   <col>
                   <col width="40%">
                   <col>
               </colgroup>
                <tr class="table-a__tr type-th">
                    <th class="table-a__th ">번호</th>
                    <th class="table-a__th ">할인 적용일</th>
                    <th class="table-a__th ">할인 내용</th>
                    <th class="table-a__th ">기간</th>
                    <th class="table-a__th ">객실</th>
                    <th class="table-a__th ">
<!--                    <a id="delete_discount" name="delete_discount" class="mr-2 btn btn-info" style="color: white;">할인 삭제</a>-->
                    </th>
                </tr>
                @foreach($discountList as $k=> $s)
                    <tr class="table-a__tr">
                        @php
                            $date_array = explode(',',$s->day);
                            $date_list="";
                            for ($i=0; $i<sizeof($date_array); $i++){
                                if($date_array[$i]==1){
                                    $date_list = $date_list."월 |";
                                }elseif ($date_array[$i]==2){
                                    $date_list = $date_list."화 |";
                                }elseif ($date_array[$i]==3){
                                    $date_list = $date_list."수 |";
                                }elseif ($date_array[$i]==4){
                                    $date_list = $date_list."목 |";
                                }elseif ($date_array[$i]==5){
                                    $date_list = $date_list."금 |";
                                }elseif ($date_array[$i]==6){
                                    $date_list = $date_list."토 |";
                                }elseif ($date_array[$i]==0){
                                    $date_list = $date_list."일 |";
                                }
                            }

                        @endphp
                        <td class="table-a__td">{{$k+1}}</td>
                        <td class="table-a__td type-td-point js-pop-btn js-type-sale-auto">
                           <span class="type-point type-line">
                             @if($client=="client")
                                <a id="staff_{{$k}}">{{$date_list}}</a>
                                <input type="hidden" id="season_id_{{$k}}" value="{{$s->id}}">
                            @else
                                <a id="staff_{{$k}}">{{$date_list}}</a>
                                <input type="hidden" id="season_id_{{$k}}" value="{{$s->id}}">
                            @endif
                           </span>

                        </td>
                        <td class="table-a__td">
                            @php
                                $aaaa = \App\Models\AutosetDiscountHowmuch::where('autoset_id',$s->id)->orderBy('date','asc')->get();
                            @endphp
                            @foreach($aaaa as $a)
                                @if($a->date=="0")
                                    <p>입실 당일: {{ number_format($a->autoset_discount_howmuch).$a->autoset_discount_unit }}</p>
                                @else
                                    <p>입실 {{$a->date}}일전: {{ number_format($a->autoset_discount_howmuch).$a->autoset_discount_unit }}</p>
                                @endif
                            @endforeach
                        </td>
                        <td class="table-a__td">@if($s->term_check=="N")상시@elseif($s->term_check=="Y"){{$s->discount_start}} ~ {{$s->discount_end}}@endif</td>
                        <td class="table-a__td">
                           <ul class="auto-disroom__list clb">
                              @foreach($Client_type_room as $v)
                                @if($v->autoset_id==$s->id)
                               <li class="auto-disroom__item fl">
                                    <span>{{$v->room_name}}</span>
                               </li>
                                @endif
                            @endforeach
                             </ul>
                        </td>
                        <td class="table-a__td">
                            <button type="button" class="btn-v2 delete_auto_discount" value="{{$s->id}}">삭제</button>
                        </td>
                    </tr>
                @endforeach
                   <tr>
                       <td colspan="6">{{$discountList->links('admin.pc.pagination.default')}}</td>
                   </tr>
{{--
                <tr>
                    <th id="add_discount_list"></th>
                </tr>
--}}
                <script>
                    $(function () {
                        $(".delete_auto_discount").click(function () {
                            confirm('정말 삭제 하시겠습니까?');
                            var delete_season_id = $(this).val();
                            $.ajax({
                                url: @if($client=="client")  "/info/autoset/view/{{$s->id}}" @else "/price/autoset/delete/{{$user_id}}/"+delete_season_id+""  @endif,
                                data: {
                                    _token: "{{ csrf_token() }}",
                                    user_id: {{ $user_id }},
                                    season_id: delete_season_id
                                },
                                type: "POST",
                                success : function (data) {
                                    location.reload();
                                },
                                error : function (data) {
                                    location.reload();
                                }
                            })
                        })
                    })
                </script>
            </table>
    </div>
        </div>
    </div>
</div>

<div class="pop-module bld-pop js-pop js-pop-sale-auto">
		<div class="pop-module__wrap">
			<div class="pop-module__box">
				<div class="pop-module__inbox" style="width:746px;">
					<div class="pop-module__head clb">
						<span class="pop-module__tit fl">자동 할인 추가하기</span>
						<span class="pop-module__close fr js-pop-close">닫기</span>
					</div>
					<div class="pop-module__body type-fix">
						<div class="table-a noto">
                        <form method='post' name='teewetwer' class='client_form' action='{{ url()->current() }}' onSubmit="return check_all()">
                            {{csrf_field()}}
							<table class="table-a__table type-top">
							 	<colgroup>
									<col width="120px">
									<col width="">
							 	</colgroup>

								<tr class="table-a__tr">
                                    <a id="autoset_discount_id"></a>
									<td class="table-a__td type-nobd type-right type-top  type-pop">
										<span class="lh-33">기간 설정</span>
									</td>
									<td class="table-a__td type-nobd type-pop type-left">
                                    <div>
                                        <div class="input-wrap">
									        <input type="radio"  name="term_check" id="choice2" class="radio-v1" name="choice" value="N" checked>
                                            <label for="choice2">상시</label>
                                            <input type="radio"  name="term_check" id="choice1" class="radio-v1" name="choice" value="Y">
                                            <label for="choice1" class="ml-30">기간</label>
									    </div>
										<div class="input-wrap ml-10" id="term_check_Y" >
											 <div class='table-a__inbox type-line'>
                                                 <p class="dp-wrap dp-ib">
                                                   <input type='text' class='datepicker va-m noto db_right_now_add' name='start_date'  id='discount_start' value="">
                                                 </p> &nbsp;-&nbsp;
                                                  <p class="dp-wrap dp-ib">
                                                    <input type='text' class='datepicker va-m noto db_right_now_add' name='end_date' id='discount_end' value="">
                                                  </p>
                                            </div>
										</div>
										<div class="input-wrap">
										    <input type="checkbox" name="autoset_check" id="chkAll-1" class="checkbox-v2" value="Y"><label for="chkAll-1" class="ml-10" style="line-height:1.3">당일할인<br>달력에 노출함</label>
										</div>
                                    </div>
									</td>
								</tr>
								<tr class="table-a__tr">
									<td class="table-a__td type-nobd type-right  type-pop">
										<span class="">판매 요금 기준</span>
									</td>
									<td class="table-a__td type-nobd type-left pd-r-50 type-pop">
										<div class="select-wrap dp-ib" style="width:140px;">
											<select id="char_all" class="select-v1 noto"  >
												<option value="%|discount">정률 할인(%)</option>
												<option value="원|fixed">고정가 판매(원)</option>
												<option value="원|discount">할인 판매(원)</option>
											</select>
										</div>

									</td>
								</tr>
								<tr>
								   <td class="table-a__td type-nobd type-right type-top  type-pop">
                                       <p class="lh-33">할인율</p>
                                       <p><button type="button" class="btn-v2 type-icon type-add" onclick="type_add()">추가</button></p>
									</td>
									<td class="table-a__td type-nobd type-pop type-left">
                                       <ul id="Autoset_Discount_Howmuch">

                                       </ul>
                                        <ul id="Autoset_Discount_Howmuch_new">

                                        </ul>
                                    </td>
								</tr>
								<tr class="table-a__tr">
									<td class="table-a__td type-nobd type-right type-top  type-pop">
										<span>적용 요일</span>
									</td>
									<td class="table-a__td type-nobd type-pop type-left">
                                    <div>
                                        <input type="checkbox" id="day_all" class="checkbox-v2">
												<label for="day_all">요일 전체 선택</label>
                                    </div>

										<div class="checkbox-fl mt-5">
										<ul class="checkbox-fl__list clb">
											<li class="checkbox-fl__item fl">
												<input type="checkbox" id="days_0" class="checkbox-v2" name="day[]" value="0">
												<label for="days_0">일요일</label>
											</li>
											<li class="checkbox-fl__item fl">
												<input type="checkbox" id="days_1" class="checkbox-v2" name="day[]" value="1">
												<label for="days_1">월요일</label>
											</li>
											<li class="checkbox-fl__item fl">
												<input type="checkbox" id="days_2" class="checkbox-v2" name="day[]" value="2">
												<label for="days_2">화요일</label>
											</li>
											<li class="checkbox-fl__item fl">
												<input type="checkbox" id="days_3" class="checkbox-v2" name="day[]" value="3">
												<label for="days_3">수요일</label>
											</li>
											<li class="checkbox-fl__item fl">
												<input type="checkbox" id="days_4" class="checkbox-v2" name="day[]" value="4">
												<label for="days_4">목요일</label>
											</li>
											<li class="checkbox-fl__item fl">
												<input type="checkbox" id="days_5" class="checkbox-v2" name="day[]" value="5">
												<label for="days_5">금요일</label>
											</li>
											<li class="checkbox-fl__item fl">
												<input type="checkbox" id="days_6" class="checkbox-v2" name="day[]" value="6">
												<label for="days_6">토요일</label>
											</li>
										</ul>
									</div>
									</td>
								</tr>

								<tr class="table-a__tr">
									<td class="table-a__td type-nobd type-right type-top  type-pop">
										<span>객실 선택</span>
									</td>
									<td class="table-a__td type-nobd type-left pd-r-50 type-pop">
										<p>
											<input type="checkbox" id="rooms_id_all" class="checkbox-v2">
											<label for="rooms_id_all">모두선택</label>
										</p>
										<div class="rchoice-group clb">
											<ul class="rchoice-group__list clb">
                                                @php
                                                    $ClientTypeRoom = \App\Models\ClientTypeRoom::where('user_id',$user_id)->get();
                                                @endphp
                                                @foreach($ClientTypeRoom as $k => $v)
                                                    <li class="rchoice-group__item fl">
                                                        <input type="checkbox" id="room_id_{{$k}}" class="checkbox-v2" data-idx="{{$k}}" name='room_id[{{$k}}]' value="{{$v->id}}">
                                                        <label for="room_id_{{$k}}">{{$v->room_name}}</label>
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
                        </form>
					</div>
				</div>
			</div>
		</div>
	</div>


<script>
    $(document).ready(function(){
        //할인판매 팝업 열기
       $(".js-pop-btn.js-type-sale-auto").click(function(){


            $(".js-pop-sale-auto").removeClass("bld-pop");
            $(".dim").show();
        });

        //팝업 닫기 공통
         $(".js-pop-close").click(function (e) {
            $(".pop-module").addClass("bld-pop");
            $(".dim").fadeOut(300);
        }); //배경클릭

        $(".pop-module__inbox").click(function (e) {
            e.stopPropagation();
        });
        $(".pop-module").click(function () {
            $(".pop-module").addClass("bld-pop");
            $(".dim").fadeOut(300);
        });
    });
</script>
