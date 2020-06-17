@extends("admin.pc.layout.main")

@section("title")
@endsection

@section("scripts")
@endsection

@section("styles")
@endsection

@section("contents")
    <table>
        <tr>
            <td>순번</td>
            <td>예약자</td>
            <td>펜션명</td>
        </tr>
    @foreach($order as $o)
        <tr>
            <td>{{ $o->id }}</td>
            <td>{{ $o->order_name }}</td>
            <td>{{ $o->client_name }}</td>
        </tr>
    @endforeach
    </table>
@endsection
