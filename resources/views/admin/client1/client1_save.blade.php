@extends("layout.basic")

@section("title")숙박업체@endsection

@section("scripts")
@endsection

@section("styles")
@endsection

@section("contents")
    <?php
        $host = $_SERVER['REQUEST_URI'];
        $host = str_replace("/room/insert/","",$host);
    ?>
    <div class="row">
        <div class="main-card card" style="width:100%; ">
            <div class="card-body"><h5 class="card-title">Controls Types</h5>
                <form method="post" name="rooms" class="client_form" action="/room/post_save" >
                    <input type="hidden" id="id" name="id" value="{{isset($host)?$host:""}}">
                    {{ csrf_field() }}

                    <div class="position-relative form-group">
                        <label for="clientName" class="" style="color: blue">그룹명</label>
                        <input type="text" name="type_name" id="type_name" placeholder="그룹명을 입력하세요" class="form-control" value="{{isset($ClientRoom)?$ClientRooms[0]->type_name:""}}" />
                    </div>

                    <div class="position-relative form-group">
                        <label for="num" class="" style="color: blue">객실수</label>
                        <input type="text" name="num" id="num" placeholder="객실수 입력하세요" class="form-control" value="{{isset($ClientRoom)?$ClientRooms[0]->num:""}}" /><a id="num1" name="num1" value="0">추가</a></td>
                    </div>
                    @if(!isset($room_name))
                        <div class="position-relative form-group">
                            <a id="num_plus" class="num_plus"></a>
                        </div>
                    @endif
                    @foreach($room_name as $t => $v)
                        <div class="position-relative form-group" style="border: 1px solid red;">
                            <div class="position-relative form-group">
                                <input type="hidden" name="room_num[{{$t}}]" id="room_num[{{$t}}]" class="form-control" value='{{isset($room_name)?$v->id:""}}' />
                            </div>
                            <div class="position-relative form-group">
                                <label for="room_name[{{$t}}]" class="">객실명</label>
                                <input type="text" name="room_name[{{$t}}]" id="room_name[{{$t}}]" placeholder="객실명을 입력하세요" class="form-control" value='{{isset($room_name)?$v->room_name:""}}' />
                            </div>
                            <div class="position-relative form-group">
                                <label for="now[{{$t}}]" class="">실시간 예약</label>
                                <input type="radio" name='now[{{$t}}]' value='Y' {{ isset($v->flag_realtime)&&$v->flag_realtime=="Y"?"checked":"" }} />판매
                                <input type='radio' name='now[{{$t}}]' value='N' {{ isset($v->flag_realtime)&&$v->flag_realtime=="N"?"checked":"" }} />판매안함
                            </div>
                            <div class="position-relative form-group">
                                <label for="online[{{$t}}]" class="">온라인 판매 대행</label>
                                <input type='radio' name='online[{{$t}}]' value='Y' {{ isset($v->flag_online)&&$v->flag_online=="Y"?"checked":"" }} />판매
                                <input type='radio' name='online[{{$t}}]' value='N' {{ isset($v->flag_online)&&$v->flag_online=="N"?"checked":"" }} />판매안함
                                <input type='button' name='delete[{{$t}}]' value='삭제' onclick='$(this).parent().parent().remove()'>
                            </div>
                        </div>
                    @endforeach
                    @if(isset($room_name))
                        <div class="position-relative form-group">
                            <a id="num_plus1" class="num_plus1"></a>
                        </div>
                    @endif
                    <div class="position-relative form-group">
                        <label for="room_area" class="" style="color: blue">객실 크기</label>
                        <input type="text" name="room_area" id="room_area" placeholder="객실 크기를 입력하세요" class="form-control" value="{{isset($ClientRoom)?$ClientRooms[0]->room_area:""}}" />
                    </div>

                    <div class="position-relative form-group">
                        <label for="room_shape" class="" style="color: blue;">객실 형태</label>
                    </div>

                    <div class="position-relative form-group">
                        @if($ClientRoom != "")
                            <input type="radio" name="room_shape" id="room_shape" value="Poisonous" @if(($ClientRooms[0]->room_shape)=="Poisonous")checked="checked"@endif>독채형
                            <input type="radio" name="room_shape" id="room_shape" value="Ventral" @if(($ClientRooms[0]->room_shape)=="Ventral")checked="checked"@endif>복층형
                            <input type="radio" name="room_shape" id="room_shape" value="One-room-type" @if(($ClientRooms[0]->room_shape)=="One-room-type")checked="checked"@endif>원룸형
                            <input type="radio" name="room_shape" id="room_shape" value="Detachable" @if(($ClientRooms[0]->room_shape)=="Detachable")checked="checked"@endif>분리형
                        @elseif($ClientRoom =="")
                            <input type="radio" name="room_shape" id="room_shape" value="Poisonous">독채형
                            <input type="radio" name="room_shape" id="room_shape" value="Ventral">복층형
                            <input type="radio" name="room_shape" id="room_shape" value="One-room-type">원룸형
                            <input type="radio" name="room_shape" id="room_shape" value="Detachable">분리형
                        @endif
                    </div>

                    <div class="position-relative form-group">
                        <label for="" class="" style="color: blue;">객실 내부</label>
                    </div>

                    @php
                        $type_facility = \App\Http\Controllers\Controller::getCode('inner');
                    @endphp
                    <div class="position-relative form-group" style="display: flex;">
                        @foreach($type_facility as $c)
                            <?php
                                $name = $c->code;
                                $name = str_replace("inner_","",$name);
                            ?>
                            <label for="{{$c->code}}" class="">{{$c->name}}</label>
                            <input type="text" name="{{$c->code}}" id="{{$c->code}}" class="form-control" style="width: 50px" size="2" value="{{isset($ClientRoom)?$ClientRooms[0]->$name:""}}">개&nbsp;&nbsp;
                        @endforeach
                    </div>

{{--                    <div class="position-relative form-group" style="display: flex;">--}}
{{--                        <label for="Livingroom" class="">거실</label>--}}
{{--                        <input type="text" name="Livingroom" id="Livingroom" class="form-control" style="width: 50px" size="2" value="{{isset($ClientRoom)?$ClientRooms[0]->livingroom:""}}">개&nbsp;&nbsp;--}}
{{--                        <label for="Bedroom" class="">침대방</label>--}}
{{--                        <input type="text" name="Bedroom" id="Bedroom" class="form-control" size="2" style="width: 50px" value="{{isset($ClientRoom)?$ClientRooms[0]->bedroom:""}}">개&nbsp;&nbsp;--}}
{{--                        <label for="Ondolroom" class="">온돌방</label>--}}
{{--                        <input type="text" name="Ondolroom" id="Ondolroom" class="form-control" size="2" style="width: 50px" value="{{isset($ClientRoom)?$ClientRooms[0]->ondolroom:""}}">개&nbsp;&nbsp;--}}
{{--                        <label for="restroom" class="">화장실</label>--}}
{{--                        <input type="text" name="restroom" id="restroom" class="form-control" size="2" style="width: 50px" value="{{isset($ClientRoom)?$ClientRooms[0]->restroom:""}}">개&nbsp;&nbsp;--}}
{{--                        <label for="kitchen" class="">주방</label>--}}
{{--                        <input type="text" name="kitchen" id="kitchen" class="form-control" size="2" style="width: 50px" value="{{isset($ClientRoom)?$ClientRooms[0]->kitchen:""}}">개&nbsp;&nbsp;--}}
{{--                    </div>--}}

                    <div class="position-relative form-group">
                        <label for="room_area" class="" style="color: blue;">객실 시설</label>
                    </div>

                    <div class="position-relative form-group">
                        @php
                            $type_facility = \App\Http\Controllers\Controller::getCode('type_facility');
                            $temp = explode(",",$ClientRoomFacilitys->fac);
                         @endphp
                        @foreach($type_facility as $c)
                            <input type="checkbox" name="facility[]" value="{{$c->code}}" @if($ClientRoomFacilitys->fac != ""){{ in_array($c->code,$temp)?"checked":""}} @elseif($ClientRoomFacilitys->fac == "") checked="checked" @endif>{{$c->name}}
                        @endforeach
                    </div>
{{--                            <input type="checkbox" name="facility[]" value="Privatepool" checked="checked">개별수영장--}}
{{--                            <input type="checkbox" name="facility[]" value="spa" checked="checked">스파/월풀--}}
{{--                            <input type="checkbox" name="facility[]" value="BBQ" checked="checked">개별(테라스)바비큐--}}
{{--                            <input type="checkbox" name="facility[]" value="bathroom" checked="checked">욕조--}}
{{--                            <input type="checkbox" name="facility[]" value="TV" checked="checked">TV--}}
{{--                            <input type="checkbox" name="facility[]" value="conditioner" checked="checked">에어컨--}}
{{--                            <input type="checkbox" name="facility[]" value="Gas" checked="checked">가스레인지/인덕션--}}
{{--                            <input type="checkbox" name="facility[]" value="Coffee " checked="checked">커피포트--}}
{{--                            <input type="checkbox" name="facility[]" value="Refrigerator" checked="checked">냉장고--}}
{{--                            <input type="checkbox" name="facility[]" value="table" checked="checked">식탁--}}
{{--                            <input type="checkbox" name="facility[]" value="rice" checked="checked">전기밥솥--}}
{{--                            <input type="checkbox" name="facility[]" value="Microwave" checked="checked">전자레인지--}}
{{--                            <input type="checkbox" name="facility[]" value="bar" checked="checked">미니바--}}
{{--                            <input type="checkbox" name="facility[]" value="Bidet" checked="checked">비데--}}
{{--                            <input type="checkbox" name="facility[]" value="dry" checked="checked">드라이기--}}

                    <div class="position-relative form-group">
                        <label for="etc" class="" style="color: blue;">특이 사항</label>
                        <input type="text" name="etc" id="etc" placeholder="특이사항을 입력하세요" class="form-control" value="{{isset($ClientRoom)?$ClientRooms[0]->etc:""}}" />
                    </div>

                    <div class="position-relative form-group">
                        <label for="img" class="" style="color: blue;">객실 사진 등록</label>
                        <input type="file" name="img" id="img" class="form-control" />
                    </div>

                    <div class="position-relative form-group">
                        <label for="room_cnt_max" class="" style="color: blue">최대 투숙 인원</label>
                        <input type="text" name="room_cnt_max" id="room_cnt_max" class="form-control" value="{{isset($ClientRoom)?$ClientRooms[0]->room_cnt_max:""}}" />
                    </div>

                    <div class="position-relative form-group">
                        <label for="room_cnt_min" class="" style="color: blue">최소 투숙 인원</label>
                        <input type="text" name="room_cnt_min" id="room_cnt_min" class="form-control" value="{{isset($ClientRoom)?$ClientRooms[0]->room_cnt_min:""}}" />
                    </div>

                    <div class="position-relative form-group">
                        <label for="room_cnt_basic" class="" style="color: blue">기본 투숙 인원</label>
                        <input type="text" name="room_cnt_basic" id="room_cnt_basic" class="form-control" value="{{isset($ClientRoom)?$ClientRooms[0]->room_cnt_basic:""}}" />
                    </div>
                    <button class="mt-1 btn btn-primary">저장</button>
                </form>
            </div>
        </div>
    </div>
@endsection

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>
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
                        "<input type='button'  name='delete["+ord+"]' value='삭제' onclick='$(this).parent().remove()'>\n" +
                    "</div>"
                );
                ord++;
            }
        });
    });
</script>

