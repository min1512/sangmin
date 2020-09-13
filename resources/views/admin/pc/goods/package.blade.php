@extends("admin.pc.layout.basic")

@section("title")상품(패키지)관리@endsection

@section("scripts")
    <script>
        $(function(){
        });
    </script>
@endsection

@section("styles")
@endsection

@section("contents")
    <div class="cont-wrap">
        <div class="table-a noto">
            <div class="table-a__head clb">
                <p class="table-a__tit fl">상품 / 패키지 관리</p>
                <div class="table-a_inbox type-head fr">
                    <a href="{{route('goods.save')}}" class="btn-v1">신규 등록</a>
                </div>
            </div>
            <table class="table-a__table">
                <tr class="table-a__tr type-th">
                    <th class="table-a__th type-border" rowspan="2">번호</th>
                    <th class="table-a__th type-border" rowspan="2">펜션/호텔명</th>
                    <th class="table-a__th type-border" rowspan="2">구성상품</th>
                    <th class="table-a__th type-border" colspan="4">판매가</th>
                    <th class="table-a__th type-border" colspan="4">할인가</th>
<!--
                   <th class="table-a__th type-border" rowspan="2">판매가</th>
                    <th class="table-a__th type-border" rowspan="2">할인가</th>

-->
                    <th class="table-a__th type-border" rowspan="2">판매여부</th>
                    <th class="table-a__th type-border" rowspan="2">누적예약</th>
                    <th class="table-a__th type-border" rowspan="2">관리</th>
                </tr>
                <tr class="table-a__tr type-th" style="border-top:1px solid #ffb7b2;">
                    <th class="table-a__th type-border">일요일</th>
                    <th class="table-a__th type-border">주중</th>
                    <th class="table-a__th type-border">금요일</th>
                    <th class="table-a__th type-border">토요일<br>(공휴일 전날)</th>
                    <th class="table-a__th type-border">일요일</th>
                    <th class="table-a__th type-border">주중</th>
                    <th class="table-a__th type-border">금요일</th>
                    <th class="table-a__th type-border">토요일<br>(공휴일 전날)</th>
                </tr>

                @foreach($list as $k => $l)
                <tr class="table-a__tr">
                    <td class="table-a__td">{{ $list->total()-($list->currentPage()-1)*$list->perPage()-$k }}</td>
                    <td class="table-a__td">{{ $l->client_name }}</td>
                    <td class="table-a__td">{{ $l->room_name }}</td>

                    <td class="table-a__td">{{ number_format($l->goods_price_origin_0) }}</td>
                    <td class="table-a__td">{{ number_format($l->goods_price_origin_1) }}</td>
                    <td class="table-a__td">{{ number_format($l->goods_price_origin_5) }}</td>
                    <td class="table-a__td">{{ number_format($l->goods_price_origin_6) }}</td>

                    <td class="table-a__td">{{ number_format($l->goods_price_sales_0) }}</td>
                    <td class="table-a__td">{{ number_format($l->goods_price_sales_1) }}</td>
                    <td class="table-a__td">{{ number_format($l->goods_price_sales_5) }}</td>
                    <td class="table-a__td">{{ number_format($l->goods_price_sales_6) }}</td>

                    <td class="table-a__td">
                        <span class="sign-span type-ok"></span>
                    </td>
                    <td class="table-a__td">-</td>
                    <td class="table-a__td">
                        <a href="{{route('goods.save',['id'=>$l->id])}}" class="btn-v2">관리</a>
                    </td>
                </tr>
                @endforeach

            </table>

        </div>

    </div>
@endsection
