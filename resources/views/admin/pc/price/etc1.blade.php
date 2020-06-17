@extends("admin.pc.layout.basic")

@section("title")기타이용요금@endsection

@section("scripts")

@endsection

@section("styles")
@endsection

@section("contents")
    @include("admin.pc.include.price.etc1_search",['search'=>isset($search)?$search:[]])

    @include("admin.pc.include.price.etc1_list",['additionetcprice'=>$additionetcprice,'user_id'=>isset($user_id)?$user_id:""])

@endsection