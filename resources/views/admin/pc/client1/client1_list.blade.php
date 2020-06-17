@extends("admin.pc.layout.basic")

@section("title")숙박업체@endsection

@section("scripts")
@endsection

@section("styles")
@endsection

@section("contents")
    <div class="row">
        <div class="main-card mb-3 card" style="width:100%; ">
            <div class="card-body">
                <h5 class="card-title">Search</h5>
                <form method="get" action="{{url()->current()}}">
                    <table class="mb-0 table">
                        <tr>
                            <td>
                                <select name="search1" id="search1">
                                    <option value="client_list" {{ isset($search['search1'])&&$search['search1']=="client_list"?"selected":"" }}>Client List
                                    <option value="room_list" {{ isset($search['search1'])&&$search['search1']=="room_list"?"selected":"" }}>Room List
                                </select>
                            </td>
                            <td>
                                <select name='search2' id='search2'>
                                    <option id="default" value="" selected>==선택하세요==</option>
                                    <option id="client_list_search_menu1" value="search_group" {{ isset($search['search2'])&&$search['search2']=="search_group"?"selected":"" }}>그룹명
                                    <option id="client_list_search_menu2" value="search_num" {{ isset($search['search2'])&&$search['search2']=="search_num"?"selected":"" }} >판매객실수
                                    <option id="client_list_search_menu3" value="search_basic" {{ isset($search['search2'])&&$search['search2']=="search_basic"?"selected":"" }} >기준
                                    <option id="client_list_search_menu4" value="search_max" {{ isset($search['search2'])&&$search['search2']=="search_max"?"selected":"" }}>최대
                                    <option id="room_list_search_menu1" value="search_room_name" {{ isset($search['search2'])&&$search['search2']=="search_room_name"?"selected":"" }} >객실명
                                    <option id="room_list_search_menu2" value="search_realtime" {{ isset($search['search2'])&&$search['search2']=="search_realtime"?"selected":"" }} >실시간 예약
                                    <option id="room_list_search_menu3" value="search_online" {{ isset($search['search2'])&&$search['search2']=="search_online"?"selected":"" }} >온라인 예약
                                </select>
                            </td>
                            <td>
                                <input type="text" name="search_board" id="search_board" value="{{ isset($search['search_board'])&&$search['search_board']!=""?$search['search_board']:"" }}">
                            </td>
                            <td>
                                <button type="submit" class="mr-2 btn-transition btn btn-outline-dark">검색</button>
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="main-card mb-3 card" style="width:100%; ">
            <div class="card-body"><h5 class="card-title">Client List</h5>
                <table class="mb-0 table table-hover">
                    <thead>
                    <tr>
                        <th>&nbsp;</th>
                        <th>그룹명</th>
                        <th>판매객실수</th>
                        <th>기준/최대</th>
                        <th><button class="mr-2 btn btn-focus" onclick="goUrl('{{ isset($id)&&($id>0)? route('etc.room_insert',['id'=>$id,'type_id'=>isset($tid)?$tid:""]) : route('etc.room_insert')}}');">룸타입등록</button></th>
                        <th>&nbsp;</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($clientList as $k => $c)
                        <tr>
                            <th scope="row">{{ $clientList->total()-$k }}</th>
                            <td>{{ $c->type_name }}</td>
                            <td>{{ $c->num }}</td>
                            <td>{{ $c->room_cnt_basic }}/{{ $c->room_cnt_max }}</td>
                            <td></td>
                            <td>
                                <button class="mr-2 btn btn-secondary" onclick="goUrl('{{route('etc.room_insert',['type_id'=>$c->id])}}');">객실 정보</button>
                                <button class="mr-2 btn btn-info" onclick="goUrl('{{route('client.info.price',['id'=>$c->user_id])}}');">요금 정보</button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="main-card mb-3 card" style="width:100%; ">
            <div class="card-body"><h5 class="card-title">Room List</h5>
                <form id="live_room" name="live_room" method="post" action="/room/check">
                    {{ csrf_field() }}
                    <table class="mb-0 table table-hover">
                        <thead>
                        <tr>
                            <th>&nbsp;</th>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <th>객실명</th>
                            <th>실시간 예약</th>
                            <th>온라인 예약</th>
                            <th>삭제</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($ClientTypeRoom as $k => $c)
                            <tr>
                                <th scope="row">{{$k+1}}</th>
                                <td><input type="hidden" name="client_type_room_group_{{$k+1}}" value="{{isset($ClientTypeRoom)?$c->type_id:""}}"></td>
                                <td><input type="hidden" name="client_type_room_id_{{$k+1}}" value="{{isset($ClientTypeRoom)?$c->id:""}}"></td>
                                <td>{{ $c->room_name}}</td>
                                <td><input type="radio" name="now_{{$k+1}}"  value="Y" @if(($c->flag_realtime)=='Y') checked="checked"@endif>판매<input type="radio" name="now_{{$k+1}}" value="N" @if(($c->flag_realtime)!='Y') checked="checked" @endif>판매 안함
                                <td><input type="radio" name="online_{{$k+1}}" value="Y" @if(($c->flag_online)=='Y') checked="checked" @endif>판매  <input type="radio" name="online_{{$k+1}}" value="N" @if(($c->flag_online)!='Y') checked="checked"@endif>판매 안함</td>
                                <td><input type="checkbox" name="delete_{{$k+1}}" value="ok"></td>
                            </tr>
                        @endforeach
                        <tr>
                            <td>
                                <button class="mr-2 btn btn-info">변경</button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </form>
            </div>
        </div>
    </div>
@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>
    $(function () {
        var search1 = $('#search1').val();
        if(search1 == "client_list"){
            $('#default').show();
            $('#client_list_search_menu1').show();
            $('#client_list_search_menu2').show();
            $('#client_list_search_menu3').show();
            $('#client_list_search_menu4').show();
            $('#room_list_search_menu1').hide();
            $('#room_list_search_menu2').hide();
            $('#room_list_search_menu3').hide();
        }else if(search1 == "room_list"){
            $('#client_list_search_menu1').hide();
            $('#client_list_search_menu2').hide();
            $('#client_list_search_menu3').hide();
            $('#client_list_search_menu4').hide();
            $('#default').show();
            $('#room_list_search_menu1').show();
            $('#room_list_search_menu2').show();
            $('#room_list_search_menu3').show();
        }
        $('#search1').change(function () {
            var search1 = $('#search1').val();
            console.log(search1);
            if(search1 == "client_list"){
                $('#default').show();
                $('#default').val("").prop("selected",true);
                $('#client_list_search_menu1').show();
                $('#client_list_search_menu2').show();
                $('#client_list_search_menu3').show();
                $('#client_list_search_menu4').show();
                $('#room_list_search_menu1').hide();
                $('#room_list_search_menu2').hide();
                $('#room_list_search_menu3').hide();
            }else if(search1 == "room_list"){
                $('#client_list_search_menu1').hide();
                $('#client_list_search_menu2').hide();
                $('#client_list_search_menu3').hide();
                $('#client_list_search_menu4').hide();
                $('#default').show();
                $('#default').val("").prop("selected",true);
                $('#room_list_search_menu1').show();
                $('#room_list_search_menu2').show();
                $('#room_list_search_menu3').show();
            }
        })
    })
</script>
{{--<script>--}}
{{--    $(function () {--}}
{{--        $('#search1').click(function () {--}}
{{--            var search1 = $('#search1 option:selected').val();--}}
{{--            if(search1 == "client_list"){--}}
{{--                $('#search2').html(--}}
{{--                    "<select name='search2' id='search2'>\n" +--}}
{{--                        "<option value=\"search_group\" {{ isset($search['search2'])&&$search['search2']=="search_group"?"selected":"" }}>그룹명\n" +--}}
{{--                        "<option value=\"search_num\" {{ isset($search['search2'])&&$search['search2']=="search_num"?"selected":"" }} >판매객실수\n" +--}}
{{--                        "<option value=\"search_basic\" {{ isset($search['search2'])&&$search['search2']=="search_basic"?"selected":"" }} >기준\n" +--}}
{{--                        "<option value=\"search_max\" {{ isset($search['search2'])&&$search['search2']=="search_max"?"selected":"" }}>최대"+--}}
{{--                    "</select>"--}}
{{--                )--}}
{{--            }else if(search1 == "room_list"){--}}
{{--                $('#search3').html(--}}
{{--                    "<select name='search2' id='search2'>\n" +--}}
{{--                        "<option value=\"search_room_name\" {{ isset($search['search2'])&&$search['search2']=="search_room_name"?"selected":"" }} >객실명\n" +--}}
{{--                        "<option value=\"search_realtime\" {{ isset($search['search2'])&&$search['search2']=="search_realtime"?"selected":"" }} >실시간 예약\n" +--}}
{{--                        "<option value=\"search_online\" {{ isset($search['search2'])&&$search['search2']=="search_online"?"selected":"" }} >온라인 예약\n"+--}}
{{--                    "</select>"--}}
{{--                )--}}
{{--            }--}}
{{--        })--}}
{{--    })--}}
{{--</script>--}}
