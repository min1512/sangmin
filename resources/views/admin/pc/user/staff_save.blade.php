@extends("admin.pc.layout.basic")

@section("title")직원관리@endsection

@section("scripts")
    <script>
        $(function(){
            $("#email_id").change(function(){ email_chk(); }).keyup(function(){ email_chk(); }).keypress(function(){ email_chk(); });
            $("#email_ad").change(function(){ email_chk(); }).keyup(function(){ email_chk(); }).keypress(function(){ email_chk(); });

            $("#email_sel").change(function(){
                if($(this).val()=="direct") $("#email_ad").prop("disabled",false).focus();
                else {
                    $("#email_ad").prop("disabled",true).val($(this).val());
                }
            });
        });
        function email_chk() {
            var email = $("#email_id").val()+"@"+$("#email_ad").val();
            $.post(
                "/user/staff/staff_email_check"
                ,{
                    _token: '{{csrf_token()}}'
                    , email: email
                }
                ,function(data){
                    if(data==true) {
                        $("span#email_check_message").addClass("type-good").text("사용가능한 아이디입니다.");
                        $("#email_chk").val("Y");
                    }
                    else if(email==$("#email_origin").val()) {
                        $("span#email_check_message").text("");
                        $("#email_chk").val("Y");
                    } else {
                        $("span#email_check_message").removeClass("type-good").text("이미 사용중인 아이디입니다.");
                        $("#email_chk").val("N");
                    }
                }
                ,"json"
            )
        }
        $(function () {
            $('#submit').click(function () {
                //이메일 수정시 변경여부 체크
                if($('#email').val()!="" && $('#email').val()==$('#email').data('email')){
                    $('#email_chk').val("Y");
                }

                var check = $('#email_chk').val();
                if($('#email').val()==""){
                    alert('아이디 입력 하세요');
                    return false;
                }
                else if(check=="N"){
                    alert('이미 사용중인 이메일 입니다');
                    return false;
                }
                else if($('#email').val()=="") {
                    alert('아이디 입력 하세요');
                    return false;
                }
                else {
                    return true;
                }
            })
        })
    </script>
@endsection

@section("styles")
<!--
<link rel="stylesheet" href="http://staff.einet.co.kr/asset/css/common-b.css">
<link rel="stylesheet" href="http://staff.einet.co.kr/asset/css/blade.css?v=<?=time() ?>">
<link rel="stylesheet" href="http://staff.einet.co.kr/asset/css/jjh-style.css">
-->
<link href="{{ asset('asset/css/jquery.datetimepicker.css') }}" rel="stylesheet">
@endsection

@section("contents")
<div class="guide-box" id="i_staff_save_blade">
    <div class="guide-wrap">
        <div>
            <div class="table-a noto">
                <form method="post" name="frmUserStaff" action="{{route('user.staff.save')}}">
                {{csrf_field()}}
                <input type="hidden" name="id" value="{{isset($staff->id)&&$staff->id!=""?$staff->id:""}}" />
                <div class="table-a__head clb">
                    <p class="table-a__tit fl">직원 등록 (수정)</p>
                </div>
                <table class="table-a__table type-top">
                    <colgroup>
                        <col width="13%">
                        <col width="*">
                        <col width="13%">
                        <col width="*">
                        <col width="13%">
                        <col width="*">
                    </colgroup>
                    <tr class="table-a__tr">
                        <td class="table-a__td type-nobd type-right type-top lh-28 type-grey">
                            이름
                        </td>
                        <td class="table-a__td type-nobd type-left">
                            <div class="input-wrap wid150">
                                <input type="text" class="input-v1" name="staff_name" value="{{isset($staff)?$staff->staff_name:""}}" />
                            </div>
                            {{--<span class="warn-txt">*중복입니다</span>--}}
                        </td>
                    </tr>
                    <tr class="table-a__tr">
                        <td class="table-a__td type-nobd type-right type-top lh-28 type-grey">
                            비밀번호
                        </td>
                        <td class="table-a__td type-nobd type-left">
                            <div class="input-wrap">
                                <input type="password" class="input-v1" name="password" />
                            </div>
                            {{--<span class="warn-txt">*중복입니다</span>--}}
                        </td>
                    </tr>
                    <tr class="table-a__tr">
                        <td class="table-a__td type-nobd type-right type-top lh-28 type-grey">
                            비밀번호확인
                        </td>
                        <td class="table-a__td type-nobd type-left">
                            <div class="input-wrap">
                                <input type="password" class="input-v1" name="password2" />
                            </div>
                            {{--<span class="warn-txt">*중복입니다</span>--}}
                        </td>
                    </tr>
                    <tr class="table-a__tr">
                        <td class="table-a__td type-nobd type-right type-top lh-28 type-grey">
                            이메일
                        </td>
                        <td class="table-a__td type-nobd type-left table-a__td__email">
                            @php if(isset($staff->email)) $email = explode("@",$staff->email); @endphp
                            <input type="hidden" name="email_chk" id="email_chk" value="{{isset($staff)&&$staff->email!=""?"Y":"N"}}" />
                            <input type="hidden" name="email_origin" id="email_origin" value="{{isset($staff)&&$staff->email!=""?$staff->email:""}}" />
                            <div class="input-wrap alpha wid100">
                                <input type="text" class="input-v1 ta-l" name="email_id" id="email_id" value="{{isset($email[0])?$email[0]:""}}" />
                            </div>
                            <div class="input-wrap wid110">
                                <input type="text" class="input-v1 ta-l" name="email_ad" id="email_ad" value="{{isset($email[1])?$email[1]:""}}" />
                            </div>
                            <div class="input-wrap">
                                <div class="select-wrap select-wrap__email left-mg wid130">
                                    <select name="email_sel" id="email_sel" class="select-v1 noto">
                                        <option value="">::이메일선택::</option>
                                        @php $email_list = \App\Http\Controllers\Controller::getCode("email_address"); @endphp
                                        @foreach($email_list as $el)
                                        <option value="{{$el->code}}">{{$el->code}}({{$el->name}})</option>
                                        @endforeach
                                        <option value="direct">직접입력</option>
                                    </select>
                                </div>
                            </div>
{{--
                            <div class="ta-l">
                                <button type="button" class="r-calendar-head__btn btn-v1 check">중복 체크</button>
                            </div>
--}}
                            <span class="warn-txt" id="email_check_message"></span>
                        </td>
                        <script>
                        </script>
                    </tr>
                    <tr class="table-a__tr">
                        <td class="table-a__td type-nobd type-right type-top lh-28 type-grey">
                            연락처
                        </td>
                        <td class="table-a__td table-a__td__phonenumber type-nobd type-left">
                            @php if(isset($staff)) $staff_hp = explode("-",$staff->staff_hp); @endphp
                            @php $hp_list = \App\Http\Controllers\Controller::getCode("phone_number"); @endphp
                            <div class="input-wrap">
                                <div class="select-wrap wid100">
                                    <select name="staff_hp[]" id="staff_hp_1" class="select-v1 noto">
                                        @foreach($hp_list as $hl)
                                        <option value="{{$hl->code}}" {{isset($staff_hp[0])&&$staff_hp[0]==$hl->code?"selected":""}}>{{$hl->code}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="input-wrap__phonenumber">
                                <div class="input-wrap">
                                    <input type="text" class="input-v1 wid60" name="staff_hp[]" id="staff_hp_2" value="{{isset($staff_hp[1])?$staff_hp[1]:""}}" />
                                </div>
                                <div class="input-wrap">
                                    <input type="text" class="input-v1 wid60" name="staff_hp[]" id="staff_hp_3" value="{{isset($staff_hp[2])?$staff_hp[2]:""}}" />
                                </div>
                            </div>
                            {{--<span class="warn-txt">*중복입니다</span>--}}
                        </td>
                    </tr>
                    <tr class="table-a__tr">
                        <td class="table-a__td type-nobd type-right type-top lh-28 type-grey">
                            생년월일
                        </td>
                        <td class="table-a__td type-nobd type-left">
                            <div class="input-wrap wid150 mar10">
                                <input type="text" class="input-v1" name="staff_birth" id="staff_birth" value="{{isset($staff)?$staff->staff_birth:""}}" />
                            </div>
                            <input type="radio" id="staff_lunar_N" class="radio-v1 " name="staff_lunar" value="N" {{isset($staff)&&$staff->staff_lunar=="N"?"checked":""}} />
                            <label for="staff_lunar_N" class="mar20">양력</label>
                            <input type="radio" id="staff_lunar_Y" class="radio-v1" name="staff_lunar" value="Y" {{!isset($staff)||$staff->staff_lunar=="Y"?"checked":""}} />
                            <label for="staff_lunar_Y">음력</label>
                            {{--<span class="warn-txt">*중복입니다</span>--}}
                        </td>
                    </tr>
                </table>
                <div class="btn-wrap">
				    <button type="submit" class="btn-v4 type-save">저장</button>
				</div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
