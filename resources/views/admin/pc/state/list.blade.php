@extends("admin.pc.layout.basic")

@section("title")예약시스템 현황관리@endsection

@section("scripts")
@endsection

@section("styles")
@endsection

@section("contents")
<div class="table-a noto">
    <div class="table-a__head clb">
        <p class="table-a__tit fl">펜션현황</p>
    </div>
    <table class="table-a__table">
        <colgroup>
            <col width="50">
            <col width="200">
            <col width="*">
        </colgroup>
        <tbody>
            <tr class="table-a__tr type-th">
                <th class="table-a__th ta-c">번호</th>
                <th class="table-a__th ta-c">펜션명</th>
                <th class="table-a__th ta-c">현황 리스트</th>
            </tr>
            @foreach($list as $k => $l)
            <tr class="table-a__tr">
                <td class="table-a__td">{{ $list->total()-($list->currentPage()-1)*$list->perPage()-$k }}</td>
                <td class="table-a__td">{{ $l->client_name }}</td>
                <td class="table-a__td ta-c">
                    <a href="{{ route('state.room',['id'=>$l->user_id]) }}" class="btn-v6 type-dayfee">일자별 객실현황</a>
                    <a href="{{ route('state.order',['id'=>$l->user_id]) }}" class="btn-v6 type-season">월별 객실현황</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $list->links('admin.pc.pagination.default') }}
</div>


@endsection
