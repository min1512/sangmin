@extends("admin.pc.layout.basic")

@section("title")할인 판매 설정@endsection

@section("scripts")
<script>

</script>
@endsection

@section("styles")
<link rel="stylesheet" href="http://staff.einet.co.kr/asset/css/common-b.css?v=<?=time()?>">
<link rel="stylesheet" href="http://staff.einet.co.kr/asset/css/blade.css?v=<?=time() ?>">
@endsection

@section("contents")
    @include("admin.pc.include.discount.discount_search",['search'=>isset($search)?$search:[]])

    @include("admin.pc.include.discount.discount_list",['discountList'=>$discountList,'client'=>$client,'user_id'=>$user_id])
@endsection

