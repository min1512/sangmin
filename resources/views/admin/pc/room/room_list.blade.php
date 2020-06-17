@extends("admin.pc.layout.basic")

@section("title")룸타입목록@endsection

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
        @foreach($user_client as $v)
            <tr>
                <td>{{$v->client_name}}</td>
                <td><button class="btn_gray_00" onclick="goUrl('{{ route('user.client.save',['id'=>$v->user_id,'check'=>"check"])}}');">숙박업소 관리</button></td>
                <td><button class="btn_gray_00">설정</button></td>
                <td><button class="btn_gray_00" onclick="goUrl('{{ route('room.list',['user_id'=>$v->user_id])}}');">객실 관리</button></td>
                <td><button class="btn_gray_00" onclick="goUrl('{{ route('client.block',['id'=>$v->user_id])}}');">방막기</button></td>
                <td><button class="btn_gray_00" onclick="goUrl('{{ route('client.over',['id'=>$v->user_id])}}');" >연박 설정</button></td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
