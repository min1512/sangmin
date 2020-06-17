@extends("admin.pc.layout.basic")

@section("title")대행사관리@endsection

@section("scripts")
    <script>
        $(function(){
            $("input.btnSave").click(function(){
                document.location.href='{{route('user.agency.save')}}/'+$(this).data("id");
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
            <td>대행사명</td>
            <td>사업자번호</td>
            <td>주소</td>
            <td>이메일</td>
            <td>연락처</td>
            <td><button class="btn_gray_00" onclick="goUrl('{{ route('user.agency.save',['id'=>0])}}');">신규 등록</button></td>
            <td>&nbsp;</td>
        </tr>
        </thead>
        <tbody>
        @foreach($agency as $a)
            <tr>
                <td>{{$a->agency_name}}</td>
                <td>{{$a->agency_number}}</td>
                <td>{{$a->agency_addr_basic." ".$a->agency_addr_detail}}</td>
                <td>{{$a->email}}</td>
                <td>{{$a->staff_hp}}</td>
                <td><input type="button" value="수정" class="btnSave" data-id="{{$a->user_id}}"/></td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
