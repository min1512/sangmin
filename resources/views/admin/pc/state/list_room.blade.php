@extends("admin.pc.layout.basic")

@section("title")현황관리@endsection

@section("scripts")
@endsection

@section("styles")
@endsection

@section("contents")
    <div class="table-a__head clb">
        <p class="table-a__tit fl">일자별 객실현황</p>
    </div>
    <div class="daily noto">
        <div class="daily-top">
            <div class="daily-top__center">
                <div class="daily-top__inbox">
                    <span class="daily-top__date">{{date("Y.m.d",$date['curr'])}}</span><br>
                    <span class="daily-top__day">{{$date['yoil'][date("w",$date['curr'])]}}</span>
                </div>
                <a href="{{route('state.room',['id'=>$id,'yy'=>date("Y",$date['prev']),'mm'=>date("n",$date['prev']),'dd'=>date("j",$date['prev'])])}}" class="daily-top__btn type-prev">전날</a>
                <a href="{{route('state.room',['id'=>$id,'yy'=>date("Y",$date['next']),'mm'=>date("n",$date['next']),'dd'=>date("j",$date['next'])])}}" class="daily-top__btn type-next">다음날</a>
            </div>
            <span class="daily-top__days type-left">{{date("Y.m.d",$date['prev'])}}</span>
            <span class="daily-top__days type-right">{{date("Y.m.d",$date['next'])}}</span>
        </div>
        <div class="daily-bottom">
            <div class="daily-bottom__inbox">
                <ul class="daily-bottom__list clb">
                    @foreach($rooms as $r)
                    <li class="daily-bottom__item fl">
                        <div class="daily-room">
                            <p class="daily-room__tit ellipsis">{{$r->room_name}}{{isset($r->order_id)&&$r->order_id!=""?"":" (공실)"}}</p>
                            <div class="daily-room__cont">
                                <div class="daily-room__inbox type-list">
                                    <ol class="daily-room__list">
                                        <li class="daily-room__item">
                                            <span class="daily-room__name">방문(예약)</span>
                                            <span class="daily-room__val ellipsis">{{isset($state[$r->id])?$state[$r->id]->reserve_name:""}}({{isset($state[$r->id])?$state[$r->id]->order_name:""}})</span>
                                        </li>
                                        <li class="daily-room__item">
                                            <span class="daily-room__name">연락처</span>
                                            <span class="daily-room__val ellipsis">{{isset($state[$r->id])?$state[$r->id]->reserve_hp:""}}({{isset($state[$r->id])?$state[$r->id]->order_hp:""}})</span>
                                        </li>
                                        <li class="daily-room__item">
                                            <span class="daily-room__name">추가비용</span>
                                            <span class="daily-room__val ellipsis">{{number_format(isset($state[$r->id])?$state[$r->id]->reserve_scene:0)}}원</span>
                                        </li>
                                        <li class="daily-room__item type-memo">
                                            <span class="daily-room__name">메모</span>
                                            <span class="daily-room__val ellipsis">{{isset($state[$r->id])?$state[$r->id]->reserve_request:""}}</span>
                                             <div class="daily-hover">
                                                <p class="daily-hover__tit">{{$r->room_name}}{{isset($r->order_id)&&$r->order_id!=""?"":" (공실)"}}</p>
                                                <p class="daily-hover__txt">{{isset($state[$r->id])?$state[$r->id]->reserve_request:""}}</p>
                                            </div>
                                        </li>
                                    </ol>
                                </div>
                                <div class="daily-room__inbox type-btn">
                                    <button type="button" class="daily-room__btn js-room-btn {{isset($state[$r->id])&&$state[$r->id]->step_01!=null?"is-active":""}}" data-id="{{isset($state[$r->id])?$state[$r->id]->id:"-"}}" data-field="step_01">체크아웃</button>
                                    <button type="button" class="daily-room__btn js-room-btn {{isset($state[$r->id])&&$state[$r->id]->step_02!=null?"is-active":""}}" data-id="{{isset($state[$r->id])?$state[$r->id]->id:"-"}}" data-field="step_02">청소{{$r->id}}</button>
                                    <button type="button" class="daily-room__btn js-room-btn {{isset($state[$r->id])&&$state[$r->id]->step_03!=null?"is-active":""}}" data-id="{{isset($state[$r->id])?$state[$r->id]->id:"-"}}" data-field="step_03">체크인</button>
                                </div>
                            </div>
                           
                        </div>

                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            $(".js-room-btn").click(function () {//버튼 클릭시 클래스 변경
                if($(this).data('id')!="-") {
                    $(this).toggleClass("is-active");
                    chgState($(this).data('id'), $(this).data('field'));
                }
            });
           
        });

        function chgState(id, field) {
            $.post(
                '/state/room/'+id+'/state'
                ,{
                    _token: '{{csrf_token()}}'
                    ,'field': field
                }
                ,function(data){
                    //console.log(data);
                }
                ,"json"
            )
        }
    </script>
@endsection
