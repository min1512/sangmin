<script>
    $(document).ready(function(){
        //S::팝업 관련 스크립트
        //할인판매 팝업 열기
        $(".js-pop-btn.js-type-sale-add").click(function(){
            $(".js-pop-sale-add").removeClass("bld-pop");
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
        //E::팝업 관련 스크립트
    });
</script>


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
                $("form[name=discount_list]").attr("action", '/info/discount/save/');
                return true;
            } else {
                return false;
            }
        }else if(staff == "{{ $path[0] }}"){
            if (tcnt < 1 && tcnt1 <1 && tcnt3 <1) {

                $("form[name=discount_list]").attr("action", '{{url()->current()}}');
                return true;
            } else {
                return false;
            }
        }
    }



    $(function () {
        $('#room_id_all').change(function () {
            if($(this).is(":checked")){
                $("input[name^='room_id']").each(function () {
                    $(this).prop("checked",true);
                });
            }else{
                $("input[name^='room_id']").each(function () {
                    $(this).prop("checked",false);
                });
            }
        });

        $("input[name^='room_id']").change(function () {
            if($("input[name^='room_id']:checked").length == $("input[name^='room_id']").length ){
                $("#room_id_all").prop("checked",true);
            }else{
                $("#room_id_all").prop("checked",false);
            }
        });

        $('#day_all').change(function () {
            if($(this).is(":checked")){
                $("input[name^='day']").each(function () {
                    $(this).prop("checked",true);
                });
            }else{
                $("input[name^='day']").each(function () {
                    $(this).prop("checked",false);
                });
            }
        });

        $("input[name^='day']").change(function () {
            if($("input[name^='day']:checked").length == $("input[name^='day']").length ){
                $("#day_all").prop("checked",true);
            }else{
                $("#day_all").prop("checked",false);
            }
        });

    });

    $(function () {
        $("[id^='staff']").click(function () {
            var tmp = $(this).attr('id');
            if(tmp != "staff") { //수정 일 경우
                var season_id = $(this).data("season_id");
                $.ajax({
                    url: @if($client=="client") "/info/discount/view/{{$s->id}}" @else "/price/discount/view/{{$user_id}}/"+season_id @endif
                    , data: {
                        _token: "{{ csrf_token() }}",
                        user_id: {{ $user_id }},
                        discount_season_id: season_id
                    }
                    , type: "get"
                    , success: function (data) {
                        //할인추가 시 ID 값 입력
                        $("#discount_id").val(data.did);

                        //할인명
                        $('#discount_name').val(data.isset.discount_name);

                        //할인명 달력에 노출 체크
                        if (data.isset.flag_use == "Y") $("input:checkbox[id='discount_check']").prop("checked", true);
                        else $("input:checkbox[id='discount_check']").prop("checked", false);

                        //기간(직접입력, 기간참조)
                        $("input:radio[name='what_date'][value="+data.isset.season_check+"]").prop("checked", true);
                        if (data.isset.season_check == "Y") {
                            $('.db_right_now_add').hide();
                            $('.db_no_right_now_adds').show();
                        } else if (data.isset.season_check == "N") {
                            $('.db_right_now_add').show();
                            $('.db_no_right_now_adds').hide();
                        }

                        var html = "";
                        for (var i in data.ClientDiscountTerm) {
                            var item = data.ClientDiscountTerm[i];
                            html += "<input type='hidden' name='client_discount_term_id[]' value='" + item.id + "' />";
                            html += "<div class='table-a__inbox type-line db_right_now_add ta-l'>";
                            if (item.discount_start != null) {
                                html += "<p class='dp-wrap dp-ib type-able disable-wrap mr-5'>";
                                    html += "<input type='text' class='datepicker va-m noto db_right_now_add' name='start_season[]' id='discount_start_" + item.id + "' value=" + item.discount_start + ">";
                                html += "</p>";
                                html += " ~ ";
                                html += "<p class='dp-wrap dp-ib type-able disable-wrap ml-5'>";
                                    html += "<input type='text' class='datepicker va-m noto db_right_now_add' name='end_season[]' id='discount_end_" + item.id + "' value=" + item.discount_end + ">";
                                html += "</p> ";
                            } else {
                                html += "<p class='dp-wrap dp-ib type-able disable-wrap'><input type='text' class='datepicker va-m noto db_right_now_add' name='start_season[]'  id='discount_start_" + item.id + "'></p> ~ <p class='dp-wrap dp-ib type-able disable-wrap ml-5'><input type='text' class='datepicker va-m noto db_right_now_add' name='end_season[]' id='discount_end_" + item.id + "'></p> ";
                            }
                            html += "</div>";

                        }
                        $("#no_right_now_adds_list").html(html);

                        for (var i in data.ClientDiscountTerm) {
                            var item = data.ClientDiscountTerm[i].season_id;
                            $("input[name^='no_right_now_id']").each(function () {
                                if ($(this).val() == item) {
                                    $(this).prop("checked", true);
                                } else {
                                    $(this).prop("checked", false);
                                }
                            })
                        }

                        var html = "";
                        for (var i in data.ClientDiscountBanDate) {
                            var item = data.ClientDiscountBanDate[i];
                            html += "<div class=\"table-a__inbox type-line ta-l\">";
                                html += "<p class='dp-wrap dp-ib type-able disable-wrap mr-5'><input type=\"text\" class=\"datepicker va-m noto\" name='date_ban[]' value=" + item.date_ban + "></p>"
                                html += "<input type=\"checkbox\" name=\"\" id=\"aaa5_" + i + "\" class=\"checkbox-v2\"><label for=\"aaa5_" + i + "\">삭제</label>"
                            html += "</div>"
                        }
                        $("#ban_size").val(data.ClientDiscountBanDate.length);
                        $("#date_ban").html(html);

                        //요일 값 넣기

                        var date_array = data.isset.date;
                        var date_array = date_array.split(',');

                        var tmp_yoil = ['일', '월', '화', '수', '목', '금', '토'];

                        for (var i in tmp_yoil) {
                            if ($.inArray(i, date_array) > -1) $('#days_' + i).prop("checked", true);
                            else $('#days_' + i).prop("checked", false);
                        }
                        //여기서 끝

                        //다 체크 되면 전체 체크 박스 체크 되게...(요일)
                        if ($("input[name^='day']").length == $("input[name^='day']:checked").length) $("#day_all").prop("checked", true);
                        else $("#day_all").prop("checked", false);

                        //방 정보값 넣기
                        for (var i in data.ClientTypeRoom) {
                            var item = data.ClientTypeRoom[i];
                            if (item.discount_value != null) {
                                $('#room_id_' + i + '').prop("checked", true);
                                $('#discount_check_' + i + '').val(item.discount_value);
                                $('#char_' + i + '').val(item.unit+"|"+item.type);
                            } else {
                                $('#room_id_' + i + '').prop("checked", false);
                                $('#discount_check' + i + '').val(0);
                            }
                        }
                        //여기서 끝

                        //다 체크 되면 전체 체크 박스 체크 되게...(방)
                        if ($("input[name^='room_id']").length == $("input[name^='room_id']:checked").length) {
                            $("#room_id_all").prop("checked", true);
                        } else {
                            $("#room_id_all").prop("checked", false);
                        }

                        //처음에 할인명 달력에 노출할지 말지

                        $("input[name='discount_check']:checkbox").change(function () {
                            if ($(this).val() == "Y") {
                                $(this).prop("checked", false);
                                $(this).val("N");
                            } else if ($(this).val() == "N") {
                                $(this).prop("checked", true);
                                $(this).val("Y");
                            }
                        });

                        //상세내용
                        $("#simple").html(data.isset.simple);

                        pickerReload();
                    }
                });
            }
            else{ //신규등록 일 경우
                $("#discount_name").val('');
                $("input[name^='start_season']").val('');
                $("input[name^='end_season']").val('');
                $("input[name^='day']").prop("checked", false);
                $("input[name^='date_ban']").val('');
                $("input[name^='room_id']").prop("checked", false);

                $("input[id='term_check_N']").prop("checked", true);
                $('.db_right_now_add').show();
                $('.db_no_right_now_adds').hide();

                $("input[name^='no_right_now_id']").each(function () {
                    $(this).prop("checked", false);
                });

                $("input[name='discount_check']:checkbox").change(function () {
                    if ($(this).val() == "Y") {
                        $(this).prop("checked", false);
                        $(this).val("N");
                    } else if ($(this).val() == "N") {
                        $(this).prop("checked", true);
                        $(this).val("Y");
                    }
                })
                $("input[id^='discount_check']").val('');
                $("input[id^='client_discount_term_id']").val('');

                var html = "";
                html += "<input type='hidden' name='client_discount_term_id[]' />";
                    html += "<div class='table-a__inbox type-line db_right_now_add ta-l'>";
                    html += "<p class='dp-wrap dp-ib type-able disable-wrap mr-5'><input type='text' class='datepicker va-m noto db_right_now_add' name='start_season[]' /></p> ~ <p class='dp-wrap dp-ib type-able disable-wrap ml-5'><input type='text' class='datepicker va-m noto db_right_now_add' name='end_season[]' /></p> ";
                html += "</div>";
                $("#no_right_now_adds_list").html(html);

                var html = "";
                html += "<div class=\"table-a__inbox type-line ta-l\">";
                    html += "<p class='dp-wrap dp-ib type-able disable-wrap mr-5'><input type=\"text\" class=\"datepicker va-m noto\" name='date_ban[]' /></p>"
                    html += "<input type=\"checkbox\" name=\"\" id=\"aaa5\" class=\"checkbox-v2\"><label for=\"aaa5\">삭제</label>"
                html += "</div>"

                $("#date_ban").html(html);

                pickerReload();
            }
        })
    })
</script>
<script>
    $(function () {
        $(".delete_discount").click(function () {
            confirm('정말 삭제 하시겠습니까?');
            var delete_season_id = $(this).val();
            $.ajax({
                url: @if($client=="client")  "/info/discount/view/{{$s->id}}" @else "/price/discount/delete/{{$user_id}}/"+delete_season_id+""  @endif,
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
<script>
    $(function () {
        $("#char").change(function () {
            var value = $(this).val();
            $("input[id^='room_id_']").each(function () {
                var id = $(this).attr("id");
                var k = id.replace("room_id_","");
                if($("input:checkbox[id='room_id_"+k+"']").is(":checked")==true){
                    $('#char_'+k+'').val(value);
                }
            })
        })
    })
</script>
<script>
    $(function () {
        $('.c-777').click(function () {
            var value = $('#value_change').val();
            $("input[id^='discount_check_']").val(value);
        })
    })
</script>
<script>
    $(function () {
        $("input[name='what_date']:radio").change(function () {
            var wha_date = $(this).val();
            if(wha_date=='N'){
                $('.db_right_now_add').show();
                $('.db_no_right_now_adds').hide();
                $("input[name^='no_right_now_id']").each(function () {
                    $(this).prop("checked",false);
                })
            }else if (wha_date=='Y') {
                $('.db_right_now_add').hide();
                $('.db_no_right_now_adds').show();
            }
        });
    })
</script>
<script>
	function ban_add(){
	    var ord = $("input[name='date_ban[]']").length;
		$("#date_ban").append("<div class='table-a__inbox type-line ta-l'>\n" +
            "        <p class='dp-wrap dp-ib type-able disable-wrap'><input type='text' class='datepicker va-m noto' name=\"date_ban[]\"></p>\n" +
            "        <input type='checkbox' name=\"\" id='aaa5_"+ord+"' class='checkbox-v2'>" +
            "        <label for='aaa5_"+ord+"'>삭제</label>\n" +
        "        </div>");
		pickerReload();
	}
</script>



<div class="row">
    <div class="main-card mb-3 card" style="width:100%; ">
        <div class="card-body"><h5 class="card-title bld">Season List</h5>
           <div class="table-a noto">
        <div class="table-a__head clb">
            <p class="table-a__tit fl">할인 판매 설정</p>
            <div class="table-a_inbox type-head fr">
{{--                <button type="button" class="btn-v1 js-pop-btn js-type-sale-add" onclick="goUrl('{{ isset($client) && $client=="client"? route('info.discount.view',['did'=>isset($did)?$did:""]) : route('price.discount.view',['user_id'=>isset($user_id)?$user_id:"", 'did'=>isset($did)?$did:""]) }}');" >할인 추가</button>--}}
                <button type="button" id="staff" class="btn-v1 status-rb js-pop-btn js-type-sale-add">할인 추가</button>
            </div>
        </div>
        <form>
        <table class="table-a__table">
            <tr class="table-a__tr type-th">
                <th class="table-a__th">번호</th>
                <th class="table-a__th">할인명</th>
                <th class="table-a__th">할인 기간</th>
                <th class="table-a__th">할인 요일</th>
                <th class="table-a__th">할인명 노출</th>
                <th class="table-a__th">상세내용</th>
                <th class="table-a__th">관리</th>
            </tr>
            @php $date = ['일','월','화','수','목','금','토']; @endphp
            @foreach($discountList as $k=>$s)
                <tr class="table-a__tr">
                    <td class="table-a__td">
                        <div class="table-a__inbox">
                            <span>{{$k+1}}</span>
                        </div>
                    </td>
                    <td class="table-a__td type-td-point js-pop-btn js-type-sale-add">
                        <div class="table-a__inbox">
                            <span class="type-point type-line">
                                <a id="staff_{{$k}}" data-season_id="{{$s->id}}">{{$s->discount_name}}</a>
                            </span>
                        </div>
                    </td>
                    <td class="table-a__td">
                        <div class="table-a__inbox">
                            <span>{{$s->discount_start}} ~ {{$s->discount_end}}</span>
                        </div>
                    </td>
                    <td class="table-a__td">
                        <div class="table-a__inbox">
                            <span>
                                @php
                                    $tmp_yoil = [];
                                    $date_array = explode(',',$s->date);
                                    foreach ($date as $k => $v){
                                        if(in_array($k,$date_array)){
                                            $tmp_yoil[] = $v;
                                        }
                                    }
                                    echo join(",",$tmp_yoil);
                                @endphp
                            </span>
                        </div>
                    </td>
                    <td class="table-a__td">
                        <div class="table-a__inbox">
                            <span>{{$s->flag_use}}</span>
                        </div>
                    </td>
                    <td class="table-a__td" style="white-space:normal">
                        <div class="table-a__inbox ta-l">
                            <span class="" style="width:100%">{{$s->simple}}</span>
                        </div>
                    </td>

                    <td class="table-a__td">
                        <div class="table-a__inbox">
                            <button type="button" class="table-a__btn btn-v2 delete_discount" value="{{$s->id}}">삭제</button>
                        </div>
                    </td>
                </tr>
            @endforeach
            <tfoot>
            <tr><td colspan="7">{{$discountList->links('admin.pc.pagination.default')}}</td></tr>
            </tfoot>
        </table>
        </form>
{{--
        <div class="btn-wrap type-fg">
            <button type="button" class="btn-v4 type-save">저장</button>
        </div>
--}}
    </div>

<!--            팝업-->
<div class="pop-module js-pop js-pop-sale-add bld-pop">
    <div class="pop-module__wrap">
        <div class="pop-module__box">
            <div class="pop-module__inbox" style="width:746px;">
                <div class="pop-module__head clb">
                    <span class="pop-module__tit fl">할인 추가하기</span>
                    <button type="button" class="pop-module__close fr js-pop-close">닫기</button>
                </div>
                <div class="pop-module__body type-full" style="overflow: auto; height: 700px;">
                    <form method='post' name='discount_list' class='client_form' onSubmit="return check_all()" >
                        {{csrf_field()}}
                    <div class="table-a noto">
                        <table class="table-a__table type-top">
                            <colgroup>
                                <col width="120px">
                                <col width="">
                            </colgroup>
                            <tr class="table-a__tr">
                                <input type="hidden" name="discount_id" id="discount_id" />

                                <td class="table-a__td type-nobd type-right pd-l-50 type-pop"><span id="">할인명</span></td>
                                <td class="table-a__td type-nobd type-left pd-r-50 type-pop">
                                    <div class="input-wrap dp-ib" style="width:325px;">
                                        <input type="text" class="input-v1" id="discount_name" name="discount_name">
                                    </div>
                                    <p class="dp-ib ml-10">
                                        <input type="checkbox" name="discount_check" id="discount_check" class="checkbox-v2" value="Y" /><label for="discount_check">할인명 달력에 노출함</label>
                                    </p>
                                </td>
                            </tr>
                            <tr class="table-a__tr">
                                <td class="table-a__td type-nobd type-right pd-l-50 type-pop"><span>기간</span></td>
                                <td class="table-a__td type-nobd type-left pd-r-50 type-pop">
                                    <ul class="two-radio__list clb">
                                        <li class="two-radio__item fl">
                                            <input type="radio" id="term_check_N" class="radio-v1 dp-ib" name="what_date" value="N" />
                                            <label for="term_check_N">직접입력</label>
                                        </li>
                                        <li class="two-radio__item fl">
                                            <input type="radio" id="term_check_Y" class="radio-v1 dp-ib" name="what_date" value="Y"  />
                                            <label for="term_check_Y" class="">기간참조</label>
                                        </li>
                                    </ul>
                                </td>
                            </tr>
                            <tr class="table-a__tr db_right_now_add" >
                                <td class="table-a__td type-nobd type-right type-top pd-l-50 type-pop db_right_now_add">
                                    <span class="">직접입력</span>
                                </td>
                                <td class="table-a__td type-nobd type-pop type-left db_right_now_add">
                                    <div class="table-a__inbox type-line db_right_now_add ta-l" id="no_right_now_adds_list">

                                    </div>
                                </td>
                            </tr>

                            <tr class="table-a__tr db_no_right_now_adds">
                                <td class="table-a__td type-nobd type-right type-top pd-l-50 type-pop db_no_right_now_adds">
                                    <span class="">기간참조</span>
                                </td>
                                <td class="table-a__td type-nobd type-pop type-left db_no_right_now_adds">
                                    <ul class="ref-period db_no_right_now_adds">
                                        @foreach($ClientSeasonTerm as $k => $v)
                                            <li class="ref-period__item ta-l">
                                                <p class="dp-ib" style="width:84px;">
                                                    <input type="checkbox" name="no_right_now_id[{{$k}}]" id='no_right_now_id_{{$k}}'  value="{{$v->season_id}}" class="checkbox-v2">
                                                    <label for="no_right_now_id_{{$k}}">
                                                        {{$v->season_name}}
                                                    </label>
                                                </p>
                                                {{$v->season_start}} ~ {{$v->season_end}}
                                            </li>
                                        @endforeach
                                    </ul>
                                </td>
                            </tr>

                            <tr class="table-a__tr">
                                <td class="table-a__td type-nobd type-right type-top pd-l-50 type-pop">
                                    <input type="hidden" id="ban_size">
                                    <p>제외날짜</p>
                                    <p><button type="button" class="btn-v2 type-icon type-add mt-5" onclick="ban_add();">추가</button></p>
                                </td>
                                <td class="table-a__td type-nobd type-pop type-left">
                                    <ul class="ref-period">
                                        <li class="ref-period__item ta-l" id="date_ban">

                                        </li>
                                    </ul>
                                </td>
                            </tr>
                            <tr class="table-a__tr">
                                <td class="table-a__td type-nobd type-right type-top pd-l-50 type-pop">
                                    <span class="">할인 요일</span>
                                </td>
                                <td class="table-a__td type-nobd type-pop type-left">
                                    <div class="input-wrap" >
                                        <input type="checkbox" id="day_all" class="checkbox-v2">
                                        <label for="day_all">요일 전체 선택</label>
                                    </div>
                                    <div class="checkbox-fl dp-ib ml-10">
                                        <ul class="checkbox-fl__list clb">
                                            <li class="checkbox-fl__item fl type-5">
                                                <input type='checkbox' id='days_0' class='checkbox-v2' name="day[]" value='0'>
                                                <label for="days_0">일요일</label>
                                            </li>
                                            <li class="checkbox-fl__item fl type-5">
                                                <input type='checkbox' id='days_1' class='checkbox-v2' name="day[]" value='1'>
                                                <label for="days_1">월요일</label>
                                            </li>
                                            <li class="checkbox-fl__item fl type-5">
                                                <input type='checkbox' id='days_2' class='checkbox-v2' name="day[]" value='2'>
                                                <label for="days_2">화요일</label>
                                            </li>
                                            <li class="checkbox-fl__item fl type-5">
                                                <input type='checkbox' id='days_3' class='checkbox-v2' name="day[]" value='3'>
                                                <label for="days_3">수요일</label>
                                            </li>
                                            <li class="checkbox-fl__item fl type-5">
                                                <input type='checkbox' id='days_4' class='checkbox-v2' name="day[]" value='4'>
                                                <label for="days_4">목요일</label>
                                            </li>
                                            <li class="checkbox-fl__item fl type-5">
                                                <input type='checkbox' id='days_5' class='checkbox-v2' name="day[]" value='5'>
                                                <label for="days_5">금요일</label>
                                            </li>
                                            <li class="checkbox-fl__item fl type-5">
                                                <input type='checkbox' id='days_6' class='checkbox-v2' name="day[]" value='6'>
                                                <label for="days_6">토요일</label>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            <tr class="table-a__tr">
                                <td class="table-a__td type-nobd type-right pd-l-50 type-pop" rowspan="2">
                                    <span>객실선택</span>

                                </td>
                                <td class="table-a__td type-nobd type-left type-pop" >
                                    <div class="dp-ib  lh-28" >
                                        <p class="room-chk__chk dp-ib" style="width:150px;">
                                            <input type="checkbox" id="room_id_all" class="checkbox-v2" value="Y">
                                            <label for="room_id_all">룸 전체 선택</label>
                                        </p>
                                    </div>
                                    <div class="input-wrap ml-10" style="width:150px;">
                                        <input type="text" class="input-v1" id="value_change" />
                                    </div>
                                        <div class="input-wrap ml-10" style="width:150px;">
                                            <div class="select-wrap">
                                                <select id="char" class="select-v1 noto">
                                                    <option value="%|discount" selected>정률 할인(%)</option>
                                                    <option value="원|fixed">고정가 판매(원)</option>
                                                    <option value="원|discount">할인 판매(원)</option>
                                                </select>
                                            </div>
                                        </div>
                                    <button type="button" class="btn-v2 va-m fr c-777">적용</button>
                                </td>
                            </tr>
                            <tr class="table-a__tr">
                                <td class="table-a__td type-nobd type-left  type-pop">
                                    <div class="room-chk">
                                        <ul class="room-chk__list" id="room_list">
                                            @foreach($ClientTypeRoom as $k => $v)
                                                <li class="room-chk__item clb">
                                                    <p class="room-chk__chk dp-ib" style="width:150px;">
                                                        <input type="checkbox" id="room_id_{{$k}}"  data-idx="{{$k}}" class="checkbox-v2" name="room_id[{{$k}}]" value='{{$v->id}}'>
                                                        <label for="room_id_{{$k}}">
                                                            {{$v->room_name}}
                                                        </label>
                                                    </p>
                                                    <div class="input-wrap ml-10 va-m" style="width:150px;">
                                                        <input type="text" class="input-v1" name='discount[{{$k}}]' id='discount_check_{{$k}}' value="">
{{--                                                        <span class="c-777" id="change_char[{{$k}}]"></span>--}}
                                                    </div>
                                                    <div class="select-wrap dp-ib va-m ml-10" style="width:150px;">
                                                        <select id="char_{{$k}}" name="char[{{$k}}]" class="select-v1 noto">
                                                            <option value="%|discount" selected>정률 할인(%)</option>
                                                            <option value="원|fixed">고정가 판매(원)</option>
                                                            <option value="원|discount">할인 판매(원)</option>
                                                        </select>
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="table-a__td type-nobd type-right pd-l-50 type-pop">
                                    <span>상세내용</span>
                                </td>
                                <td class="table-a__td type-nobd type-left type-pop pd-lr-0" >
                                    <textarea name="simple" id="simple" cols="30" rows="10" class="textarea-v1"></textarea>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="btn-wrap mt-10">
                        <button type="submit" class="btn-v4 type-save" id="submit" >저장</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
        </div>
    </div>
</div>




{{--<table class="mb-0 table table-hover" style="width: 1000px;">--}}
{{--    <tr>--}}
{{--        <th>할인명</th>--}}
{{--        <th>할인 기간</th>--}}
{{--        <th>할인 요일</th>--}}
{{--        <th>할인명 노출</th>--}}
{{--        <th>상세 내용</th>--}}
{{--        <th><a id="delete_discount" name="delete_discount" class="mr-2 btn btn-info" style="color: white;">할인 삭제</a></th>--}}
{{--        <th><button class="mr-2 btn btn-focus" onclick="goUrl('{{ isset($client) && $client=="client"? route('info.discount.view',['did'=>isset($did)?$did:""]) : route('price.discount.view',['user_id'=>isset($user_id)?$user_id:"", 'did'=>isset($did)?$did:""]) }}');">할인 추가</button></th>--}}
{{--    </tr>--}}
{{--    @foreach($discountList as $k=>$s)--}}
{{--        <tr>--}}
{{--            <td>{{$k+1}}</td>--}}
{{--            <td>--}}
{{--                @if($client=="client")--}}
{{--                    <a href="/info/discount/view/{{$s->id}}">{{$s->discount_name}}</a>--}}
{{--                @else--}}
{{--                    <a href="/price/discount/view/{{$user_id}}/{{$s->id}}">{{$s->discount_name}}</a>--}}
{{--                @endif--}}

{{--            </td>--}}
{{--            <td>{{$s->discount_start}} ~ {{$s->discount_end}}</td>--}}
{{--            <td>--}}
{{--                @php--}}
{{--                    $date_array = explode(',',$s->date);--}}
{{--                    for ($i=0; $i<sizeof($date_array); $i++){--}}
{{--                        if($date_array[$i]==1){--}}
{{--                            echo "월,";--}}
{{--                        }elseif ($date_array[$i]==2){--}}
{{--                            echo "화,";--}}
{{--                        }elseif ($date_array[$i]==3){--}}
{{--                            echo "수,";--}}
{{--                        }elseif ($date_array[$i]==4){--}}
{{--                            echo "목,";--}}
{{--                        }elseif ($date_array[$i]==5){--}}
{{--                            echo "금,";--}}
{{--                        }elseif ($date_array[$i]==6){--}}
{{--                            echo "토,";--}}
{{--                        }elseif ($date_array[$i]==0){--}}
{{--                            echo "일";--}}
{{--                        }--}}
{{--                    }--}}
{{--                @endphp--}}
{{--            </td>--}}
{{--            <td>{{$s->flag_use}}</td>--}}
{{--            <td></td>--}}
{{--            <td colspan="2"></td>--}}
{{--        </tr>--}}
{{--    @endforeach--}}
{{--    <tr>--}}
{{--        <th id="add_discount_list"></th>--}}
{{--    </tr>--}}
{{--</table>--}}
