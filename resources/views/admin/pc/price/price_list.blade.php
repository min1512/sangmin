@extends("admin.pc.layout.basic")

@section("title")요금관리목록@endsection

@section("scripts")
<script>
    $(document).ready(function(e) {
        genRowspan("gubun");
        genRowspan("gubun1");
    });

    function genRowspan(className) {
        $("." + className).each(function() {
            var rows = $("." + className + ":contains('" + $(this).text() + "')");
            if (rows.length > 1) {
                rows.eq(0).attr("rowspan", rows.length);
                rows.not(":eq(0)").remove();
            }
        });
    }

</script>
@endsection

@section("styles")
<link rel="stylesheet" href="http://staff.einet.co.kr/asset/css/common-b.css?v=<?=time()?>">
<link rel="stylesheet" href="http://staff.einet.co.kr/asset/css/blade.css?v=<?=time() ?>">
@endsection

@section("contents")

<div class="table-a noto">
    <div class="table-a__head clb">
        <p class="table-a__tit fl">숙박업소 관리</p>
    </div>
    <table class="table-a__table">
        <colgroup>
            <col width="5%">
            <col width="10%">
            <col width="10%">
            <col width=*>
            <col width="10%">
            <col width="10%">
            <col width="10%">
            <col width="10%">
        </colgroup>
        <tr class="table-a__tr type-th">
            <th class="table-a__th">번호</th>
            <th class="table-a__th">펜션명</th>
            <th class="table-a__th">룹타입</th>
            <th class="table-a__th">객실수(판매객실수)</th>
            <th class="table-a__th">요금오픈기간</th>
        </tr>
        @foreach($UserClient as $k => $v)
        <tr class="table-a__tr">
            <td class="table-a__td" rowspan="2">
                <div class="table-a__inbox">
                    <span>{{$UserClient->total()-($UserClient->currentPage()-1)*$UserClient->perPage()-$k}}</span>
                </div>
            </td>
            <td class="table-a__td" rowspan="2">
                <div class="table-a__inbox">
                    <span>{{$v->client_name}}</span>
                </div>
            </td>
            <td class="table-a__td">
                <div class="table-a__inbox">
                    <span>{{$v->cnt_room_type}}개</span>
                </div>
            </td>
            <td class="table-a__td">
                <div class="table-a__inbox">
                    <span>{{$v->cnt_room}}개({{$v->cnt_room_open}}개)</span>
                </div>
            </td>
            <td class="table-a__td">
                <div class="table-a__inbox">
                    <span>{{$v->cnt_day}}일</span>
                </div>
            </td>
        </tr>
        <tr class="table-a__tr">
            <td class="table-a__td" colspan="3">
                <div class="table-a__inbox ta-l fl">
                    <button type="button" class="btn-v5 type-dayfee" onclick="goUrl('{{ route('price.calendar',['user_id'=>$v->user_id])}}');"><span>일자별 요금설정</span></button>
                </div>
                <div class="table-a__inbox ta-l fl">
                    <button type="button" class="btn-v5 type-season" onclick="goUrl('{{ route('price.list',['user_id'=>$v->user_id])}}');"><span>성수기/시즌</span></button>
                </div>
                <div class="table-a__inbox ta-l fl">
                    <button type="button" class="btn-v5 type-sale" onclick="goUrl('{{ route('price.discount',['user_id'=>$v->user_id])}}');"><span>할인 판매 설정</span></button>
                </div>
                <div class="table-a__inbox ta-l fl">
                    <button type="button" class="btn-v5 type-auto" onclick="goUrl('{{ route('price.autoset',['user_id'=>$v->user_id])}}');"><span>자동 할인 설정</span></button>
                </div>
                <div class="table-a__inbox ta-l fl">
                    <button type="button" class="btn-v5 type-addfee" onclick="goUrl('{{ route('price.facility',['user_id'=>$v->user_id])}}');"><span>추가 이용 요금</span></button>
                </div>
            </td>
        </tr>
        @endforeach
        <tfoot>
            <tr>
                <td colspan="10">{{ $UserClient->links('admin.pc.pagination.default') }}</td>
            </tr>
        </tfoot>
    </table>

</div>



<!--
<table class="default" cellpadding="0" cellspacing="0">
    <thead>
        <tr>
            <td>구분</td>
            <td>업체명</td>
            <td>룸타입</td>
            <td>객실수(판매객실수)</td>
            <td>요금오픈기간</td>
            <td colspan="5">관리</td>
        </tr>
    </thead>
    <tbody>
        @foreach($UserClient as $k => $v)
        <tr>
            <td>{{$UserClient->total()-($UserClient->currentPage()-1)*$UserClient->perPage()-$k}}</td>
            <td>{{$v->client_name}}</td>
            <td>{{$v->cnt_room_type}}개</td>
            <td>{{$v->cnt_room}}개({{$v->cnt_room_open}}개)</td>
            <td>{{$v->cnt_day}}일</td>
            <td><button class="btn_gray_00" onclick="goUrl('{{ route('price.calendar',['user_id'=>$v->user_id])}}');">일자별 요금설정 </button></td>
            <td><button class="btn_gray_00" onclick="goUrl('{{ route('price.list',['user_id'=>$v->user_id])}}');">성수기/시즌 </button></td>
            <td><button class="btn_gray_00" onclick="goUrl('{{ route('price.discount',['user_id'=>$v->user_id])}}');">할인판매설정 </button></td>
            <td><button class="btn_gray_00" onclick="goUrl('{{ route('price.autoset',['user_id'=>$v->user_id])}}');">자동할인설정</button></td>
            <td><button class="btn_gray_00" onclick="goUrl('{{ route('price.facility',['user_id'=>$v->user_id])}}');">기타이용요금</button></td>
        </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td colspan="10">{{ $UserClient->links('admin.pc.pagination.default') }}</td>
        </tr>
    </tfoot>
</table>
-->
@endsection
