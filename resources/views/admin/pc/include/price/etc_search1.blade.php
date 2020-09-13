<script>
    $(function () {
        var search2 = $("#search2").val();
        var search_board = $('#search_board').val();
        $('#prev_search2').val(search2);
        $('#prev_search_board').val(search_board);
    })
</script>
<div class="row fr between-32" style="width:48%;min-width:460px;">
    <div class="main-card mb-3 card" style="width:100%; ">
        <div class="card-body">
            <h5 class="card-title bld">Search</h5>
            <form method="get" action="{{url()->current()}}">
                <input type="hidden" name="search2" id="prev_search2">
                <input type="hidden" name="search_board" id="prev_search_board">
                <div class="clb content-search">
                    <ul class="content-search__list">
                        {{--                       <li class="content-search__item fl">--}}
                        {{--                           <div class="select-wrap w-170">--}}
                        {{--							<select  name="search1" id="search1" class="select-v1 noto">--}}
                        {{--								<option value="client_list" {{ isset($search['search1'])&&$search['search1']=="client_list"?"selected":"" }}>Client List--}}
                        {{--                                <option value="room_list" {{ isset($search['search1'])&&$search['search1']=="room_list"?"selected":"" }}>Room List--}}
                        {{--							</select>--}}
                        {{--						</div>--}}
                        {{--                       </li>--}}
                        <li class="content-search__item fl">
                            <div class="input-wrap w-170" id="text">
                                <input type="text" class="input-v1 va-m" name="search_room_list" id="search_room_list_text" value="{{ isset($search['search_room_list'])&&$search['search_room_list']!=""?$search['search_room_list']:"" }}">
                            </div>
                        </li>
                        <li class="content-search__item fl clb">
                            <div class="input-wrap w-190" id="radio">
                                <input type="radio" class="radio-v1 dp-ib" name="search_room_list_check" id="search_room_list_Y"  value ="Y" @if(isset($search['search_room_list_check']) && $search['search_room_list_check']=="Y") checked @endif >
                                <label for="search_room_list_Y" class="ml-20">판매함</label>
                                <input type="radio" class="radio-v1 dp-ib" name="search_room_list_check" id="search_room_list_N"  value="N" @if(isset($search['search_room_list_check']) && $search['search_room_list_check']=="N")checked @endif >
                                <label for="search_room_list_N" class="ml-20">판매안함</label>
                            </div>
                            <button type="submit" class="btn-v3 type-black type-search va-m" style="margin-left:20px;">검색</button>
                        </li>
                    </ul>
                </div>
            <!--
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
-->
            </form>
        </div>
    </div>
</div>

