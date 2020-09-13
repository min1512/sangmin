@extends("admin.pc.layout.basic")

@section("title")대행사관리@endsection

@section("scripts")
    <script>
        $(function(){
            $("button.btnSave").click(function(){
                document.location.href='{{route('user.agency.save')}}/'+$(this).data("id");
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
                    <p class="table-a__tit fl">대행사 관리</p>
                    <div class="table-a_inbox type-head fr">
                        <button type="button" class="btn-v1" onclick="goUrl('{{ route('user.agency.save',['id'=>0])}}');">대행사 신규 등록</button>
                    </div>
                </div>
                <table class="table-a__table">
                    <colgroup>
                        <col width="5%">
                        <col width="11%">
                        <col width="13%">
                        <col width="">
                        <col width="">
                        <col width="15%">
                        <col width="12%">
                    </colgroup>
                    <tr class="table-a__tr type-th">
                        <th class="table-a__th">번호</th>
                        <th class="table-a__th">대행사명</th>
                        <th class="table-a__th">사업자번호</th>
                        <th class="table-a__th">주소</th>
                        <th class="table-a__th">이메일</th>
                        <th class="table-a__th">연락처</th>
                        <th class="table-a__th"></th>
                    </tr>
                    @foreach($agency as $k => $a)
                    <tr class="table-a__tr type-point">
                        <td class="table-a__td">
                            <div class="table-a__inbox"><span>{{ $agency->total()-($agency->currentPage()-1)*$agency->perPage()-$k }}</span></div>
                        </td>
                        <td class="table-a__td">
                            <div class="table-a__inbox"><span class="type-point type-line">{{$a->agency_name}}</span></div>
                        </td>
                        <td class="table-a__td">
                            <div class="table-a__inbox"><span class="type-point type-line">{{$a->agency_number}}</span></div>
                        </td>
                        <td class="table-a__td">
                            <div class="table-a__inbox"><span class="type-point"><P>{{ $a->agency_addr_basic }}</P><p>{{ $a->agency_addr_detail }}</p></span></div>
                        </td>
                        <td class="table-a__td">
                            <div class="table-a__inbox"><span class="type-point">{{$a->email}}</span></div>
                        </td>
                        <td class="table-a__td">
                            <div class="table-a__inbox"><span class="type-point">{{$a->agency_tel}} / {{$a->agency_hp}}</span></div>
                        </td>
                        <td class="table-a__td">
                            <div class="table-a__inbox">
                                <button type="button" class="table-a__btn type-info btn-v2 btnSave" data-id="{{$a->user_id}}">수정</button>
                                <button type="button" class="table-a__btn type-info btn-v2 btnDel" data-id="{{$a->user_id}}">삭제</button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </table>
                {{ $agency->links('admin.pc.pagination.default') }}
            </div>
        </div>
    </div>
</div>
@endsection
