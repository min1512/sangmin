@extends("admin.pc.layout.basic")

@section("title")숙박업체@endsection

@section("scripts")
    <script>

        $(function () {
            $("#facility_all").click(function () {
                if($(this).is(":checked")==true){
                    $("input[name^='facility']").each(function () {
                        $(this).prop("checked",true);
                    })
                }else if($(this).is(":checked")==false){
                    $("input[name^='facility']").each(function () {
                        $(this).prop("checked",false);
                    })
                }
            })
        })

        $(function () {
            $("input[name^='facility']").click(function () {
                $("input[name^='facility']").each(function () {
                    oneCheck($(this));
                })
            })
        })

        function oneCheck(a){
            if($(a).prop("checked")){
                var checkBoxLength = $("input[name^='facility']").length;
                var checkedLength = $("input[name^='facility']:checked").length;
                if(checkBoxLength==checkedLength){
                    $("#facility_all").prop("checked", true);
                }else{
                    $("#facility_all").prop("checked", false);
                }
            }else{
                $("#facility_all").prop("checked", false);
            }
        }

        var ord = {{ sizeof($room_name)>0?sizeof($room_name):0 }};
        $(function () {
            $('#num1').click(function () {
                var num = $('#num').val();
                for (var i = 0; i < num; i++) {
                    $('#num_plus').append(
                        "<div class=\"position-relative form-group\" style='border: 1px solid red;'>\n" +
                        "<div class=\"position-relative form-group\">\n" +
                        "<input type='hidden' name='room_num["+ord+"]' value=" + num + ">\n" +
                        "</div>\n" +
                        "<div class=\"position-relative form-group\">\n" +
                        "객실명\n" +
                        "<input type='text' name='room_name["+ord+"]'>\n" +
                        "</div>\n"+
                        "<div class=\"position-relative form-group\">\n" +
                        "실시간 예약\n" +
                        "<input type='radio' name='now["+ord+"]' value='Y'>판매 <input type='radio' name='now["+ord+"]' value='N'>판매안함\n" +
                        "</div>\n"+
                        "<div class=\"position-relative form-group\">\n" +
                        "온라인 판매 대행\n" +
                        "<input type='radio' name='online["+ord+"]' value='Y'>판매 <input type='radio' name='online["+ord+"]' value='N'>판매안함\n" +
                        "</div>\n"+
                        "<input type='button' class=\"mt-1 btn btn-primary\" name='delete["+ord+"]' value='삭제' onclick='$(this).parent().remove()'>\n" +
                        "</div>"
                    );
                    ord++;
                }
            });
        });
    </script>

    <script>
        var ord = {{ sizeof($room_name)>0?sizeof($room_name):0 }};
        $(function () {
            $('#num1').click(function () {
                var num = $('#num').val();
                for (var i = 0; i < num; i++) {
                    $('#num_plus1').append(
                        "<tr class=\"table-a__tr\">"+
                            "<td class=\"table-a__td type-grey\">"+
                                "<input type='hidden' name='room_num["+ord+"]' />" +
                                "<span class=\"table-a__span type-1\">객실명</span>"+
                                "<div class=\"input-wrap ml-10\" style=\"max-width:160px;\">"+
                                    "<input type=\"text\" name=\"room_name["+ord+"]\" id=\"room_name["+ord+"]\" class=\"input-v1 ta-l\">"+
                                "</div>"+
                                "<input type=\"checkbox\" name=\"chkAll["+ord+"]\" id=\"del_"+ord+"\" class=\"checkbox-v1\" ><label for=\"del_"+ord+"\" class=\" ml-10\">삭제</label>"+
                            "</td>"+
                            "<td class=\"table-a__td\">"+
                                "<span class=\"table-a__span type-2\">온라인 판매</span>"+
                                "<input type=\"radio\" id=\"on1_"+ord+"\" class=\"radio-v1 dp-ib\" name=online["+ord+"] value=\"Y\">"+
                                "<label for=\"on1_"+ord+"\" class=\"ml-20\">판매</label>"+
                                "<input type=\"radio\" id=\"on2_"+ord+"\" class=\"radio-v1 dp-ib\" name=online["+ord+"] value=\"N\" >"+
                                "<label for=\"on2_"+ord+"\" class=\"ml-20\">판매 안함</label>"+
                            "</td>"+
                            "<td class=\"table-a__td\">"+
                                "<span class=\"table-a__span type-2\">실시간 예약</span>"+
                                "<input type=\"radio\" id=\"on3_"+ord+"\" class=\"radio-v2\" name=\"now["+ord+"]\" value=\"Y\"  >"+
                                "<label for=\"on3_"+ord+"\" class=\"ml-20\">판매</label>"+
                                "<input type=\"radio\" id=\"on4_"+ord+"\" class=\"radio-v2\" name=\"now["+ord+"]\" value=\"N\" >"+
                                "<label for=\"on4_"+ord+"\" class=\"ml-20\">판매 안함</label>"+
                            "</td>"+
                         "</tr>"
                        // "<div class=\"position-relative form-group\" style='border: 1px solid red;'>\n" +
                        // "<div class=\"position-relative form-group\">\n" +
                        // "<input type='hidden' name='room_num["+ord+"]' value=" + num + ">\n" +
                        // "</div>\n" +
                        // "<div class=\"position-relative form-group\">\n" +
                        // "객실명\n" +
                        // "<input type='text' name='room_name["+ord+"]'>\n" +
                        // "</div>\n"+
                        // "<div class=\"position-relative form-group\">\n" +
                        // "실시간 예약\n" +
                        // "<input type='radio' name='now["+ord+"]' value='Y'>판매 <input type='radio' name='now["+ord+"]' value='N'>판매안함\n" +
                        // "</div>\n"+
                        // "<div class=\"position-relative form-group\">\n" +
                        // "온라인 판매 대행\n" +
                        // "<input type='radio' name='online["+ord+"]' value='Y'>판매 <input type='radio' name='online["+ord+"]' value='N'>판매안함\n" +
                        // "</div>\n"+
                        // "<input type='button'  name='delete["+ord+"]' value='삭제' onclick='$(this).parent().remove()'>\n" +
                        // "</div>"
                    );
                    ord++;
                }
            });
        });
        var size = {{ sizeof($file)>0?sizeof($file):0 }};
        $(function () {
            $('.room_add').click(function () {
                var imgHtml = "";
                imgHtml += "<li class='add-img__item fl'>";
                imgHtml += "<input type='hidden' name='file_data["+size+"]' value='' />";
                imgHtml += "<input type='hidden' id='file_name_"+size+"' name='file_name["+size+"]' />";
                imgHtml += "<div class='add-img__imgbox'>";
                imgHtml += "<img src='' style='width:100px; height:100px;' id='preview_"+size+"' />";
                imgHtml += "</div>";
                imgHtml += "<input type='file' name='file["+size+"]' class='img-input bld' onchange=\"readURL(this, "+size+");\" >";
                imgHtml += "<p class='add-img__tit ellipsis' title='이미지명입니다' id='image_name_"+size+"'>&nbsp;</p>";
                imgHtml += "<p class='img_del btn-v2 type-icon type-del' onclick=\"$(this).parents('li').remove()\">삭제</p>";
                imgHtml += "</li>";

                $(".add-img__list").append(imgHtml);
                size++;
            });
        })
        $(".img_del").click(function(){
            console.log(1);
            $(this).parents("li").remove();
        });
        function file_change(file){
            var str=file.lastIndexOf("\\")+1;	//파일 마지막 "\" 루트의 길이 이후부터 글자를 잘라 파일명만 가져온다.
            file = file.substring(str, file.length);
            document.getElementById('fileName').value=file;
        }

        function readURL(input,size) {
            console.log(size);
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#preview_'+size).attr('src', e.target.result);
                }
                console.log($('#image_name_'+size).text());
                $('#image_name_'+size).text(input.files[0].name);
                $('#file_name_'+size).val(input.files[0].name);
                console.log($('#image_name_'+size).text());
                console.log(input.files[0].name);

                reader.readAsDataURL(input.files[0]);
            }
        }

        $('#file').change(function(){
            readURL(this);
        });

        function newOpen(obj) {
            $('#preview3 img').attr("src",$(obj).attr("src"));
            $('#preview3').show();
            $('#close').click(function () {
                $('#preview3').hide();
            })
        };
    </script>

    <script>
        function delete_room_list(id) {
            var id = id;
            $("#room_list_"+id+"").hide();
        }
    </script>
@endsection

@section("styles")
    <link rel="stylesheet" href="http://staff.einet.co.kr/asset/css/common-b.css?v=<?=time()?>">
<link rel="stylesheet" href="http://staff.einet.co.kr/asset/css/blade.css?v=<?=time() ?>">
@endsection

@section("contents")
    @include("admin.pc.include.price.season_search",['search'=>isset($search)?$search:[]])
    <div class="row">
        <div class="main-card card" style="width:100%; ">
            <div class="card-body"><h5 class="card-title bld">Controls Types</h5>
                @php
                    $path = $_SERVER["HTTP_HOST"];
                    $path = explode(".",$path);
                    $path = $path[0];
                @endphp
                @if($path=="client")
                <form method="post" name="rooms" class="client_form" action="/info/room/view/save" enctype="multipart/form-data">
                @else
                    <form method="post" name="rooms" class="client_form" action="{{url()->current()}}"  enctype="multipart/form-data">
                @endif
                {{ csrf_field() }}
                <input type="hidden" name="user_id" value="{{isset($user_id)?$user_id:""}}" />
                <input type="hidden" name="type_id" value="{{isset($type_id)?$type_id:""}}" />
               <div>
					<div class="table-a noto">
						<div class="table-a__head clb">
							<p class="table-a__tit fl">Room List</p>
							<div class="table-a_inbox type-head fr">
								<button type="button" class="btn-v1">변경</button>
							</div>
						</div>
						<table class="table-a__table type-top">
						 	<colgroup>
								<col width="13%">
								<col width="*">
								<col width="13%">
								<col width="*">
								<col width="13%">
								<col width="*">
						 	</colgroup>

							<tr class="table-a__tr">
								<td class="table-a__td type-nobd type-right type-top lh-28">
									그룹명
								</td>
								<td colspan="5" class="table-a__td type-nobd type-left">
									<div class="input-wrap" style="width:150px;">
										<input type="text"  name="type_name"  class="input-v1 ta-r" value="{{isset($ClientRoom)?$ClientRooms[0]->type_name:""}}">
									</div>
								</td>
							</tr>
							<tr class="table-a__tr">
								<td class="table-a__td type-nobd type-right type-top lh-28">
									객실 수
								</td>
								<td colspan="5" class="table-a__td type-nobd type-left">
									<div class="input-wrap" style="width:48px;">
										<input type="text" class="input-v1 ta-r" name="num" id="num" value="{{isset($ClientRoom)?$ClientRooms[0]->num:""}}">
									</div> 개
									<button type="button" class="btn-v2 fr" id="num1" name="num1" value="0">판매객실 추가</button>

									<div class="table-a__inbox type-table">
										<table class="table-a__table type-inner" id="num_plus1">
                                            @foreach($room_name as $t => $v)
                                            <input type="hidden" name="room_num[{{$t}}]" id="room_num[{{$t}}]" class="form-control" value='{{isset($room_name)?$v->id:""}}' />
											<tr class="table-a__tr" id="room_list_{{$t}}">
												<td class="table-a__td type-grey">
													<span class="table-a__span type-1">객실명</span>
													<div class="input-wrap ml-10" style="max-width:160px;">
														<input type="text" name="room_name[{{$t}}]" id="room_name_{{$t}}" class="input-v1 ta-l" value="{{isset($room_name)?$v->room_name:""}}">
													</div>
													<input type="checkbox" name="chkAll[{{$t}}]" id="del_{{$t}}" class="checkbox-v1"><label for="del_{{$t}}" class=" ml-10" onclick="delete_room_list({{$t}});">삭제</label>
												</td>
												<td class="table-a__td">
													<span class="table-a__span type-2">온라인 판매</span>
													<input type="radio" id="on1_{{$t}}" class="radio-v1 dp-ib" name="online[{{$t}}]" value="Y" {{ isset($v->flag_online)&&$v->flag_online=="Y"?"checked":"" }}>
                                                    <label for="on1_{{$t}}" class="ml-20">판매</label>
                                                    <input type="radio" id="on2_{{$t}}" class="radio-v1 dp-ib" name="online[{{$t}}]" value="N" {{ isset($v->flag_online)&&$v->flag_online=="N"?"checked":"" }}>
                                                    <label for="on2_{{$t}}" class="ml-20">판매 안함</label>
												</td>
												<td class="table-a__td">
													<span class="table-a__span type-2">실시간 예약</span>
													<input type="radio" id="on3_{{$t}}" class="radio-v2" name="now[{{$t}}]" value="Y"  {{ isset($v->flag_realtime)&&$v->flag_realtime=="Y"?"checked":"" }}>
                                                    <label for="on3_{{$t}}" class="ml-20">판매</label>
                                                    <input type="radio" id="on4_{{$t}}" class="radio-v2" name="now[{{$t}}]" value="N" {{ isset($v->flag_realtime)&&$v->flag_realtime=="N"?"checked":"" }}>
                                                    <label for="on4_{{$t}}" class="ml-20">판매 안함</label>
												</td>
											</tr>
                                            @endforeach
										</table>
									</div>

								</td>
							</tr>
							<tr class="table-a__tr">
								<td class="table-a__td type-nobd type-right type-top lh-28">객실 크기</td>
								<td colspan="5" class="table-a__td type-nobd type-left">
									<div class="input-wrap" style="width:48px;">
										<input type="text"  name="room_area"  id="room_area"  class="input-v1 ta-r" value="{{isset($ClientRoom)?$ClientRooms[0]->room_area:""}}">
									</div> 평
								</td>
							</tr>
							<tr class="table-a__tr">
								<td class="table-a__td type-nobd type-right type-top lh-28">객실 형태</td>
								<td colspan="5" class="table-a__td type-nobd type-left">
									<div class="table-a__inbox type-left">
                                        @if($ClientRoom != "")
                                            <input type="radio" id="room_shape_1"  class="radio-v1 dp-ib" name="room_shape" value="Poisonous" @if(($ClientRooms[0]->room_shape)=="Poisonous")checked="checked"@endif />
                                            <label for="room_shape_1" class="">독채형</label>
                                            <input type="radio" id="room_shape_2" class="radio-v1 dp-ib" name="room_shape"  value="Ventral" @if(($ClientRooms[0]->room_shape)=="Ventral")checked="checked"@endif />
                                            <label for="room_shape_2" class="ml-20">복층형</label>
                                            <input type="radio" id="room_shape_3"  class="radio-v1 dp-ib" name="room_shape" value="One-room-type" @if(($ClientRooms[0]->room_shape)=="One-room-type")checked="checked"@endif />
                                            <label for="room_shape_3" class="ml-20">원룸형</label>
                                            <input type="radio" id="room_shape_4" class="radio-v1 dp-ib" name="room_shape" value="Detachable" @if(($ClientRooms[0]->room_shape)=="Detachable")checked="checked"@endif>
                                            <label for="room_shape_4" class="ml-20">분리형</label>
                                        @elseif($ClientRoom =="")
                                            <input type="radio" id="room_shape_1" class="radio-v1 dp-ib" name="room_shape" value="Poisonous" checked="checked">
                                            <label for="room_shape_1" class="">독채형</label>
                                            <input type="radio" id="room_shape_2" class="radio-v1 dp-ib" name="room_shape" value="Ventral" checked="">
                                            <label for="room_shape_2" class="ml-20">복층형</label>
                                            <input type="radio" id="room_shape_3" class="radio-v1 dp-ib" name="room_shape" value="One-room-type" checked="">
                                            <label for="room_shape_3" class="ml-20">원룸형</label>
                                            <input type="radio" id="room_shape_4" class="radio-v1 dp-ib" name="room_shape" value="Detachable" checked="">
                                            <label for="room_shape_4" class="ml-20">분리형</label>
                                        @endif
									</div>
								</td>
							</tr>
							<tr class="table-a__tr">
								<td class="table-a__td type-nobd type-right type-top lh-28">객실 내부</td>
                                @php
                                    $type_facility = \App\Http\Controllers\Controller::getCode('inner');
                                @endphp
								<td colspan="5" class="table-a__td type-nobd type-left">
									<div class="select-list">
										<dl class="clb select-list__dl">
                                            @foreach($type_facility as $c)
                                                <?php
                                                    $name = $c->code;
                                                    $name = str_replace("inner_","",$name);
                                                ?>
                                                <dt class="fl select-list__dt">{{$c->name}}</dt>
                                                <dd class="fl select-list__dd">
                                                    <div class="input-wrap">
                                                        <div class="select-wrap">
                                                            @if($ClientRoom != "")
                                                            <select name="{{$c->code}}" id="{{$c->code}}" class="select-v1 noto">
                                                                <option value="1" @if($ClientRooms[0]->$name == 1) selected @endif >1</option>
                                                                <option value="2" @if($ClientRooms[0]->$name == 2) selected @endif >2</option>
                                                                <option value="3" @if($ClientRooms[0]->$name == 3) selected @endif >3</option>
                                                                <option value="4" @if($ClientRooms[0]->$name == 4) selected @endif >4</option>
                                                                <option value="5" @if($ClientRooms[0]->$name == 5) selected @endif >5</option>
                                                            </select>
                                                            @else
                                                                <select name="{{$c->code}}" id="{{$c->code}}" class="select-v1 noto">
                                                                    <option value="1">1</option>
                                                                    <option value="2">2</option>
                                                                    <option value="3">3</option>
                                                                    <option value="4">4</option>
                                                                    <option value="5">5</option>
                                                                </select>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </dd>
                                            @endforeach
										</dl>
									</div>
								</td>
							</tr>
							<tr class="table-a__tr">
								<td class="table-a__td type-nobd type-right type-top lh-28">객실 시설</td>
								<td colspan="5" class="table-a__td type-nobd type-left">
									<p>
										<input type="checkbox" id="facility_all" class="checkbox-v2" name="">
										<label for="facility_all">모두선택</label>
									</p>
                                    @php
                                        $type_facility = \App\Http\Controllers\Controller::getCode('type_facility');
                                        $temp = explode(",",$ClientRoomFacilitys->fac);
                                    @endphp
									<div class="facility-group clb">
										<ul class="facility-group__list fl clb">
                                            @foreach($type_facility as $c)
                                                <li class="facility-group__item fl">
                                                    <input type="checkbox" id="fg1_{{$c->code}}" class="checkbox-v2" name="facility[]" value="{{$c->code}}" @if($ClientRoomFacilitys->fac != ""){{ in_array($c->code,$temp)?"checked":""}} @elseif($ClientRoomFacilitys->fac == "") checked="checked" @endif>
                                                    <label for="fg1_{{$c->code}}">{{ $c->name }}</label>
                                                </li>
                                            @endforeach
										</ul>
									</div>
								</td>
							</tr>
							<tr class="table-a__tr">
								<td class="table-a__td type-nobd type-right type-top lh-28">특이사항</td>
								<td colspan="5" class="table-a__td type-nobd type-left">
									<textarea class="textarea-v1 ta-l" name="etc" placeholder="없음" value="{{isset($ClientRoom)?$ClientRooms[0]->etc:""}}"></textarea>
								</td>
							</tr>
							<tr class="table-a__tr">
								<td class="table-a__td type-nobd type-right type-top lh-28">객실 사진 등록</td>
								<td colspan="5" class="table-a__td type-nobd type-left">
									<p class="mb-5">
										<button type="button" class="btn-v1 js-trigger-img room_add">사진 추가</button>
									</p>
									<div class="add-img">
										<ul class="add-img__list clb">
                                            @foreach($file as $k => $v)
											<li class="add-img__item fl">
                                                <input type="hidden" name="file_data[{{$k}}]" value="{{$v->id}}">
                                                <input type="hidden" id="file_name_{{$k}}" name="file_name[{{$k}}]" value="{{isset($file)&&$v->file_name? $v->file_name :""}}">
												<div class="add-img__imgbox">
                                                    <img src="/data/{{$v->path}}" style="width:100px; height:100px;" id="preview_{{$k}}" />
												</div>
												<input type="file" name="file[{{$k}}]" class="img-input bld" onchange="readURL(this,{{$k}})">
												<p class="add-img__tit ellipsis" title="이미지명입니다" id='image_name_{{$k}}' >{{isset($file)&&$v->file_name? $v->file_name :""}}</p>
												<p class="img_del btn-v2 type-icon type-del" onclick="$(this).parents('li').remove()">삭제</p>
											</li>
                                            @endforeach
										</ul>
										<span class="add-img__sub">데이터용량 0KB / 10MB</span>
									</div>
								</td>
							</tr>
							<tr class="table-a__tr">
								<td class="table-a__td type-nobd type-right type-top lh-28">최대 투숙 인원</td>
								<td class="table-a__td type-nobd type-left">
									<div class="input-wrap" style="width:48px;">
										<input type="text" class="input-v1 ta-r"  name="room_cnt_max" id="room_cnt_max"  value="{{isset($ClientRoom)?$ClientRooms[0]->room_cnt_max:""}}">
									</div> 명
								</td>
								<td class="table-a__td type-nobd type-right type-top lh-28">최소 투숙 인원</td>
								<td class="table-a__td type-nobd type-left">
									<div class="input-wrap" style="width:48px;">
										<input type="text" class="input-v1 ta-r" name="room_cnt_min" id="room_cnt_min"  value="{{isset($ClientRoom)?$ClientRooms[0]->room_cnt_min:""}}">
									</div> 명
								</td>
								<td class="table-a__td type-nobd type-right type-top lh-28">기본 투숙 인원</td>
								<td class="table-a__td type-nobd type-left">
									<div class="input-wrap" style="width:48px;">
										<input type="text" class="input-v1 ta-r" name="room_cnt_basic" id="room_cnt_basic"  value="{{isset($ClientRoom)?$ClientRooms[0]->room_cnt_basic:""}}">
									</div> 명
								</td>
							</tr>
						</table>

					</div>
					<div class="btn-wrap type-fg">
						<button type="submit" class="btn-v4 type-save">저장</button>
						<button type="button" class="btn-v2">취소</button>
					</div>
				</div>
                </form>
				<script>
					$(document).on("click",".add-img__imgbox",function(){
						$(this).next().trigger("click");
					});
				</script>


{{--                @php--}}
{{--                    $path = $_SERVER["HTTP_HOST"];--}}
{{--                    $path = explode(".",$path);--}}
{{--                    $path = $path[0];--}}
{{--                @endphp--}}
{{--                @if($path=="client")--}}
{{--                <form method="post" name="rooms" class="client_form" action="/info/room/view/save" enctype="multipart/form-data">--}}
{{--                @else--}}
{{--                    <form method="post" name="rooms" class="client_form" action="{{url()->current()}}"  enctype="multipart/form-data">--}}
{{--                @endif--}}
{{--                    {{ csrf_field() }}--}}
{{--                    <input type="hidden" name="user_id" value="{{isset($user_id)?$user_id:""}}" />--}}
{{--                    <input type="hidden" name="type_id" value="{{isset($type_id)?$type_id:""}}" />--}}
{{--                    <div class="position-relative form-group">--}}
{{--                        <label for="clientName" class="" style="color: blue">그룹명</label>--}}
{{--                        <input type="text" name="type_name" id="type_name" placeholder="그룹명을 입력하세요" class="form-control" value="{{isset($ClientRoom)?$ClientRooms[0]->type_name:""}}" />--}}
{{--                    </div>--}}

{{--                    <div class="position-relative form-group">--}}
{{--                        <label for="num" class="" style="color: blue">객실수</label>--}}
{{--                        <input type="text" name="num" id="num" placeholder="객실수 입력하세요" class="form-control" value="{{isset($ClientRoom)?$ClientRooms[0]->num:""}}" /><a id="num1" name="num1" value="0">추가</a></td>--}}
{{--                    </div>--}}
{{--                    @if(!isset($room_name))--}}
{{--                        <div class="position-relative form-group">--}}
{{--                            <a id="num_plus" class="num_plus"></a>--}}
{{--                        </div>--}}
{{--                    @endif--}}
{{--                    @foreach($room_name as $t => $v)--}}
{{--                        <div class="position-relative form-group" style="border: 1px solid red;">--}}
{{--                            <div class="position-relative form-group">--}}
{{--                                <input type="hidden" name="room_num[{{$t}}]" id="room_num[{{$t}}]" class="form-control" value='{{isset($room_name)?$v->id:""}}' />--}}
{{--                            </div>--}}
{{--                            <div class="position-relative form-group">--}}
{{--                                <label for="room_name[{{$t}}]" class="">객실명</label>--}}
{{--                                <input type="text" name="room_name[{{$t}}]" id="room_name[{{$t}}]" placeholder="객실명을 입력하세요" class="form-control" value='{{isset($room_name)?$v->room_name:""}}' />--}}
{{--                            </div>--}}
{{--                            <div class="position-relative form-group">--}}
{{--                                <label for="now[{{$t}}]" class="">실시간 예약</label>--}}
{{--                                <input type="radio" name='now[{{$t}}]' value='Y' {{ isset($v->flag_realtime)&&$v->flag_realtime=="Y"?"checked":"" }} />판매--}}
{{--                                <input type='radio' name='now[{{$t}}]' value='N' {{ isset($v->flag_realtime)&&$v->flag_realtime=="N"?"checked":"" }} />판매안함--}}
{{--                            </div>--}}
{{--                            <div class="position-relative form-group">--}}
{{--                                <label for="online[{{$t}}]" class="">온라인 판매 대행</label>--}}
{{--                                <input type='radio' name='online[{{$t}}]' value='Y' {{ isset($v->flag_online)&&$v->flag_online=="Y"?"checked":"" }} />판매--}}
{{--                                <input type='radio' name='online[{{$t}}]' value='N' {{ isset($v->flag_online)&&$v->flag_online=="N"?"checked":"" }} />판매안함--}}
{{--                                <input type='button' name='delete[{{$t}}]' value='삭제' onclick='$(this).parent().parent().remove()'>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    @endforeach--}}
{{--                    @if(isset($room_name))--}}
{{--                        <div class="position-relative form-group">--}}
{{--                            <a id="num_plus1" class="num_plus1"></a>--}}
{{--                        </div>--}}
{{--                    @endif--}}
{{--                    <div class="position-relative form-group">--}}
{{--                        <label for="room_area" class="" style="color: blue">객실 크기</label>--}}
{{--                        <input type="text" name="room_area" id="room_area" placeholder="객실 크기를 입력하세요" class="form-control" value="{{isset($ClientRoom)?$ClientRooms[0]->room_area:""}}" />--}}
{{--                    </div>--}}

{{--                    <div class="position-relative form-group">--}}
{{--                        <label for="room_shape" class="" style="color: blue;">객실 형태</label>--}}
{{--                    </div>--}}

{{--                    <div class="position-relative form-group">--}}
{{--                        @if($ClientRoom != "")--}}
{{--                            <input type="radio" name="room_shape" id="room_shape" value="Poisonous" @if(($ClientRooms[0]->room_shape)=="Poisonous")checked="checked"@endif>독채형--}}
{{--                            <input type="radio" name="room_shape" id="room_shape" value="Ventral" @if(($ClientRooms[0]->room_shape)=="Ventral")checked="checked"@endif>복층형--}}
{{--                            <input type="radio" name="room_shape" id="room_shape" value="One-room-type" @if(($ClientRooms[0]->room_shape)=="One-room-type")checked="checked"@endif>원룸형--}}
{{--                            <input type="radio" name="room_shape" id="room_shape" value="Detachable" @if(($ClientRooms[0]->room_shape)=="Detachable")checked="checked"@endif>분리형--}}
{{--                        @elseif($ClientRoom =="")--}}
{{--                            <input type="radio" name="room_shape" id="room_shape" value="Poisonous">독채형--}}
{{--                            <input type="radio" name="room_shape" id="room_shape" value="Ventral">복층형--}}
{{--                            <input type="radio" name="room_shape" id="room_shape" value="One-room-type">원룸형--}}
{{--                            <input type="radio" name="room_shape" id="room_shape" value="Detachable">분리형--}}
{{--                        @endif--}}
{{--                    </div>--}}

{{--                    <div class="position-relative form-group">--}}
{{--                        <label for="" class="" style="color: blue;">객실 내부</label>--}}
{{--                    </div>--}}

{{--                    @php--}}
{{--                        $type_facility = \App\Http\Controllers\Controller::getCode('inner');--}}
{{--                    @endphp--}}
{{--                    <div class="position-relative form-group" style="display: flex;">--}}
{{--                        @foreach($type_facility as $c)--}}
{{--                            <?php--}}
{{--                            $name = $c->code;--}}
{{--                            $name = str_replace("inner_","",$name);--}}
{{--                            ?>--}}
{{--                            <label for="{{$c->code}}" class="">{{$c->name}}</label>--}}
{{--                            <input type="text" name="{{$c->code}}" id="{{$c->code}}" class="form-control" style="width: 50px" size="2" value="{{isset($ClientRoom)?$ClientRooms[0]->$name:""}}">개&nbsp;&nbsp;--}}
{{--                        @endforeach--}}
{{--                    </div>--}}
{{--                    <div class="position-relative form-group">--}}
{{--                        <label for="room_area" class="" style="color: blue;">객실 시설</label>--}}
{{--                    </div>--}}
{{--                    <div class="position-relative form-group">--}}
{{--                        <input type="checkbox" id="facility_all">모두선택--}}
{{--                        @php--}}
{{--                            $type_facility = \App\Http\Controllers\Controller::getCode('type_facility');--}}
{{--                            $temp = explode(",",$ClientRoomFacilitys->fac);--}}
{{--                        @endphp--}}
{{--                        @foreach($type_facility as $c)--}}
{{--                            <input type="checkbox" name="facility[]" value="{{$c->code}}" @if($ClientRoomFacilitys->fac != ""){{ in_array($c->code,$temp)?"checked":""}} @elseif($ClientRoomFacilitys->fac == "") checked="checked" @endif>{{$c->name}}--}}
{{--                        @endforeach--}}
{{--                    </div>--}}
{{--                    <div class="position-relative form-group">--}}
{{--                        <label for="etc" class="" style="color: blue;">특이 사항</label>--}}
{{--                        <input type="text" name="etc" id="etc" placeholder="특이사항을 입력하세요" class="form-control" value="{{isset($ClientRoom)?$ClientRooms[0]->etc:""}}" />--}}
{{--                    </div>--}}

{{--                    <p><label for="img" class="" style="color: blue;">객실 사진 등록</label>&nbsp;&nbsp;<a class="room_add">추가</a></p>--}}
{{--                    @foreach($file as $k => $v)--}}
{{--                    <div class="position-relative form-group" style="border: 1px solid red;">--}}
{{--                        <p style="display: none"><input id="fileName" class="file_input_textbox" readonly value="{{isset($file)&&$v->file_name? $v->file_name :""}}"/></p>--}}
{{--                        <p><input type="hidden" id="file_name_{{$k}}" name="file_name[{{$k}}]" value="{{isset($file)&&$v->file_name? $v->file_name :""}}"></p>--}}
{{--                        <p><input type="file" class="{{$k}}" id="{{$k}}" name="file[]" value="{{isset($file)&&$v->file_name? $v->file_name :""}}" onchange="javascript:file_change(this.value);" /></p>--}}
{{--                        <p><a id="file_text">{{isset($file)&&$v->file_name? $v->file_name :""}}</a></p>--}}
{{--                        <p><img style="width: 50px; height: 50px;" onclick="newOpen(this)" id="preview" src="/data/{{isset($file)&&$v->path?$v->path:""}}" /></p>--}}
{{--                        <p><a id="img_label_{{$k}}" style="color: red;">삭제</a></p>--}}
{{--                    </div>--}}
{{--                    @endforeach--}}
{{--                    <div id="preview3" style="display:none; "><img src="" /><a id="close" style="color: red; font-size: 15px;">닫기</a></div>--}}

{{--                        <script>--}}
{{--                            var ord = {{sizeof($file)}};--}}
{{--                            $(function () {--}}
{{--                                var i =0;--}}
{{--                                $("input[name^='file']").each(function () {--}}
{{--                                    var id = $(this).attr("id");--}}
{{--                                    $("."+id).change(function () {--}}
{{--                                        if($('#file_name_'+id+'').val() != $("#fileName").val()){--}}
{{--                                            //hidden값( 저장된 값)--}}
{{--                                            console.log($('#file_name_'+id+'').val());--}}
{{--                                            //바로바로 변경된값--}}
{{--                                            console.log($("#fileName").val());--}}
{{--                                            console.log("변경");--}}
{{--                                            $('#file_name_'+id+'').val($("#fileName").val());--}}
{{--                                        } else{--}}
{{--                                            //hidden값( 저장된 값)--}}
{{--                                            console.log($('#file_name_'+id+'').val());--}}
{{--                                            //바로바로 변경된값--}}
{{--                                            console.log($("#fileName").val());--}}
{{--                                            console.log("같음");--}}
{{--                                            $('#file_name_'+id+'').val($("#fileName").val());--}}
{{--                                        }--}}
{{--                                    });--}}
{{--                                })--}}
{{--                            });--}}

{{--                            $(function () {--}}
{{--                                $("input[name^='file']").each(function () {--}}
{{--                                    var id = $(this).attr("id");--}}
{{--                                    $('#img_label_'+id).click(function () {--}}
{{--                                        console.log(id);--}}
{{--                                        $('#file_name_'+id+'').val("");--}}
{{--                                        $(this).parent().parent().hide();--}}
{{--                                    });--}}
{{--                                });--}}
{{--                            });--}}
{{--                        </script>--}}

{{--                    <div class="position-relative form-group">--}}
{{--                        <label for="room_cnt_max" class="" style="color: blue">최대 투숙 인원</label>--}}
{{--                        <input type="text" name="room_cnt_max" id="room_cnt_max" class="form-control" value="{{isset($ClientRoom)?$ClientRooms[0]->room_cnt_max:""}}" />--}}
{{--                    </div>--}}

{{--                    <div class="position-relative form-group">--}}
{{--                        <label for="room_cnt_min" class="" style="color: blue">최소 투숙 인원</label>--}}
{{--                        <input type="text" name="room_cnt_min" id="room_cnt_min" class="form-control" value="{{isset($ClientRoom)?$ClientRooms[0]->room_cnt_min:""}}" />--}}
{{--                    </div>--}}

{{--                    <div class="position-relative form-group">--}}
{{--                        <label for="room_cnt_basic" class="" style="color: blue">기본 투숙 인원</label>--}}
{{--                        <input type="text" name="room_cnt_basic" id="room_cnt_basic" class="form-control" value="{{isset($ClientRoom)?$ClientRooms[0]->room_cnt_basic:""}}" />--}}
{{--                    </div>--}}
{{--                    <button class="mt-1 btn btn-primary">저장</button>--}}
                </form>
            </div>
        </div>
    </div>
@endsection



