@extends("admin.pc.layout.basic")

@section("title")요금관리목록@endsection

@section("scripts")
    <script>
        $(document).ready(function(e){
            genRowspan("gubun");
            genRowspan("gubun1");
        });
        function genRowspan(className){
            $("." + className).each(function() {
                var rows = $("." + className + ":contains('" + $(this).text() + "')");
                if (rows.length > 1) {
                    rows.eq(0).attr("rowspan", rows.length);
                    rows.not(":eq(0)").remove();
                }
            });
        }
    </script>
@endsection

@section("styles")
@endsection

@section("contents")
        <table class="default" cellpadding="0" cellspacing="0">
            <thead>
            <tr>
                <td>업체명</td>
                <td colspan="4">관리 버튼</td>
            </tr>
            </thead>
            <tbody>
            @foreach($UserClient as $v)
                <tr>
                    <td>{{$v->client_name}}</td>
                    <td><button class="btn_gray_00" onclick="goUrl('{{ route('price.calendar',['user_id'=>$v->user_id])}}');">일자별 요금설정 </button></td>
                    <td><button class="btn_gray_00" onclick="goUrl('{{ route('price.list',['user_id'=>$v->user_id])}}');">성수기/시즌 </button></td>
                    <td><button class="btn_gray_00" onclick="goUrl('{{ route('price.discount',['user_id'=>$v->user_id])}}');">할인판매설정 </button></td>
                    <td><button class="btn_gray_00" onclick="goUrl('{{ route('price.autoset',['user_id'=>$v->user_id])}}');" >자동할인설정</button></td>
                    <td><button class="btn_gray_00" onclick="goUrl('{{ route('price.facility',['user_id'=>$v->user_id])}}');" >기타이용요금</button></td>
                </tr>
            @endforeach
            </tbody>
        </table>
@endsection
