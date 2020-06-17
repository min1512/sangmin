@extends("layout.basic")

@section("title")숙박업체목록@endsection

@section("scripts")
@endsection

@section("styles")
@endsection

@section("contents")
    @include("admin.include.content_title", [
        'title'=>'숙박업체 목록',
        'mean'=>'회원관리 > 숙박업체목록'
    ])

    <div class="row">
        <div class="main-card mb-3 card" style="width:100%; ">
            <div class="card-body">
                <h5 class="card-title">Search</h5>
                <table class="mb-0 table">
                    <tr>
                        <td>검색1</td>
                        <td>검색2</td>
                        <td>검색3</td>
                        <td>검색4</td>
                        <td>검색5</td>
                        <td>검색6</td>
                        <td>검색7</td>
                        <td>
                            <button class="mr-2 btn-transition btn btn-outline-dark">검색</button>
                            <button class="mr-2 btn btn-focus" onclick="goUrl('{{route('user.client.save')}}');">숙박업체등록</button>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="main-card mb-3 card" style="width:100%; ">
            <div class="card-body"><h5 class="card-title">Client List</h5>
                <table class="mb-0 table table-hover">
                    <thead>
                    <tr>
                        <th>&nbsp;</th>
                        <th>업체명</th>
                        <th>UserEmail(ID)</th>
                        <th>연락처</th>
                        <th>수수료(예약/결제)</th>
                        <th>상태</th>
                        <th>정보</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($clientList as $k => $c)
                        <tr>
                            <th scope="row">{{ $clientList->total()-$k }}</th>
                            <td>{{ $c->client_name }}</td>
                            <td>{{ $c->email }}</td>
                            <td>{{ $c->client_hp }}</td>
                            <td>
                                {{ $c->client_fee_agency.$c->client_fee_agency_unit }}
                                /
                                {{ $c->client_fee_payment.$c->client_fee_payment_unit }}
                            </td>
                            <td>정상</td>
                            <td>
                                <button class="mr-2 btn btn-success" onclick="goUrl('{{route('user.client.save',['id'=>$c->user_id])}}');">업체정보</button>
{{--                                <button class="mr-2 btn btn-secondary" onclick="goUrl('{{route('user.client.company',['id'=>$c->user_id])}}');">사업자정보</button>--}}
                                <button class="mr-2 btn btn-info" onclick="goUrl('{{route('user.client.settle',['id'=>$c->user_id])}}');">사업자/정산정보</button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
