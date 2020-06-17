@extends("layout.basic")

@section("title")숙박업체@endsection

@section("scripts")
@endsection

@section("styles")
@endsection

@section("contents")
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
                            <button class="mr-2 btn btn-focus" onclick="goUrl('{{route('client.save')}}');">숙박업체등록</button>
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
                            <button class="mr-2 btn btn-success" onclick="goUrl('{{route('client.info.basic',['id'=>$c->user_id])}}');">정보</button>
                            <button class="mr-2 btn btn-secondary" onclick="goUrl('{{route('client.info.type',['id'=>$c->user_id])}}');">객실</button>
                            <button class="mr-2 btn btn-info" onclick="goUrl('{{route('client.info.price',['id'=>$c->user_id])}}');">요금</button>
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
