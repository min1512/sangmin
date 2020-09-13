@extends("admin.pc.layout.basic")

@section("title")직원관리@endsection

@section("scripts")
<script>
    $(function() {
        $("button.btnSave").click(function() {
            document.location.href = '{{route('user.staff.save')}}/' + $(this).data("id");
        });
    });

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
@include("admin.pc.include.price.etc1_search",['search'=>isset($search)?$search:[]])

<div id="i_staff_agency_list">
    <div class="guide-wrap">
        <div>
            <div class="table-a noto type-bb">
                <div class="table-a__head clb">
                    <p class="table-a__tit fl">직원 관리</p>
                    <div class="table-a_inbox type-head fr">
                        <button type="button" class="btn-v1" onclick="goUrl('{{ route('user.staff.save',['id'=>0])}}');">직원 신규 등록</button>
                    </div>
                </div>
                <table class="table-a__table">
                    <colgroup>
                        <col width="5%">
                        <col width="16%">
                        <col width="">
                        <col width="16%">
                        <col width="16%">
                        <col width="12%">
                    </colgroup>
                    <tr class="table-a__tr type-th">
                        <th class="table-a__th">번호</th>
                        <th class="table-a__th">직원명</th>
                        <th class="table-a__th">이메일</th>
                        <th class="table-a__th">연락처</th>
                        <th class="table-a__th">생년월일</th>
                        <th class="table-a__th"></th>
                    </tr>
                    @foreach($staff as $k => $s)
                    <tr class="table-a__tr type-point">
                        <td class="table-a__td">
                            <div class="table-a__inbox">
                                <span>{{ $staff->total()-($staff->currentPage()-1)*$staff->perPage()-$k }}</span>
                            </div>
                        </td>
                        <td class="table-a__td">
                            <div class="table-a__inbox"><span class="type-point type-line">{{$s->staff_name}}</span></div>
                        </td>
                        <td class="table-a__td">
                            <div class="table-a__inbox"><span class="type-point type-line">{{$s->email}}</span></div>
                        </td>
                        <td class="table-a__td">
                            <div class="table-a__inbox"><span class="type-point">{{$s->staff_hp}}</span></div>
                        </td>
                        <td class="table-a__td">
                            <div class="table-a__inbox"><span class="type-point">{{$s->staff_birth}}({{$s->staff_lunar=="Y"?"음":"양"}})</span></div>
                        </td>
                        <td class="table-a__td">
                            <div class="table-a__inbox">
                                <button type="button" class="table-a__btn type-info btn-v2 btnSave" data-id="{{$s->user_id}}">수정</button>
                                <button type="button" class="table-a__btn type-info btn-v2">삭제</button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </table>
                {{ $staff->links('admin.pc.pagination.default') }}
            </div>
        </div>
    </div>
</div>
@endsection
