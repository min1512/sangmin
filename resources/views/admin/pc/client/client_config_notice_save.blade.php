@extends("admin.pc.layout.basic")

@section("title")숙박업소관리-설정-공지사항/팝업 상세@endsection

@section("styles")
@endsection

@section("scripts")
@endsection

@section("contents")
    @include("admin.pc.include.client.config_navi")

    <form method="post" name="frmNotice" action="{{url()->current()}}">
        {{ csrf_field() }}
        <input type="hidden" name="user_id" value="{{$id}}" />
        <input type="hidden" name="id" value="{{isset($notice)?$notice->id:""}}" />
        <p>
            공지/팝업 대상:
            <input type="checkbox" value="N" id="all_click" class="allClick" /><label for="all_click">전체</label>
            <input type="checkbox" name="target_type[]" id="target_customer" value="customer" /><label for="target_customer">회원</label>
            <input type="checkbox" name="target_type[]" id="target_client" value="client" /><label for="target_client">펜션</label>
            <input type="checkbox" name="target_type[]" id="target_agency" value="agency" /><label for="target_agency">대행사</label>
            <input type="checkbox" name="target_type[]" id="target_staff" value="staff" /><label for="target_staff">직원</label>
        </p>
        <p>제목: <input type="text" name="title" value="{{isset($notice)?$notice->title:""}}" /></p>
        <p>내용: <textarea name="content">{{isset($notice)?$notice->content:""}}</textarea></p>
        <p>
            공지여부:
            <input type="radio" name="flag_notice" id="flag_notice_Y" value="Y" /><label for="flag_notice_Y">Y</label>
            <input type="radio" name="flag_notice" id="flag_notice_N" value="N" /><label for="flag_notice_N">N</label>
        </p>
        <p>
            팝업여부:
            <input type="radio" name="flag_popup" id="flag_popup_Y" value="Y" /><label for="flag_popup_Y">Y</label>
            <input type="radio" name="flag_popup" id="flag_popup_N" value="N" /><label for="flag_popup_N">N</label>
        </p>
        <p>
            기간:
            <input type="text" name="date_open" class="datepicker" /> ~
            <input type="text" name="date_close" class="datepicker" />
        </p>
        <p>
            사용여부:
            <input type="radio" name="flag_use" id="flag_use_Y" value="Y" /><label for="flag_use_Y">사용</label>
            <input type="radio" name="flag_use" id="flag_use_N" value="N" /><label for="flag_use_N">미사용</label>
            <input type="radio" name="flag_use" id="flag_use_R" value="R" /><label for="flag_use_R">준비</label>
            <input type="radio" name="flag_use" id="flag_use_H" value="H" /><label for="flag_use_H">숨김</label>
        </p>
        <button type="submit">저장</button>
    </form>
@endsection
