@extends("admin.pc.layout.basic")

@section("title")숙박업소관리-설정-공지사항/팝업@endsection

@section("styles")
@endsection

@section("scripts")
@endsection

@section("contents")
    @include("admin.pc.include.client.config_navi")

    <button type="button" onclick="goUrl('{{route("client.config_notice_save",["user_id"=>$id])}}');">등록</button>
    <table cellpadding="0" cellspacing="0">
        <thead>
        <tr>
            <td>구분</td>
            <td>대상</td>
            <td>제목</td>
            <td>공지</td>
            <td>팝업</td>
            <td>팝업사용기간</td>
            <td>노출</td>
            <td>상세</td>
            <td>삭제</td>
        </tr>
        </thead>
        <tbody>
        @foreach($notice as $n)
            <tr>
                <td>{{$n->id}}</td>
                <td>{{$n->target_type}}</td>
                <td>{{$n->title}}</td>
                <td>{{$n->flag_notice=="Y"?"●":"○"}}</td>
                <td>{{$n->flag_popup=="Y"?"○":"●"}}</td>
                <td>{{$n->date_open}}~{{$n->date_close}}</td>
                <td>{{$n->flag_use}}</td>
                <td>상세</td>
                <td>삭제</td>
            </tr>
        @endforeach
        </tbody>
        <tfoot>
        <tr>
            <td colspan="9">{{ $notice->links('admin.pc.pagination.default') }}</td>
        </tr>
        </tfoot>
    </table>
@endsection
