@extends("admin.pc.layout.basic")

@section("title")업체별 요금 목록@endsection

@section("scripts")
@endsection

@section("styles")
@endsection

@section("contents")
    @include("admin.pc.include.content_title", [
        'title'=>'업체별 요금정보',
        'mean'=>'Client Price'
    ])

    <ul>
    @foreach($clientList as $c)
        <li>
            <span>{{$c->id}}</span>
            <span>{{$c->client_name}}</span>
            <span>
                <button type="button" onclick="goUrl('{{route('price.list.calc',['id'=>$c->id])}}')">요금설정</button>
                <button type="button" onclick="goUrl('{{route('price.list.season',['id'=>$c->id])}}')">시즌/시즌요금</button>
                <button type="button" onclick="goUrl('{{route('price.list.discount',['id'=>$c->id])}}')">할인판매설정</button>
                <button type="button" onclick="goUrl('{{route('price.list.autoset',['id'=>$c->id])}}')">자동할인설정</button>
                <button type="button" onclick="goUrl('{{route('price.list.etc',['id'=>$c->id])}}')">기타이용요금</button>
            </span>
        </li>
    @endforeach
    </ul>
@endsection
