@extends("admin.pc.layout.basic")

@section("title")숙박업체 관리@endsection

@section("scripts")
@endsection

@section("styles")
@endsection

@section("contents")

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
@endsection
