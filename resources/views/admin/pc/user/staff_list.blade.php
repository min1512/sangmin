@extends("admin.pc.layout.basic")

@section("title")직원관리@endsection

@section("scripts")
    <script>
        $(function(){
            $("input.btnSave").click(function(){
                document.location.href='{{route('user.staff.save')}}/'+$(this).data("id");
            });
        });
    </script>
@endsection

@section("styles")
@endsection

@section("contents")
    <table class="default" cellpadding="0" cellspacing="0">
        <thead>
        <tr>
            <td>직원명</td>
            <td>이메일</td>
            <td>연락처</td>
            <td>생년월일</td>
            <td><button class="btn_gray_00" onclick="goUrl('{{ route('user.staff.save',['id'=>0])}}');">신규 등록</button></td>
            <td>&nbsp;</td>
        </tr>
        </thead>
        <tbody>
        @foreach($staff as $s)
            <tr>
                <td>{{$s->staff_name}}</td>
                <td>{{$s->email}}</td>
                <td>{{$s->staff_hp}}</td>
                <td>{{$s->staff_birth}}({{$s->staff_lunar=="Y"?"-":"+"}})</td>
                <td><input type="button" value="수정" class="btnSave" data-id="{{$s->user_id}}"/></td>
            </tr>
        @endforeach

        </tbody>
    </table>
@endsection
