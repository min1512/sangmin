@extends("admin.pc.layout.basic")

@section("title")직원관리@endsection

@section("scripts")
    <script>
        $(function () {
            $('#email').keyup(function () {
                $.ajax({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    type: 'POST',
                    url: '/user/staff/staff_email_check',
                    data: {
                        _token: '{{ csrf_token() }}',
                        email: $('#email').val()
                    },
                    success: function (data) {
                        if(data==1){
                            $('#check').text("사용가능한 아이디 입니다");
                        }else{
                            $('#check').text("사용불가능한 아이디 입니다");
                        }
                    },
                    error: function (data) {
                        console.log(data);
                        alert(data);
                    }
                });
            })
        });
        $(function () {
            $('#submit').click(function () {
                var check = $('#check').text();
                console.log(check);
                if(check=="사용불가능한 아이디 입니다"){
                    alert('사용불가능한 아이디 입니다');
                    return false;
                }else if(check=="중복 체크") {
                    alert('아이디 입력 하세요');
                    return false;
                }else if($('#email').val()==""){
                    alert('아이디 입력 하세요');
                    return false;
                }else{
                    return true;
                }
            })
        })
    </script>
@endsection

@section("styles")
@endsection

@section("contents")
    <form method="post" name="frmStaffSave" action="{{route('user.staff.save')}}">
        {{csrf_field()}}
        <input type="hidden" name="id" value="{{isset($staff->id)&&$staff->id!=""?$staff->id:""}}" />
        <div>이름: <input type="text" name="staff_name" value="{{isset($staff)?$staff->staff_name:""}}" /></div>
        <div>변경비밀번호: <input type="password" name="password" /></div>
        <div>변경비밀번호확인: <input type="password" name="password2" /></div>
        <div>이메일: <input type="text" id="email" name="email" value="{{isset($staff)?$staff->email:""}}" /><a style="color: red" id="check">중복 체크</a></div>
        <div>연락처: <input type="text" name="staff_hp" value="{{isset($staff)?$staff->staff_hp:""}}" /></div>
        <div>생년월일:
            <input type="text" name="staff_birth" value="{{isset($staff)?$staff->staff_birth:""}}" />
            <input type="radio" name="staff_lunar" value="N" {{isset($staff)&&$staff->staff_lunar=="N"?"checked":""}} />양력
            <input type="radio" name="staff_lunar" value="Y" {{!isset($staff)||$staff->staff_lunar=="Y"?"checked":""}} />음력
        </div>
        <input type="submit" id="submit" value="저장" />
    </form>
@endsection
