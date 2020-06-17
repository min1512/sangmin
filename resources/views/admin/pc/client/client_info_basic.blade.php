@extends("layout.basic")

@section("title")숙박업체 기본정보@endsection

@section("scripts")
@endsection

@section("styles")
@endsection

@section("contents")
    <div class="row">
        <div class="main-card mb-3 card" style="width:100%; ">
            <div class="card-body">
                <h5 class="card-title">Search</h5>
                <table class="mb-0 table table-hover">
                    <tr>
                        <td>검색1</td>
                        <td>검색2</td>
                        <td>검색3</td>
                        <td>검색4</td>
                        <td>검색5</td>
                        <td>검색6</td>
                        <td>검색7</td>
                        <td><button class="mb-2 mr-2 btn-transition btn btn-outline-dark">검색</button></td>
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
                        <th>연락처</th>
                        <th>수수료(예약/결제)</th>
                        <th>상태</th>
                        <th>정보</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <th scope="row">1</th>
                        <td>코코앤루루</td>
                        <td>010-3661-3451</td>
                        <td>10%/15%</td>
                        <td>정상</td>
                        <td>
                            <button class="mr-2 btn btn-success">정보</button>
                            <button class="mr-2 btn btn-secondary">객실</button>
                            <button class="mr-2 btn btn-info">요금</button>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">2</th>
                        <td>고멧263</td>
                        <td>010-1234-5678</td>
                        <td>14%/12%</td>
                        <td>준비</td>
                        <td>
                            <button class="mr-2 btn btn-success">정보</button>
                            <button class="mr-2 btn btn-secondary">객실</button>
                            <button class="mr-2 btn btn-info">요금</button>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
