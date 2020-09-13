@extends("admin.pc.layout.basic")

@section("title")숙박업체 관리@endsection

@section("scripts")
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
    <div class="guide-wrap client_list">
        <div>
            <div class="table-a noto type-bb">
                <div class="table-a__head clb">
                    <p class="table-a__tit fl">숙박업체 관리</p>
                    <div class="table-a_inbox type-head fr">
                        <button type="button" class="btn-v1" onclick="goUrl('{{ route('user.client.save',['id'=>0])}}');">숙박업체 신규 등록</button>
                    </div>
                </div>
                <table class="table-a__table">
                    <colgroup>
                        <col width="4%">
                        <col width="8.5%">
                        <col width="">
                        <col width="5%">
                        <col width="12%">
                        <col width="10%">
                        <col width="7%">
                        <col width="7%">
                        <col width="6%">
                        <col width="10%">
                        <col width="13%">
                    </colgroup>
                    <tr class="table-a__tr type-th">
                        <th class="table-a__th"><p>번호</p></th>
                        <th class="table-a__th"><p>회원구분</p></th>
                        <th class="table-a__th"><p>업소명</p></th>
                        <th class="table-a__th"><p>사용</p><p>여부</p>
                        <th class="table-a__th"><p>지역</p></th>
                        <th class="table-a__th"><p>시스템</p><p>설치</p>
                        <th class="table-a__th"><p>카드</p><p>수수료</p>
                        <th class="table-a__th"><p>예매</p><p>수수료</p>
                        <th class="table-a__th"><p>업소</p><p>종류</p>
                        <th class="table-a__th"><p>등록일자</p></th>
                        <th class="table-a__th"></th>
                    </tr>
                    @foreach($clientList as $k => $c)
                    <tr class="table-a__tr type-point">
                        <td class="table-a__td">
                            <div class="table-a__inbox">
                                <span>{{ $clientList->total()-$k }}</span>
                            </div>
                        </td>
                        <td class="table-a__td">
                            <div class="table-a__inbox">
                                <span class="type-point type-line">{{ $c->client_gubun }}</span>
                            </div>
                        </td>
                        <td class="table-a__td">
                            <div class="table-a__inbox">
                                <span class="type-point type-line">{{ $c->client_name }}</span>
                            </div>
                        </td>
                        <td class="table-a__td">
                            <div class="table-a__inbox">
                                <span class="type-point">@if($c->flag_use=="Y")사용@else사용안함@endif</span>
                            </div>

                        </td>
                        <td class="table-a__td">
                            <div class="table-a__inbox">
                                <span class="type-point">{{ $c->client_addr_basic }}</span>
                            </div>
                        </td>
                        <td class="table-a__td">
                            <div class="table-a__inbox">
                                <span class="type-point">시스템설치</span>
                            </div>
                        </td>
                        <td class="table-a__td">
                            <div class="table-a__inbox">
                                <span class="type-point">{{$c->client_fee_payment.$c->client_fee_payment_unit}}</span>
                            </div>
                        </td>
                        <td class="table-a__td">
                            <div class="table-a__inbox">
                                <span class="type-point">{{$c->client_fee_agency.$c->client_fee_agency_unit}}</span>
                            </div>
                        </td>
                        <td class="table-a__td">
                            @php $client_type = \App\Http\Controllers\Controller::getCode('client_type'); @endphp
                            <div class="table-a__inbox">
                                <span class="type-point">
                                    @foreach($client_type as $v)
                                        @if(isset($c->code_type) && $v->code == $c->code_type){{$v->name}}@endif
                                    @endforeach
                                </span>
                            </div>
                        </td>
                        <td class="table-a__td">
                            <div class="table-a__inbox">
                                <span class="type-point">{{date("Y-m-d",strtotime($c->created_at))}}</span>
                            </div>
                        </td>
                        <td class="table-a__td">
                            <div class="table-a__inbox">
                                <button type="button" class="table-a__btn type-info btn-v2" onclick="goUrl('{{route('user.client.save',['id'=>$c->user_id])}}');">업체정보</button>
                            </div>
                            <div class="table-a__inbox">
                                <button type="button" class="table-a__btn type-info btn-v2" onclick="goUrl('{{route('user.client.settle',['id'=>$c->user_id])}}');">사업자/정산정보</button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
        {{ $clientList->links('admin.pc.pagination.default') }}
    </div>
</div>
<!--
    <table class="default" cellpadding="0" cellspacing="0">
        <thead>
        <tr>
            <td>업소번호</td>
            <td>회원구분</td>
            <td>업소명</td>
            <td>사용여부</td>
            <td>지역</td>
            <td>시스템설치</td>
            <td>카드수수료</td>
            <td>예대수수료</td>
            <td>업소종류</td>
            <td>등록일자</td>
            <td><button class="btn_gray_00" onclick="goUrl('{{ route('user.client.save',['id'=>0])}}');">신규 등록</button></td>
        </tr>
        </thead>
        <tbody>
        @foreach($clientList as $k => $c)
            <tr>
                <th scope="row">{{ $clientList->total()-$k }}</th>
                <td>{{ $c->client_gubun }}</td>
                <td>{{ $c->client_name }}</td>
                <td>@if($c->flag_use=="Y")사용@else사용안함@endif</td>
                <td>{{ $c->client_addr_basic }}</td>
                <td>시스템설치</td>
                <td>{{$c->client_fee_payment.$c->client_fee_payment_unit}}</td>
                <td>{{$c->client_fee_agency.$c->client_fee_agency_unit}}</td>
                @php $client_type = \App\Http\Controllers\Controller::getCode('client_type'); @endphp
                <td>
                    @foreach($client_type as $v)
                        @if(isset($c->code_type) && $v->code == $c->code_type){{$v->name}}@endif
                    @endforeach
                </td>
                <td>{{$c->created_at}}</td>
                <td>
                    <button class="mr-2 btn btn-success" onclick="goUrl('{{route('user.client.save',['id'=>$c->user_id])}}');">업체정보</button>
                    <button class="mr-2 btn btn-info" onclick="goUrl('{{route('user.client.settle',['id'=>$c->user_id])}}');">사업자/정산정보</button>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
-->
@endsection
