@extends("admin.pc.layout.basic")

@section("title")대행사관리@endsection

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

                var check = $('#email_check').val();
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
<div class="guide-box" id="i_agency_save_blade">
    <div class="guide-wrap">
        <form method="post" name="frmAgencySave" action="{{route('user.agency.save')}}">
            <input type="hidden" name="id" value="{{isset($agency->id)&&$agency->id!=""?$agency->id:""}}" />
            <div class="table-a noto">
                <div class="table-a__head clb">
                    <p class="table-a__tit fl">대행사 등록 (수정)</p>
                </div>
                <table class="table-a__table type-top">
                    <colgroup>
                        <col width="">
                        <col width="">
                        <col width="">
                        <col width="">
                        <col width="">
                        <col width="">
                        <col width="">
                        <col width="">
                        <col width="">
                        <col width="">
                        <col width="">
                        <col width="">
                    </colgroup>
                    <tr class="table-a__tr">
                        <td class="table-a__td type-nobd type-right type-top lh-28 type-grey">
                            대행사명
                        </td>
                        <td colspan="3" class="table-a__td type-nobd type-left">
                            <div class="input-wrap wid150">
                                <input type="text" class="input-v1" name="agency_name" id="agency_name" value="{{isset($agency)?$agency->agency_name:""}}" />
                            </div>
                        </td>
                   
                        <td  class="table-a__td type-nobd type-right type-top lh-28 type-grey">
                            변경비밀번호
                        </td>
                        <td colspan="3" class="table-a__td type-nobd type-left">
                            <div class="input-wrap">
                                <input type="password" class="input-v1" name="passsword" id="password" />
                            </div>
                        </td>
                    
                        <td class="table-a__td type-nobd type-right type-top lh-28 type-grey">
                            변경비밀번호확인
                        </td>
                        <td colspan="3" class="table-a__td type-nobd type-left">
                            <div class="input-wrap">
                                <input type="password" class="input-v1" name="password2" id="password2" />
                            </div>
                        </td>
                    </tr>
                    <tr class="table-a__tr">
                        <td class="table-a__td type-nobd type-right type-top lh-28 type-grey">
                            이메일
                        </td>
                        <td colspan="11" class="table-a__td type-nobd type-left table-a__td__email">
                            @php if(isset($agency->email)) $email = explode("@",$agency->email); @endphp
                            <input type="hidden" name="email_chk" id="email_chk" value="{{isset($agency)&&$agency->email!=""?"Y":"N"}}" />
                            <input type="hidden" name="email_origin" id="email_origin" value="{{isset($agency)&&$agency->email!=""?$agency->email:""}}" />
                            <div class="input-wrap alpha wid100">
                                <input type="text" class="input-v1 ta-l" name="email_id" id="email_id" value="{{isset($email[0])?$email[0]:""}}" />
                            </div>
                            <div class="input-wrap wid110">
                                <input type="text" class="input-v1 ta-l type-mail" name="email_ad" id="email_ad" value="{{isset($email[1])?$email[1]:""}}" disabled />
                            </div>
                            <div class="input-wrap">
                                <div class="select-wrap select-wrap__email left-mg wid130">
                                    <select name="email_sel" id="email_sel" class="select-v1 noto">
                                        <option value="">::이메일선택::</option>
                                        @php $email_list = \App\Http\Controllers\Controller::getCode("email_address"); @endphp
                                        @foreach($email_list as $el)
                                            <option value="{{$el->code}}" {{isset($email[1])&&$email[1]==$el->code?"selected":""}}>{{$el->code}}({{$el->name}})</option>
                                        @endforeach
                                        <option value="direct">직접입력</option>
                                    </select>
                                </div>
                            </div>
{{--
                            <div class="ta-l"><button type="button" class="r-calendar-head__btn btn-v1 check">중복 체크</button>
                            </div>
--}}
                            <span class="warn-txt" id="email_check_message"></span>
                        </td>
                    </tr>
                    <tr class="table-a__tr">
                        <td class="table-a__td type-nobd type-right type-top lh-28 type-grey">
                            개인 / 법인
                        </td>
                        <td colspan="3" class="table-a__td type-nobd type-left">
                            <input type="radio" id="agency_type_I" class="radio-v1" name="agency_type" value="I" {{!isset($agency)||$agency->agency_type=="I"?"checked":""}} />
                            <label for="agency_type_I" class="mar20">간이</label>
                            <input type="radio" id="agency_type_C" class="radio-v1" name="agency_type" value="C" {{isset($agency)&&$agency->agency_type=="C"?"checked":""}} />
                            <label for="agency_type_C">일반</label>
                        </td>
                        <td class="table-a__td type-nobd type-right type-top lh-28 type-grey">
                            사업자번호
                        </td>
                        <td colspan="3" class="table-a__td type-nobd type-left">
<!--
                            <div class="input-wrap wid180">
                                <input type="text" class="input-v1" name="agency_number" id="agency_number" value="{{isset($agency)?$agency->agency_number:""}}" />
                            </div>
-->
                            
                            <div class="fl clb biz-num" style="width:200px;">
                                                <div class="input-wrap fl" style="width:30%">
                                                    <input type="text" class="input-v1 ta-r" placeholder="000">
                                                </div>
                                                <div class="input-wrap fl type-icon-before" style="width:30%;padding-left:15px;">
                                                    <input type="text" class="input-v1 ta-r" placeholder="00">
                                                </div>
                                                <div class="input-wrap fl type-icon-before" style="width:40%;padding-left:15px;">
                                                    <input type="text" class="input-v1 ta-r" placeholder="00000">
                                                </div>
                                            </div>
                        </td>
                        <td class="table-a__td type-nobd type-right type-top lh-28 type-grey">
                            법인번호
                        </td>
                        <td colspan="3" class="table-a__td type-nobd type-left">
                            <div class="input-wrap wid180">
                                <input type="text" class="input-v1" name="agency_number2" id="agency_number2" value="{{isset($agency)?$agency->agency_number2:""}}" />
                            </div>
                        </td>
                    </tr>
                    <tr class="table-a__tr">
                        <td class="table-a__td type-nobd type-right type-top lh-28 type-grey">
                            주소
                        </td>
                        <td colspan="11" class="table-a__td type-nobd type-left">
                            <input type="hidden" name="agency_post" id="agency_post" readonly />
                            <div class="input-wrap">
                                <input type="hidden" class="input-v1 wid110 mar10" value="우편번호 찾기" onclick="postSearch('agency')" readonly />
                                <button type="button" class="btn-v2" onclick="postSearch('agency')">우편번호찾기</button>
                            </div>
                            <div class="input-wrap">
                                <input type="text" class="input-v1 wid240" name="agency_addr_basic" id="agency_addr_basic" value="{{isset($agency)?$agency->agency_addr_basic:""}}" readonly />
                            </div>
                            <div class="input-wrap">
                                <input type="text" class="input-v1 wid340" name="agency_addr_detail" id="agency_addr_detail" value="{{isset($agency)?$agency->agency_addr_detail:""}}" placeholder="상세 주소를 입력하세요" />
                            </div>
                        </td>
                    </tr>
                    <tr class="table-a__tr">
                        <td class="table-a__td type-nobd type-right type-top lh-28 type-grey">
                            업종 / 종목
                        </td>
                        <td colspan="3" class="table-a__td type-nobd type-left">
                            <div class="input-wrap wid150">
                                <input type="text" class="input-v1" name="agency_item1" id="agency_item1" value="{{isset($agency)?$agency->agency_item1:""}}" placeholder="업종을 입력하세요" />
                            </div>
                            <div class="input-wrap wid150">
                                <input type="text" class="input-v1" name="agency_item2" id="agency_item2" value="{{isset($agency)?$agency->agency_item2:""}}" placeholder="종목을 입력하세요" />
                            </div>
                        </td>
                        <td class="table-a__td type-nobd type-right type-top lh-28 type-grey">
                            과세여부
                        </td>
                        <td colspan="7" class="table-a__td type-nobd type-left">
                            <input type="radio" id="agency_tax_Y" class="radio-v1" name="agency_tax" value="Y" {{!isset($agency)||$agency->agency_tax=="Y"?"checked":""}} />
                            <label for="agency_tax_Y" class="mar20">과세</label>
                            <input type="radio" id="agency_tax_C" class="radio-v1" name="agency_tax" value="C" {{isset($agency)&&$agency->agency_tax=="C"?"checked":""}} />
                            <label for="agency_tax_C">비과세</label>
                        </td>
                    </tr>
                    <tr class="table-a__tr">
                        <td class="table-a__td type-nobd type-right type-top lh-28 type-grey">
                            대표자
                        </td>
                        <td colspan="3" class="table-a__td type-nobd type-left">
                            <div class="input-wrap wid150">
                                <input type="text" class="input-v1" name="agency_owner" id="agency_owner" value="{{isset($agency)?$agency->agency_owner:""}}" placeholder="대표자 이름을 입력하세요" />
                            </div>
                        </td>
                   
                        <td class="table-a__td type-nobd type-right type-top lh-28 type-grey">
                            대표자 연락처
                        </td>
                        <td colspan="3" class="table-a__td table-a__td__phonenumber type-nobd type-left">
                           <div style="width: 280px;">
                            @php if(isset($agency->agency_tel)) $agency_tel = explode("-",$agency->agency_tel); @endphp
                            @php $region_list = \App\Http\Controllers\Controller::getCode("area_number"); @endphp
                            <div class="input-wrap fl" style="width:100px;vertical-align: middle;">
                                <div class="select-wrap">
                                    <select name="agency_tel[]" id="agency_tel_1" class="select-v1 noto">
                                        @foreach($region_list as $rl)
                                            <option value="{{$rl->code}}" {{isset($agency_tel[0])&&$agency_tel[0]==$rl->code?"selected":""}}>{{$rl->code}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
<!--
                            <div class="input-wrap__phonenumber">
                                <div class="input-wrap" style="width:90px">
                                    <input type="text" class="input-v1" name="agency_tel[]" id="agency_tel_2" value="{{isset($agency_tel[1])?$agency_tel[1]:""}}" />
                                </div>
                                <div class="input-wrap" style="width:90px">
                                    <input type="text" class="input-v1" name="agency_tel[]" id="agency_tel_3" value="{{isset($agency_tel[2])?$agency_tel[2]:""}}" />
                                </div>
                            </div>
-->
                            
                            <div class="input-wrap fl type-icon-before" style="width:90px;padding-left:15px;">
                                <input type="text" class="input-v1" name="agency_tel[]" id="agency_tel_2" value="{{isset($agency_tel[1])?$agency_tel[1]:""}}">
                            </div>
                            <div class="input-wrap fl type-icon-before" style="width:90px;padding-left:15px;">
                                <input type="text" class="input-v1" name="agency_tel[]" id="agency_tel_3" value="{{isset($agency_tel[2])?$agency_tel[2]:""}}" />
                            </div>
                            </div>
                        </td>
                        <td class="table-a__td type-nobd type-right type-top lh-28 type-grey">
                            대표자 휴대폰
                        </td>
                        <td colspan="3" class="table-a__td table-a__td__phonenumber type-nobd type-left">
                           <div style="width: 280px;">
                            @php if(isset($agency->agency_hp)) $agency_hp = explode("-",$agency->agency_hp); @endphp
                            @php $hp_list = \App\Http\Controllers\Controller::getCode("phone_number"); @endphp
                            <div class="input-wrap fl" style="width:100px;vertical-align: middle;">
                                <div class="select-wrap wid100">
                                    <select name="agency_hp[]" id="agency_hp_1" class="select-v1 noto">
                                        @foreach($hp_list as $hl)
                                            <option value="{{$hl->code}}" {{isset($agency_hp[0])&&$agency_hp[0]==$hl->code?"selected":""}}>{{$hl->code}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
<!--
                            <div class="input-wrap__phonenumber">
                                <div class="input-wrap" style="width:90px">
                                    <input type="text" class="input-v1" name="agency_hp[]" id="agency_hp_2" value="{{isset($agency_hp[1])?$agency_hp[1]:""}}" />
                                </div>
                                <div class="input-wrap" style="width:90px">
                                    <input type="text" class="input-v1" name="agency_hp[]" id="agency_hp_3" value="{{isset($agency_hp[2])?$agency_hp[2]:""}}" />
                                </div>
                            </div>
-->
                            
                            <div class="input-wrap fl type-icon-before" style="width:90px;padding-left:15px;">
                                <input type="text" class="input-v1" name="agency_hp[]" id="agency_hp_2" value="{{isset($agency_hp[1])?$agency_hp[1]:""}}" />
                            </div>
                            <div class="input-wrap fl type-icon-before" style="width:90px;padding-left:15px;">
                                <input type="text" class="input-v1 "  name="agency_hp[]" id="agency_hp_3" value="{{isset($agency_hp[2])?$agency_hp[2]:""}}" />
                            </div>
                        </div>
                        </td>
                    </tr>
                </table>
                <div class="btn-wrap">
				    <button type="submit" class="btn-v4 type-save">저장</button>
				</div>
            </div>
        </form>
    </div>
</div>
@endsection
