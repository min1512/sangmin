@extends("admin.pc.layout.basic")

@section("title")자동 할인 판매 설정@endsection

@section("scripts")

@endsection

@section("styles")
<!--
<link rel="stylesheet" href="http://staff.einet.co.kr/asset/css/common-b.css?v=<?=time()?>">
<link rel="stylesheet" href="http://staff.einet.co.kr/asset/css/blade.css?v=<?=time() ?>">
-->
@endsection

@section("contents")
    @include("admin.pc.include.auto_discount.discount_search",['search'=>isset($search)?$search:[]])

    @include("admin.pc.include.auto_discount.discount_list",['discountList'=>$discountList, 'client'=>$client,'user_id'=>$user_id, 'Client_type_room'=>$Client_type_room])
@endsection

