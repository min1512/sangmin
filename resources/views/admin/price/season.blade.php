@extends("layout.basic")

@section("title")성수기/시즌 추가@endsection

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
            <div class="card-body"><h5 class="card-title">Season List</h5>
                <table class="mb-0 table table-hover">
                    <thead>
                    <tr>
                        <th>전체 요금표</th>
                        <th>비수기</th>
                        <th>준 성수기</th>
                        <th>성수기</th>
                        <th><button class="mr-2 btn btn-focus" onclick="goUrl('{{route('etc.room_insert')}}');">시즌 추가</button></th>
                    </tr>
                    <tr>
                        <th colspan="4" style="text-align: center">객실</th>
                        <th colspan="4" style="text-align: center">객실 기본요금</th>
                        <th colspan="3" style="text-align: center">추가 인원 요금</th>
                    </tr>
                    </thead>
                    <tr>
                        <td>그룹명</td>
                        <td>객실명</td>
                        <td>기준</td>
                        <td>시즌</td>
                        <td>일요일</td>
                        <td>주중</td>
                        <td>금요일</td>
                        <td>토요일(공휴일 전날)</td>
                        <td>성인</td>
                        <td>아동</td>
                        <td>유아</td>
                    </tr>

                    @foreach($ClientType as $c)
                    <tr>
                        <td>{{$c->type_name}}</td>
                        <td>
                            <table>
                                @foreach($ClientTypeRoom as $v)
                                    <tr>
                                        <td>{{$v->room_name}}</td>
                                    </tr>
                                @endforeach
                            </table>
                        </td>
                        <td>{{$c->room_cnt_basic}}</td>
                        <td></td>
                    </tr>
                    @endforeach
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection