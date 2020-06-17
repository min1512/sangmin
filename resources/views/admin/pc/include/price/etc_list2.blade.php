<div class="row fl between-32 js-height" style="width:48%;min-width:460px;">
    <div class="">
        <div class="card-body">
            @php
            $path = $_SERVER["HTTP_HOST"];
            $path = explode(".",$path);
            @endphp
            @if($path[0]=="client")
            <form id="live_room" name="live_room" method="post" action="/info/room/check">
                @else
                <form id="live_room" name="live_room" method="post" action="{{url()->current()}}">
                    @endif
                    {{ csrf_field() }}
                    <div class="table-a noto">
                        <div class="table-a__head clb">
                            <h5 class="table-a__tit fl">Room List</h5>
                            <div class="table-a__inbox type-head fr">
                                <button class="btn-v1">변경</button>
                            </div>
                        </div>

                        <table class="table-a__table">
                            <colgroup>
                                <col width="7%">
                                <col width="48%">
                                <col width="18%">
                                <col width="18%">
                                <col width="9%">
                            </colgroup>
                            <tr class="table-a__tr type-th">
                                <th class="table-a__th">번호</th>
                                <th class="table-a__th">객실명</th>
                                <th class="table-a__th">실시간 예약</th>
                                <th class="table-a__th">온라인 예약</th>
                                <th class="table-a__th">삭제</th>
                            </tr>
                        </table>
                    </div>
                        <div class="" id="js-scroll-height">
                            <table class="table-a__table">
                                <colgroup>
                                    <col width="7%">
                                    <col width="48%">
                                    <col width="18%">
                                    <col width="18%">
                                    <col width="9%">
                                </colgroup>



                                <tbody>
                                    @foreach($ClientTypeRoom as $k => $c)
                                    <tr>
                                        <input type="hidden" name="client_type_room_group_{{$k+1}}" value="{{isset($ClientTypeRoom)?$c->type_id:""}}">
                                        <input type="hidden" name="client_type_room_id_{{$k+1}}" value="{{isset($ClientTypeRoom)?$c->id:""}}">
                                        <td class="table-a__td">
                                            <div class="table-a__inbox">
                                                <span>{{$k+1}}</span>
                                            </div>
                                        </td>
                                        <td class="table-a__td">
                                            <div class="table-a__inbox ta_l">
                                                <span>{{ $c->room_name}}</span>
                                            </div>
                                        </td>
                                        <td class="table-a__td">
                                            <div class="table-a__inbox ta_l">
                                                <div>
                                                    <input type="radio" id="now_{{$k+1}}" class="radio-v1"  name="now_{{$k+1}}" value="Y" @if(($c->flag_realtime)=='Y') checked="checked"@endif checked />
                                                    <label for="now_{{$k+1}}">판매함</label>
                                                </div>
                                                <div>
                                                    <input type="radio" id="now_{{$k+1}}-1" class="radio-v1" name="now_{{$k+1}}" value="N" @if(($c->flag_realtime)!='Y') checked="checked" @endif />
                                                    <label for="now_{{$k+1}}-1">판매안함</label>
                                                </div>
                            <!--
                                                <input type="radio" name="now_{{$k+1}}" value="Y" @if(($c->flag_realtime)=='Y') checked="checked"@endif>판매
                                                <input type="radio" name="now_{{$k+1}}" value="N" @if(($c->flag_realtime)!='Y') checked="checked" @endif>판매 안함
                            -->
                                            </div>
                                        </td>
                                        <td class="table-a__td">
                                            <div class="table-a__inbox ta_l">
                                               <div>
                                                    <input type="radio" id="online_{{$k+1}}" class="radio-v2"  name="online_{{$k+1}}" value="Y" @if(($c->flag_online)=='Y') checked="checked" @endif>
                                                    <label for="online_{{$k+1}}">판매함</label>
                                                </div>
                                                <div>
                                                    <input type="radio" id="online_{{$k+1}}-1" class="radio-v2" name="online_{{$k+1}}" value="N" @if(($c->flag_online)!='Y') checked="checked"@endif />
                                                    <label for="online_{{$k+1}}-1">판매안함</label>
                                                </div>
                            <!--
                                                <input type="radio" name="online_{{$k+1}}" value="Y" @if(($c->flag_online)=='Y') checked="checked" @endif>판매
                                                <input type="radio" name="online_{{$k+1}}" value="N" @if(($c->flag_online)!='Y') checked="checked"@endif>판매 안함
                            -->
                                            </div>
                                        </td>
                                        <td class="table-a__td">
                                            <div class="table-a__inbox">
                                               <input type="checkbox" id="delete_{{$k+1}}" class="checkbox-v1 type-notxt" name="delete_{{$k+1}}" value="ok"><label for="delete_{{$k+1}}"></label>
                            <!--                                            <input type="checkbox" name="delete_{{$k+1}}" value="ok">-->
                                            </div>
                                        </td>

                                        <!--
                                    <td scope="row">{{$k+1}}</td>
                                    <td><input type="hidden" name="client_type_room_group_{{$k+1}}" value="{{isset($ClientTypeRoom)?$c->type_id:""}}"></td>
                                    <td><input type="hidden" name="client_type_room_id_{{$k+1}}" value="{{isset($ClientTypeRoom)?$c->id:""}}"></td>
                                    <td>{{ $c->room_name}}</td>
                                    <td><input type="radio" name="now_{{$k+1}}"  value="Y" @if(($c->flag_realtime)=='Y') checked="checked"@endif>판매<input type="radio" name="now_{{$k+1}}" value="N" @if(($c->flag_realtime)!='Y') checked="checked" @endif>판매 안함</td>
                                    <td>
                                    <input type="radio" name="online_{{$k+1}}" value="Y" @if(($c->flag_online)=='Y') checked="checked" @endif>판매  <input type="radio" name="online_{{$k+1}}" value="N" @if(($c->flag_online)!='Y') checked="checked"@endif>판매 안함</td>
                                    <td><input type="checkbox" name="delete_{{$k+1}}" value="ok"></td>
                            -->
                                    </tr>
                                    @endforeach





                                </tbody>
                            </table>
                        </div>
                        {{ $ClientTypeRoom->appends(['clientList'=>$clientList->currentPage(), 'ClientTypeRoom'=>$ClientTypeRoom->currentPage()])->links('admin.pc.pagination.default') }}

                    </div>
                </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        //로딩시 호출
        scroll_height(350);

        window.addEventListener('resize', function(event){//리사이즈시마다 호출
            scroll_height(350);
        });

        //리스트 사이즈 리사이징 함수
        function scroll_height(num){


            var who = document.getElementById("js-scroll-height");

            var wH = window.innerHeight;
            var scrollH = wH - num;
            var whoH = who.clientHeight;
            console.log('whoH'+whoH);
            console.log('scrollH' +scrollH);

            if( whoH < scrollH-30){
                who.style.height = "auto";
            }else{
//                 console.log('작동 ㄱㄱ');
                who.style.height = scrollH + "px";
            }


        }


    });













</script>
