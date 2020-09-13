@extends("admin.pc.layout.basic")

@section("title")
@endsection

@section("scripts")
    <script>
    </script>
@endsection

@section("styles")
<!--
    <link rel="stylesheet" href="http://staff.einet.co.kr/asset/css/common-b.css">
	<link rel="stylesheet" href="http://staff.einet.co.kr/asset/css/blade.css?v=<?=time() ?>">
    <link rel="stylesheet" href="http://staff.einet.co.kr/asset/css/jjh-style.css">
-->
@endsection

@section("contents")
    <div id="i_order_save_blade">
        <div class="order_save_blade-wrap">
            <div>
                <div class="table-a noto">
                    <div class="table-a__head clb">
                        <p class="table-a__tit fl">예약목록</p>
                    </div>
                    <table class="table-a__table order_save_table1">
                        <colgroup>
                            <col width="15%">
                            <col width="35%">
                            <col width="15%">
                            <col width="35%">
                        </colgroup>
                        <tr class="table-a__tr type-th">
                            <td class="table-a__td type-point-2">
                                <div class="table-a__inbox summary"><span>신청자</span></div>
                            </td>
                            <td class="table-a__td">
                                <div class="table-a__inbox"><span>{{$info->order_name}}</span></div>
                            </td>
                            <td class="table-a__td type-point-2">
                                <div class="table-a__inbox  summary"><span>예약번호</span></div>
                            </td>
                            <td class="table-a__td">
                                <div class="table-a__inbox"><span>{{$info->id}}</span></div>
                            </td>
                        </tr>
                        <tr class="table-a__tr">
                            <td class="table-a__td type-point-2">
                                <div class="table-a__inbox  summary"><span>신청일자</span></div>
                            </td>
                            <td class="table-a__td">
                                <div class="table-a__inbox"><span>{{$info->created_at}}</span></div>
                            </td>
                            <td class="table-a__td type-point-2">
                                <div class="table-a__inbox  summary"><span>예약자</span></div>
                            </td>
                            <td class="table-a__td">
                                <div class="table-a__inbox"><span>{{$info->reserve_name}}</span></div>
                            </td>
                        </tr>
                        <tr class="table-a__tr">
                            <td class="table-a__td type-point-2">
                                <div class="table-a__inbox  summary"><span>신청자 연락처</span></div>
                            </td>
                            <td class="table-a__td">
                                <div class="table-a__inbox"><span>{{$info->order_hp}}</span></div>
                            </td>
                            <td class="table-a__td type-point-2">
                                <div class="table-a__inbox  summary"><span>예약자 연락처</span></div>
                            </td>
                            <td class="table-a__td">
                                <div class="table-a__inbox"><span>{{$info->reserve_hp}}</span></div>
                            </td>
                        </tr>

                    </table>
                    <table class="table-a__table order_save_table2">
                        <colgroup>
                            <col width="15%">
                            <col width="35%">
                            <col width="15%">
                            <col width="35%">
                        </colgroup>
                        @foreach($detail as $d)
                        <tr class="table-a__tr type-th">
                            <td class="table-a__td type-point-2">
                                <div class="table-a__inbox  summary"><span>펜션명</span></div>
                            </td>
                            <td class="table-a__td">
                                <div class="table-a__inbox"><span>{{$d->client_name}}</span></div>
                            </td>
                            <td class="table-a__td type-point-2">
                                <div class="table-a__inbox  summary"><span>객실</span></div>
                            </td>
                            <td class="table-a__td">
                                <div class="table-a__inbox"><span>{{$d->room_name}}</span></div>
                            </td>
                        </tr>
                        <tr class="table-a__tr">
                            <td class="table-a__td type-point-2">
                                <div class="table-a__inbox  summary"><span>숙박인원</span></div>
                            </td>
                            <td class="table-a__td">
                                <div class="table-a__inbox"><span>성인({{$d->cnt_adult}}) / 아동({{$d->cnt_child}}) / 유아({{$d->cnt_baby}})</span></div>
                            </td>
                            <td class="table-a__td type-point-2">
                                <div class="table-a__inbox  summary"><span>입실일</span></div>
                            </td>
                            <td class="table-a__td">
                                <div class="table-a__inbox"><span>{{$d->reserve_date}}</span></div>
                            </td>
                        </tr>
                        <tr class="table-a__tr">
                            <td class="table-a__td type-point-2">
                                <div class="table-a__inbox  summary"><span>부가서비스</span></div>
                            </td>
                            <td class="table-a__td">
                                <div class="table-a__inbox"><span></span></div>
                            </td>
                            <td class="table-a__td type-point-2">
                                <div class="table-a__inbox  summary"><span>퇴실일</span></div>
                            </td>
                            <td class="table-a__td">
                                <div class="table-a__inbox"><span>{{$d->reserve_date}}</span></div>
                            </td>
                        </tr>
                        <tr class="table-a__tr">
                            <td class="table-a__td type-point-2">
                                <div class="table-a__inbox  summary"><span>예약금액</span></div>
                            </td>
                            <td class="table-a__td">
                                <div class="table-a__inbox"><span>100,000원</span></div>
                            </td>
                            <td class="table-a__td type-point-2">
                                <div class="table-a__inbox"><span></span></div>
                            </td>
                            <td class="table-a__td">
                                <div class="table-a__inbox"><span></span></div>
                            </td>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
