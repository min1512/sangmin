@extends("admin.pc.layout.basic")

@section("title")숙박업체 관리@endsection

@section("scripts")
    <script src="{{ asset('asset/js/jquery.datetimepicker.full.min.js') }}"></script>
    <script>
        function frmUserClient(fid) {
            if ($("#cnt_day").val()=="") {
                alert("노출기간을 입력해주세요");
                return false;
            }
            else if (
                parseInt($("#cnt_day").val())>=parseInt($("#cnt_day").data("min")) !== true ||
                parseInt($("#cnt_day").val())<=parseInt($("#cnt_day").data("max")) !== true
            ) {
                alert("노출 수정 가능 기간은 "+$("#cnt_day").data("min")+"일 부터 "+$("#cnt_day").data("max")+"일까지만 가능합니다.");
                return false;
            }
            else {
                $("form[name="+fid+"]").attr("action","{{ route('user.client.save',['id'=>$id]) }}").submit();
            }
        }

        $(function(){
            $("button.type-save").click(function(){
                frmUserClient('frmUserClient');
            });

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

        function file_change(obj){
            var file = $(obj).val();
            var str=file.lastIndexOf("\\")+1;	//파일 마지막 "\" 루트의 길이 이후부터 글자를 잘라 파일명만 가져온다.
            file = file.substring(str, file.length);
            $("#file_name_"+$(obj).data('id')).html(file);

            readURL(obj);
        }

        function newOpen(obj) {
            $(obj).parents("li").find("input[type=file]").click();
            // $('#preview3 img').attr("src",$(obj).attr("src"));
            // $('#preview3').show();
            // $('#close').click(function () {
            //     $('#preview3').hide();
            // })
        };

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#preview_'+$(input).data('id')).attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $('#file').change(function(){
            readURL(this);
        });

        var size = {{ sizeof($file)>0?sizeof($file):0 }};
        $(function(){
            $('#img_add').click(function () {
                $(".add-img__list").append(
                    '<li class="add-img__item fl">'+
                        '<div class="add-img__imgbox">'+
                            '<img onclick="newOpen(this)" id="preview_'+size+'" style="width:100px; height:100px;border:" class="thumbnail-img"/>'+
                        '</div>'+
                        '<input type="hidden" name="file_idx[]" value="" />'+
                        '<input type="file" name="file_name[]" class="img-input bld" data-id="'+size+'" onchange="file_change(this);"/>'+
                        '<p class="add-img__tit ellipsis" id="file_name_'+size+'" title="">&nbsp;</p>'+
                        '<p class="add-img__checkbox">'+
                            '<input type="checkbox" id="img_label_'+size+'" class="checkbox-v2 type-notxt" name="img_del['+size+']" onclick="img_del(this)" />'+
                            '<label for="img_label_'+size+'">삭제</label>'+
                        '</p>'+
                    '</li>'
                );
                size++;
            });

        });
        function img_del(obj) {
            $(obj).parents("li").hide();
        }

        $(document).on("click",".add-img__imgbox",function(){
            $(this).next().trigger("click");
        });

        /* -- 숙박업체 체크인/체크아웃 -- */
        $(document).ready(function() {
            //토글 열고 닫기
            $(".time-choice__open").click(function() {
                // console.log("sldfkjlskdfj");
                $(".time-choice__toggle").hide();
                var pa = $(this).closest(".time-choice");
                $(pa).find(".time-choice__toggle").slideToggle(200);
            });
            $(".time-choice__close").click(function() {
                $(this).closest(".time-choice__toggle").slideToggle(200);
            });
            //다른 부분 클릭시 닫기
            $(document).click(function(e) {
                if (!$(".time-choice__toggle").is(e.target) && !$(".time-choice__open").is(e.target) ) {
                    $(".time-choice__toggle").hide();
                }
            });
            $(".time-choice__toggle").click(function(e) {
                e.stopPropagation();
            });
            $(".time-choice__item").click(function(e) {
                e.stopPropagation();
                $(this).siblings().removeClass("is-active");
                $(this).addClass("is-active");
                var val = $(this).text();
                var parent = $(this).closest(".time-choice__wrap");
                console.log(parent);
                if ($(this).hasClass("type-apm")) {
                    $(parent).find("input.type-apm").val(val);
                } else if ($(this).hasClass("type-hour")) {
                    $(parent).find("input.type-hour").val(val);
                } else if ($(this).hasClass("type-min")) {
                    $(parent).find("input.type-min").val(val);
                }
            });
        }); //로딩구역
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
	<div class="guide-box" id="i_client_save_blade">
        <form method="post" name="frmUserClient" id="frmUserClient" enctype="multipart/form-data">
            {{csrf_field()}}
			<div class="guide-wrap" style="margin-bottom:300px;">
				<div>
					<div class="table-a noto">
						<div class="table-a__head clb">
							<p class="table-a__tit fl">숙박업소 관리</p>
						</div>
						<table class="table-a__table type-top">
						<colgroup>
						    <col width="8.333%">
						    <col width="8.333%">
						    <col width="8.333%">
						    <col width="8.333%">
						    <col width="8.333%">
						    <col width="8.333%">
						    <col width="8.333%">
						    <col width="8.333%">
						    <col width="8.333%">
						    <col width="8.333%">
						    <col width="8.333%">
						    <col width="8.333%">
						</colgroup>
							<tr class="table-a__tr">
								<td class="table-a__td type-nobd type-right type-top lh-28 type-grey " >
									숙박업체명
								</td>
								<td colspan="3" class="table-a__td type-nobd type-left">
									<div class="input-wrap" style="width:150px;">
										<input type="text" name="clientName" id="clientName" class="input-v1 ta-r" placeholder="숙박업체명을 입력해주세요" value="{{ isset($userInfo)&&$userInfo->client_name!=""?$userInfo->client_name:"" }}" />
									</div>
								</td>
								<td class="table-a__td type-nobd type-right type-top lh-28 type-grey" >
									업소명(영어)
								</td>
								<td colspan="3" class="table-a__td type-nobd type-left">
									<div class="input-wrap" style="width:150px;">
										<input type="text" name="clientNameEn" id="clientNameEn" class="input-v1 ta-r" placeholder="숙박업체 이름(염문)을 입력하세요" value="{{ isset($userInfo)&&$userInfo->client_name_en!=""?$userInfo->client_name_en:"" }}" />
									</div>
								</td>
								 <td class="table-a__td type-nobd type-right type-top lh-28 type-grey" >
									숙박업체구분
								</td>
								<td colspan="3" class="table-a__td type-nobd type-left">
									<div class="input-wrap">
                                        @php $client_gubun = \App\Http\Controllers\Controller::getCode('client_gubun'); @endphp
										<div class="select-wrap" style="width:193px;">
                                            <select name="client_gubun" id="client_gubun" class="select-v1 noto">
                                                @foreach($client_gubun as $k=>$c)
                                                    <option value="{{$c->code}}" {{isset($userInfo)&&$userInfo->client_gubun==$c->code?"selected":""}}>{{$c->name}}</option>
                                                @endforeach
                                            </select>
										</div>
									</div>
								</td>
							</tr>
							<tr class="table-a__tr">
								<td class="table-a__td type-nobd type-right type-top lh-28 type-grey" >
									API 토큰값
								</td>
								<td colspan="11" class="table-a__td type-nobd type-left">
									<div class="input-wrap" style="width:150px;">
										<span>{{isset($userInfo)&&$userInfo->api_token!=""?$userInfo->api_token:""}}</span>
									</div>
								</td>
							</tr>
							<tr class="table-a__tr">
								<td class="table-a__td type-nobd type-right type-top lh-28 type-grey" >
									Email
								</td>
								<td colspan="11" class="table-a__td type-nobd type-left">
                                    @php if(isset($user->email)) $email = explode("@",$user->email); @endphp
                                    <input type="hidden" name="email_chk" id="email_chk" value="{{isset($user)&&$user->email!=""?"Y":"N"}}" />
                                    <input type="hidden" name="email_origin" id="email_origin" value="{{isset($user)&&$user->email!=""?$user->email:""}}" />
									<div class="input-wrap fl" style="width:150px;">
                                        <input type="text" name="email_id" id="email_id" placeholder="이메일 주소를 입력하세요" class="input-v1 ta-r" value="{{isset($email[0])?$email[0]:""}}" />
									</div>
									<div class="mail-after fl">
                                        <div class="input-wrap fl ml-5" style="width:110px;">
                                            <input type="text" name="email_ad" id="email_ad" class="input-v1 ta-r js-mail-input type-mail" placeholder="직접입력" value="{{isset($email[1])?$email[1]:""}}" disabled />
                                        </div>
                                        <div class="select-wrap left-mg fl ml-5" style="width:130px;">
                                            <select name="email_sel" id="email_sel" class="select-v1 noto js-mail-select">
                                                <option value="">::이메일선택::</option>
                                                @php $email_list = \App\Http\Controllers\Controller::getCode("email_address"); @endphp
                                                @foreach($email_list as $el)
                                                    <option value="{{$el->code}}" {{isset($email[1])&&$email[1]==$el->code?"selected":""}}>{{$el->code}}({{$el->name}})</option>
                                                @endforeach
                                                <option value="direct">직접입력</option>
                                            </select>
                                        </div>
                                    </div>
                                    <span class="warn-txt" id="email_check_message"></span>
								</td>
							</tr>
                            <tr class="table-a__tr">
                                <td class="table-a__td type-nobd type-right type-top lh-28 type-grey" >
                                    대표자명
                                </td>
                                <td colspan="3" class="table-a__td type-nobd type-left">
                                    <div class="input-wrap" style="width:150px;">
                                        <input type="text" name="clientOwner" id="clientOwner" class="input-v1 ta-r" placeholder="대표자명을 입력해주세요" value="{{ isset($userInfo)&&$userInfo->client_owner!=""?$userInfo->client_owner:"" }}" />
                                    </div>
                                </td>
                                <td class="table-a__td type-nobd type-right type-top lh-28 type-grey" >
                                    비밀번호
                                </td>
                                <td colspan="3" class="table-a__td type-nobd type-left">
                                    <div class="input-wrap" style="width:150px;">
                                        <input type="password" name="password" class="input-v1 ta-r" />
                                    </div>
                                </td>
                                <td class="table-a__td type-nobd type-right type-top lh-28 type-grey" >
                                    비밀번호확인
                                </td>
                                <td colspan="3" class="table-a__td type-nobd type-left">
                                    <div class="input-wrap" style="width:150px;">
                                        <input type="password" name="password2" class="input-v1 ta-r" />
                                    </div>
                                </td>
                            </tr>
							<tr class="table-a__tr">
								<td class="table-a__td type-nobd type-right type-top lh-28 type-grey" >연락처</td>
								<td colspan="3" class="table-a__td type-nobd type-left">
									<div class="input-wrap" style="display:flex;";>
										<div class="select-wrap" style="width:113px;">
                                            @php
                                                if(isset($userInfo)&&$userInfo->client_tel!="") {
                                                    $telephone = explode("-",$userInfo->client_tel);
                                                }
                                            @endphp
                                            @php $codeTel = \App\Http\Controllers\Controller::getCode('area_number'); @endphp
											<select name="clientTel[]" id="clientTel1" class="select-v1 noto">
                                                @foreach($codeTel as $c)
                                                    <option value="{{$c->code}}" {{isset($telephone)&&$telephone[0]==$c->code?"selected":""}}>{{ $c->name }}</option>
                                                @endforeach
											</select>
										</div>
										<div class="input-wrap fl type-icon-before" style="width:90px;padding-left:15px;">
                                            <input type="text" class="input-v1 ta-r" name="clientTel[]" id="clientTel2" placeholder="전화번호를 입력하세요" value="{{isset($telephone[1])?$telephone[1]:""}}">
                                        </div>
                                        <div class="input-wrap fl type-icon-before" style="width:90px;padding-left:15px;">
                                            <input type="text" class="input-v1 ta-r" name="clientTel[]" id="clientTel3" placeholder="전화번호를 입력하세요" value="{{isset($telephone[2])?$telephone[2]:""}}"
                                            >
                                        </div>

<!--
										<span>&nbsp;-&nbsp;</span>
										<div class="input-wrap" style="width:90px;">
											<input type="text" name="clientTel[]" id="clientTel2" class="input-v1 ta-r" placeholder="전화번호를 입력하세요" value="{{isset($telephone[1])?$telephone[1]:""}}" />
										</div>
										<span>&nbsp;-&nbsp;</span>
										<div class="input-wrap" style="width:90px;">
											<input type="text" name="clientTel[]" id="clientTel3" class="input-v1 ta-r" placeholder="전화번호를 입력하세요" value="{{isset($telephone[2])?$telephone[2]:""}}" />
										</div>
-->
									</div>
								</td>
								<td class="table-a__td type-nobd type-right type-top lh-28 type-grey" >대표연락처(발신)</td>
								<td colspan="3" class="table-a__td type-nobd type-left">
                                    @php
                                        if(isset($userInfo)&&$userInfo->client_hp!="") {
                                            $cellphone = explode("-",$userInfo->client_hp);
                                        }
                                    @endphp
                                    @php $codeHp = \App\Http\Controllers\Controller::getCode('phone_number'); @endphp
									<div class="input-wrap" style="display:flex;";>
										<div class="select-wrap" style="width:83px;">
											<select name="clientHp[]" id="clientHp1" class="select-v1 noto">
                                                @foreach($codeHp as $c)
                                                    <option value="{{$c->code}}" {{isset($cellphone)&&$cellphone[0]==$c->code?"selected":""}}>{{ $c->name }}</option>
                                                @endforeach
											</select>
										</div>


										<div class="input-wrap fl type-icon-before" style="width:90px;padding-left:15px;">
                                            <input type="text"  name="clientHp[]" id="clientHp2" class="input-v1 ta-r" placeholder="번호를 입력하세요" value="{{isset($cellphone[1])?$cellphone[1]:""}}">
                                        </div>
                                        <div class="input-wrap fl type-icon-before" style="width:90px;padding-left:15px;">
                                            <input type="text"  name="clientHp[]" id="clientHp3" class="input-v1 ta-r" placeholder="번호를 입력하세요" value="{{isset($cellphone[2])?$cellphone[2]:""}}"/
                                            >
                                        </div>

                                        <!--여기부터는 번호 추가 시 사용함-->
{{--
										<span class="comma"></span>
										<div class="select-wrap" style="width:83px;">
											<select name="" id="" class="select-v1 noto">
												<option value="1">010</option>
												<option value="2">2</option>
												<option value="3">3</option>
												<option value="4">4</option>
												<option value="5">5</option>
											</select>
										</div>

										<div class="input-wrap fl type-icon-before" style="width:90px;padding-left:15px;">
                                            <input type="text" class="input-v1 ta-r" value="0000"/>
                                        </div>
                                        <div class="input-wrap fl type-icon-before" style="width:90px;padding-left:15px;">
                                            <input type="text" class="input-v1 ta-r" value="0000"/>
                                        </div>

<!--
										<span>&nbsp;-&nbsp;</span>
										<div class="input-wrap" style="width:60px;">
											<input type="text" class="input-v1 ta-r" value="0000"/>
										</div>
										<span>&nbsp;-&nbsp;</span>
										<div class="input-wrap" style="width:60px;">
											<input type="text" class="input-v1 ta-r" value="0000"/>
										</div>
-->
--}}
                                        <!-- 여기까지 -->
									</div>
								</td>
							</tr>
{{--
							<tr class="table-a__tr">
								<td class="table-a__td type-nobd type-right type-top lh-28 type-grey" >예약수신번호</td>
								<td colspan="" class="table-a__td type-nobd type-left">
                                    @php
                                        $cellphone_receive = [];
                                        if(isset($userInfo)&&$userInfo->clientHp_receive!="") {
                                            $cellphone_receive = explode("-",$userInfo->clientHp_receive);
                                        }
                                    @endphp
                                    @php $codeHp = \App\Http\Controllers\Controller::getCode('phone_number'); @endphp
                                    <div class="input-wrap reser_num" style="display:flex; float:left; ">
										<div class="select-wrap" style="width:83px;">
											<select name="clientHp_receive[]" id="clientHp1" class="select-v1 noto">
                                                @foreach($codeHp as $c)
                                                    <option value="{{$c->code}}" {{$cellphone_receive[0]==$c->code?"selected":""}}>{{ $c->name }}</option>
                                                @endforeach
											</select>
										</div>
										<span>&nbsp;-&nbsp;</span>
										<div class="input-wrap" style="width:60px;">
											<input type="text" name class="input-v1 ta-r" value="0000"/>
										</div>
										<span>&nbsp;-&nbsp;</span>
										<div class="input-wrap" style="width:60px;">
											<input type="text" class="input-v1 ta-r" value="0000"/>
										</div>
										<button type="button" class="btn-v2">수신번호 추가</button>
									</div>

									<div class="input-wrap reser_num" style="display:flex; float:left; margin-left:20px; ">
										<div class="select-wrap" style="width:83px;">
											<select name="" id="" class="select-v1 noto">
												<option value="1">010</option>
												<option value="2">2</option>
												<option value="3">3</option>
												<option value="4">4</option>
												<option value="5">5</option>
											</select>
										</div>
										<span>&nbsp;-&nbsp;</span>
										<div class="input-wrap" style="width:60px;">
											<input type="text" class="input-v1 ta-r" value="0000"/>
										</div>
										<span>&nbsp;-&nbsp;</span>
										<div class="input-wrap" style="width:60px;">
											<input type="text" class="input-v1 ta-r" value="0000"/>
										</div>
									</div>

                                    <div class="input-wrap" style="display:flex; float:left; margin-left:20px; ">
										<div class="select-wrap" style="width:83px;">
											<select name="" id="" class="select-v1 noto">
												<option value="1">010</option>
												<option value="2">2</option>
												<option value="3">3</option>
												<option value="4">4</option>
												<option value="5">5</option>
											</select>
										</div>
										<span>&nbsp;-&nbsp;</span>
										<div class="input-wrap" style="width:60px;">
											<input type="text" class="input-v1 ta-r" value="0000"/>
										</div>
										<span>&nbsp;-&nbsp;</span>
										<div class="input-wrap" style="width:60px;">
											<input type="text" class="input-v1 ta-r" value="0000"/>
										</div>
									</div>
								</td>

							</tr>
--}}
							<tr class="table-a__tr">
								<td class="table-a__td type-nobd type-right type-top lh-28 type-grey" >
									  주소
								</td>
								<td colspan="11" class="table-a__td type-nobd type-left" >
									<div class="input-wrap">
										<input type="hidden" name="clientPost" id="post" class="input-v1 ta-r address" value="{{ isset($userInfo)&&$userInfo->client_post!=""?$userInfo->client_post:"" }}"  readonly />
										<button type="button" class="btn-v2 type-alone" onclick="postSearch()" >우편번호 찾기</button>
									</div>
									<div class="input-wrap" style="width:402px;">
										<input type="text" name="clientAddrBasic" id="addr_basic" class="input-v1 ta-r address" value="{{ isset($userInfo)&&$userInfo->client_addr_basic!=""?$userInfo->client_addr_basic:"" }}" readonly />
									</div>
									<div class="input-wrap" style="width:402px;">
										<input type="text" name="clientAddrDetail" id="addr_detail" class="input-v1 ta-r" value="{{ isset($userInfo)&&$userInfo->client_addr_detail!=""?$userInfo->client_addr_detail:"" }}" />
									</div>
								</td>
							</tr>

							<tr class="table-a__tr">
								<td class="table-a__td type-nobd type-right type-top lh-28 type-grey" >결제 방법</td>
								<td colspan="3" class="table-a__td type-nobd type-left">
									<div class="table-a__inbox type-left" >
                                        @php
                                            $client_fee = isset($userInfo)?$userInfo->client_fee:"";
                                            $arr = explode(',',$client_fee);
                                        @endphp
										<input type="checkbox" id="type1" class="checkbox-v2 dp-ib" name="card" value="card" {{ in_array("card",$arr)?"checked":"" }} />
										<label for="type1" class="">카드결제</label>
										<input type="checkbox" id="type2" class="checkbox-v2 dp-ib" name="account" value="account" {{ in_array("account",$arr)?"checked":"" }} />
										<label for="type2" class="ml-20">무통장입금</label>
									</div>
								</td>
								 @php $fee_unit = \App\Http\Controllers\Controller::getCode('fee_order_unit'); @endphp
								<td class="table-a__td type-nobd type-right type-top lh-28 type-grey" >
									카드수수료
								</td>
								<td colspan="3" class="table-a__td type-nobd type-left">
									<div class="input-wrap" style="width:94px;">
										<input type="text" name="clientFeePayment" id="clientFeePayment" class="input-v1 ta-r" placeholder="FeePayment" value="{{ isset($userInfo)&&$userInfo->client_fee_payment!=""?$userInfo->client_fee_payment:"" }}" />
									</div>
                                    <div class="input-wrap" style="display:inline-block;vertical-align:middle;">
										<div class="select-wrap" style="min-width:80px;">
                                            <select class="select-v1" name="clientFeePaymentUnit" id="clientFeePaymentUnit">
                                                @foreach($fee_unit as $f)
                                                    <option value="{{$f->code}}" {{isset($userInfo)&&$userInfo->client_fee_payment_unit==$f->code?"selected":""}}>{{ $f->name }}</option>
                                                @endforeach
                                            </select>
										</div>
									</div>
								</td>
								<td class="table-a__td type-nobd type-right type-top lh-28 type-grey" >
									예약대행 수수료
								</td>
								<td colspan="3" class="table-a__td type-nobd type-left">
									<div class="input-wrap" style="width:94px;">
										<input type="text" name="clientFeeAgency" id="clientFeeAgency" class="input-v1 ta-r" placeholder="FeeAgency" value="{{ isset($userInfo)&&$userInfo->client_fee_agency!=""?$userInfo->client_fee_agency:"" }}" />
									</div>
                                    <div class="input-wrap" style="display:inline-block;vertical-align:middle;">
										<div class="select-wrap" style="min-width:80px;">
                                            <select class="select-v1" name="clientFeeAgencyUnit" id="clientFeeAgencyUnit">
                                                @foreach($fee_unit as $f)
                                                    <option value="{{$f->code}}" {{isset($userInfo)&&$userInfo->client_fee_agency_unit==$f->code?"selected":""}}>{{ $f->name }}</option>
                                                @endforeach
                                            </select>
										</div>
									</div>
								</td>
							</tr>
							<tr class="table-a__tr">
								<td class="table-a__td type-nobd type-right type-top lh-28 type-grey" >
									정산정보
								</td>
								<td colspan="11" class="table-a__td type-nobd type-left">
                                    ...........................
								</td>
							</tr>

							<tr class="table-a__tr">
								<td class="table-a__td type-nobd type-right type-top lh-28 type-grey" >업소형태</td>
								<td colspan="11" class="table-a__td type-nobd type-left">
									<div class="table-a__inbox type-left" >
                                        @php $clientType = \App\Http\Controllers\Controller::getCode('client_type'); @endphp
                                        @foreach($clientType as $k => $c)
                                            <input type="radio" name="codeType" id="clientType{{$k}}" class="radio-v1 dp-ib" value="{{$c->code}}" {{ isset($userInfo)&&$userInfo->code_type==$c->code?"checked":"" }} />
                                            <label for="clientType{{$k}}" class="ml-20">{{$c->name}}</label>
                                        @endforeach
									</div>
								</td>
							</tr>

							<tr class="table-a__tr">
								<td class="table-a__td type-nobd type-right type-top lh-28 type-grey" >
									도메인
								</td>
								<td colspan="11" class="table-a__td type-nobd type-left">
<!--									<div class="input-wrap" style="width:260px;">-->
										<input type="text" name="clientSiteUrl" id="clientSiteUrl" class="input-v1 ta-r" placeholder="도메인 주소를 입력하세요" value="{{ isset($userInfo)&&$userInfo->client_site_url!=""?$userInfo->client_site_url:"" }}" />
<!--									</div>-->
								</td>
							</tr>

							<tr class="table-a__tr">
								<td class="table-a__td type-nobd type-right type-top lh-28 type-grey" >펜션사진</td>
								<td colspan="11" class="table-a__td type-nobd type-left">
									<p class="mb-5">
										<button type="button" class="btn-v1 js-trigger-img" id="img_add">사진 추가</button>
									</p>
									<div class="add-img">
										<ul class="add-img__list clb">
                                            @foreach($file as $k => $v)
                                                <li class="add-img__item fl">
                                                    <div class="add-img__imgbox">
                                                        <img onclick="newOpen(this)" id="preview_{{$k}}" src="/data/{{isset($file)&&$v->path?$v->path:""}}" style="width:100px; height:100px;" class="thumbnail-img"/>
                                                    </div>
                                                    <input type="hidden" name="file_idx[{{$k}}]" value="{{$v->id}}" />
                                                    <input type="file" name="file_name[{{$k}}]" class="img-input bld" data-id="{{$k}}" onchange="file_change(this);" />
                                                    <p class="add-img__tit ellipsis" id="file_name_{{$k}}" title="{{isset($file)&&$v->file_name? $v->file_name :""}}">{{isset($file)&&$v->file_name? $v->file_name :""}}</p>
                                                    <p class="add-img__checkbox">
                                                        <input type="checkbox" id="img_label_{{$k}}" class="checkbox-v2 type-notxt" name="img_del[{{$k}}]" value="{{$v->id}}" onclick="img_del(this)" />
                                                        <label for="img_label_{{$k}}">삭제</label>
                                                    </p>
                                                </li>
                                            @endforeach
										</ul>
										<span class="add-img__sub">데이터용량 0KB / 10MB</span>
									</div>
{{--									<p class="mt-5"><button type="button" class="btn-v2 type-icon type-icon type-del">삭제</button></p>--}}
								</td>
							</tr>
<!--
                            <script>
                                function allCheck(val) {
                                    if($("#"+val+"_all").prop("checked")) {
                                        $("input[name='"+val+"[]']").each(function(){
                                            $(this).prop("checked",true);
                                        });
                                    }
                                    else {
                                        $("input[name='"+val+"[]']").each(function(){
                                            $(this).prop("checked",false);
                                        });
                                    }
                                }
                            </script>
-->
                            <tr class="table-a__tr">
                                <td class="table-a__td type-nobd type-right type-top lh-28 type-grey" >부대시설<br/>(숙소 편의 시설/서비스)</td>
                                <td colspan="11" class="table-a__td type-nobd type-left type-lh-normal">
                                    <p>
                                        <input type="checkbox" id="facility_all" class="checkbox-v2" onclick="allCheck('facility')">
                                        <label for="facility_all">모두선택</label>
                                    </p>
                                    <div class="facility-group clb">
                                        <ul class="facility-group__list fl clb">
                                            @php $facility = explode(",", $db_client_facility->facility); @endphp
                                            @foreach($client_facility as $k => $ucf)
                                                <li class="facility-group__item fl">
                                                    <input type="checkbox" id="facility_{{$k}}" class="checkbox-v2" name="facility[]" value="{{$ucf->code}}" {{ in_array($ucf->code,$facility)?"checked":"" }} />
                                                    <label for="facility_{{$k}}">{{$ucf->name}}</label>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </td>
                            </tr>

                            <tr class="table-a__tr">
                                <td class="table-a__td type-nobd type-right type-top lh-28 type-grey" >구비시설<br/>(객실 편의 시설/서비스)</td>
                                <td colspan="11" class="table-a__td type-nobd type-left type-lh-normal">
                                    <p>
                                        <input type="checkbox" id="facility_all" class="checkbox-v2" onclick="allCheck('amanity')">
                                        <label for="facility_all">모두선택</label>
                                    </p>
                                    <div class="facility-group clb">
                                        <ul class="facility-group__list fl clb">
                                            @php $amanity = explode(",", $db_client_amanity->amanity); @endphp
                                            @foreach($client_amanity as $k => $uca)
                                                <li class="facility-group__item fl">
                                                    <input type="checkbox" id="facility_{{$k}}" class="checkbox-v2" name="amanity[]" value="{{$uca->code}}" {{ in_array($ucf->code,$amanity)?"checked":"" }} />
                                                    <label for="facility_{{$k}}">{{$uca->name}}</label>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </td>
                            </tr>

                            <tr class="table-a__tr">
								<td class="table-a__td type-nobd type-right type-top lh-28 type-grey" >서비스<br/>(이용가능 서비스/옵션)</td>
								<td colspan="11" class="table-a__td type-nobd type-left type-lh-normal">
									<p>
                                        <input type="checkbox" id="service_all" class="checkbox-v2" onclick="allCheck('service')">
                                        <label for="service_all">모두선택</label>
									</p>
									<div class="facility-group clb">
										<ul class="facility-group__list fl clb">
                                            @php $service = explode(",", $db_client_service->service); @endphp
                                            @foreach($client_service as $k =>$ucs)
                                            <li class="facility-group__item fl">
                                                <input type="checkbox" id="service_{{$k}}" class="checkbox-v2" name="service[]" value="{{$ucs->code}}" {{ in_array($ucs->code,$service)?"checked":"" }} />
                                                <label for="service_{{$k}}">{{$ucs->name}}</label>
                                            </li>
                                            @endforeach
										</ul>
									</div>
								</td>
							</tr>

{{--
							<tr class="table-a__tr">
								<td class="table-a__td type-nobd type-right type-top lh-28 type-grey" >주변관광지</td>
								<td colspan="11" class="table-a__td type-nobd type-left type-lh-normal">
									<p>
										<input type="checkbox" id="tour_all" class="checkbox-v2" onclick="allCheck('tour')">
										<label for="tour_all">모두선택</label>
									</p>
									<div class="facility-group clb">
										<ul class="facility-group__list fl clb">
                                            @foreach($user_client_torisit as $k => $uct)
                                                <li class="facility-group__item fl">
                                                    <input type="checkbox" id="tour_{{$k}}" class="checkbox-v2" name="tour[]" value="{{$uct->code}}" {{$uct->cnt_torisit>0?"checked":""}} />
                                                    <label for="tour_{{$k}}">{{$uct->code_name}}</label>
                                                </li>
                                            @endforeach
										</ul>
									</div>
								</td>
							</tr>
--}}

							<tr class="table-a__tr">
								<td class="table-a__td type-nobd type-right type-top lh-28 type-grey" >
									검색 키워드
								</td>
								<td colspan="11" class="table-a__td type-nobd type-left">
<!--									<div class="input-wrap" style="width:260px;">-->
										<input type="text" name="keyword" class="input-v1 ta-r" value="11" value="{{ isset($userInfo)&&$userInfo->keyword!=""?$userInfo->keyword:"" }}" />
<!--									</div>-->
								</td>
							</tr>

							<tr class="table-a__tr">
								<td class="table-a__td type-nobd type-right type-top lh-28 type-grey" >
									숙박업체 체크인
								</td>
								<td colspan="11" class="table-a__td type-nobd type-left">
									<div class="time-choice__double clb">
                                        <div class="time-choice fl">
                                            <div class="time-choice__wrap fl clb">
                                                @php
                                                    $check_in_s = isset($userInfo)&&$userInfo->client_check_in_start!=""?date("A",strtotime($userInfo->client_check_in_start)):date("A");
                                                    $check_in_s_h = isset($userInfo)&&$userInfo->client_check_in_start!=""?date("h",strtotime($userInfo->client_check_in_start)):date("h");
                                                    $check_in_s_i = isset($userInfo)&&$userInfo->client_check_in_start!=""?date("i",strtotime($userInfo->client_check_in_start)):date("i");
                                                    $check_in_s_i = ceil($check_in_s_i/10)*10;
                                                @endphp
                                                <div class="time-input type-apm fl">
                                                    <input type="text" name="client_check_in_start[]" class="time-input__input type-apm" value="{{$check_in_s=="AM"?"오전":"오후"}}" readonly>
                                                </div>
                                                <div class="time-choice__inner type-time fl clb">
                                                    <div class="time-input type-time fl">
                                                        <input type="text" name="client_check_in_start[]" class="time-input__input type-hour" value="{{$check_in_s_h}}" readonly>
                                                    </div>
                                                    <div class="time-input type-time fl">
                                                        <input type="text" name="client_check_in_start[]" class="time-input__input type-min" value="{{$check_in_s_i}}" readonly>
                                                    </div>
                                                </div>
                                                <!-- 토글박스 -->
                                                <div class="time-choice__toggle">
                                                    <div class="time-choice__inbox type-toggle clb">
                                                        <div class="time-choice__inner type-toggle type-apm fl">
                                                            <ul class="time-choice__list type-apm">
                                                                <li class="time-choice__item type-apm {{$check_in_s=="AM"?"is-active":""}}">오전</li>
                                                                <li class="time-choice__item type-apm {{$check_in_s=="AM"?"":"is-active"}}">오후</li>
                                                            </ul>
                                                        </div>
                                                        <div class="time-choice__inner type-toggle type-hour fl">
                                                            <ul class="time-choice__list type-hour">
                                                                @for($i=1; $i<=12; $i++)
                                                                    <li class="time-choice__item type-hour {{sprintf("%02d",$i)==$check_in_s_h?"is-active":""}}">{{sprintf("%02d",$i)}}</li>
                                                                @endfor
                                                            </ul>
                                                        </div>
                                                        <div class="time-choice__inner type-toggle type-min fl">
                                                            <ul class="time-choice__list type-min">
                                                                @for($i=0; $i<6; $i++)
                                                                    <li class="time-choice__item type-min {{sprintf("%02d",$i*10)==$check_in_s_i?"is-active":""}}">{{sprintf("%02d",$i*10)}}</li>
                                                                @endfor
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <button type="button" class="time-choice__close"></button>
                                                </div>
                                            </div>
                                            <p class="time-choice__btn"></p>
                                            <div class="time-choice__open"></div>
                                        </div>
                                        <div class="time-choice fr">
                                            <div class="time-choice__wrap fl clb">
                                                @php
                                                    $check_in_e = isset($userInfo)&&$userInfo->client_check_in_end!=""?date("A",strtotime($userInfo->client_check_in_end)):date("A");
                                                    $check_in_e_h = isset($userInfo)&&$userInfo->client_check_in_end!=""?date("h",strtotime($userInfo->client_check_in_end)):date("h");
                                                    $check_in_e_i = isset($userInfo)&&$userInfo->client_check_in_end!=""?date("i",strtotime($userInfo->client_check_in_end)):date("i");
                                                    $check_in_e_i = ceil($check_in_e_i/10)*10;
                                                @endphp
                                                <div class="time-input type-apm fl">
                                                    <input type="text" name="client_check_in_end[]" class="time-input__input type-apm" value="{{$check_in_e=="AM"?"오전":"오후"}}" readonly>
                                                </div>
                                                <div class="time-choice__inner type-time fl clb">
                                                    <div class="time-input type-time fl">
                                                        <input type="text" name="client_check_in_end[]" class="time-input__input type-hour" value="{{$check_in_e_h}}" readonly>
                                                    </div>
                                                    <div class="time-input type-time fl">
                                                        <input type="text" name="client_check_in_end[]" class="time-input__input type-min" value="{{$check_in_e_i}}" readonly>
                                                    </div>
                                                </div>
                                                <!-- 토글박스 -->
                                                <div class="time-choice__toggle">
                                                    <div class="time-choice__inbox type-toggle clb">
                                                        <div class="time-choice__inner type-toggle type-apm fl">
                                                            <ul class="time-choice__list type-apm">
                                                                <li class="time-choice__item type-apm {{$check_in_e=="AM"?"is-active":""}}">오전</li>
                                                                <li class="time-choice__item type-apm {{$check_in_e=="AM"?"":"is-active"}}">오후</li>
                                                            </ul>
                                                        </div>
                                                        <div class="time-choice__inner type-toggle type-hour fl">
                                                            <ul class="time-choice__list type-hour">
                                                                @for($i=1; $i<=12; $i++)
                                                                <li class="time-choice__item type-hour {{sprintf("%02d",$i)==$check_in_e_h?"is-active":""}}">{{sprintf("%02d",$i)}}</li>
                                                                @endfor
                                                            </ul>
                                                        </div>
                                                        <div class="time-choice__inner type-toggle type-min fl">
                                                            <ul class="time-choice__list type-min">
                                                                @for($i=0; $i<6; $i++)
                                                                    <li class="time-choice__item type-min {{sprintf("%02d",$i*10)==$check_in_e_i?"is-active":""}}">{{sprintf("%02d",$i*10)}}</li>
                                                                @endfor
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <button type="button" class="time-choice__close"></button>
                                                </div>
                                            </div>
                                            <p class="time-choice__btn"></p>
                                            <div class="time-choice__open"></div>
                                        </div>
                                    </div>
								</td>
								</tr>
								<tr class="table-a__tr">
								<td class="table-a__td type-nobd type-right type-top lh-28 type-grey" >
									숙박업체 체크아웃
								</td>
								<td colspan="11" class="table-a__td type-nobd type-left">
									<div class="time-choice__double clb">
                                        <div class="time-choice fl">
                                            <div class="time-choice__wrap fl clb">
                                                @php
                                                    $check_out_s = isset($userInfo)&&$userInfo->client_check_out_start!=""?date("A",strtotime($userInfo->client_check_out_start)):date("A");
                                                    $check_out_s_h = isset($userInfo)&&$userInfo->client_check_out_start!=""?date("h",strtotime($userInfo->client_check_out_start)):date("h");
                                                    $check_out_s_i = isset($userInfo)&&$userInfo->client_check_out_start!=""?date("i",strtotime($userInfo->client_check_out_start)):date("i");
                                                    $check_out_s_i = ceil($check_out_s_i/10)*10;
                                                @endphp
                                                <div class="time-input type-apm fl">
                                                    <input type="text" name="client_check_out_start[]" class="time-input__input type-apm" value="{{$check_out_s=="AM"?"오전":"오후"}}" readonly>
                                                </div>
                                                <div class="time-choice__inner type-time fl clb">
                                                    <div class="time-input type-time fl">
                                                        <input type="text" name="client_check_out_start[]" class="time-input__input type-hour" value="{{$check_out_s_h}}" readonly>
                                                    </div>
                                                    <div class="time-input type-time fl">
                                                        <input type="text" name="client_check_out_start[]" class="time-input__input type-min" value="{{$check_out_s_i}}" readonly>
                                                    </div>
                                                </div>
                                                <!-- 토글박스 -->
                                                <div class="time-choice__toggle">
                                                    <div class="time-choice__inbox type-toggle clb">
                                                        <div class="time-choice__inner type-toggle type-apm fl">
                                                            <ul class="time-choice__list type-apm">
                                                                <li class="time-choice__item type-apm {{$check_out_s=="AM"?"is-active":""}}">오전</li>
                                                                <li class="time-choice__item type-apm {{$check_out_s=="AM"?"":"is-active"}} is-active">오후</li>
                                                            </ul>
                                                        </div>
                                                        <div class="time-choice__inner type-toggle type-hour fl">
                                                            <ul class="time-choice__list type-hour">
                                                                @for($i=1; $i<=12; $i++)
                                                                    <li class="time-choice__item type-hour {{sprintf("%02d",$i)==$check_out_s_h?"is-active":""}}">{{sprintf("%02d",$i)}}</li>
                                                                @endfor
                                                            </ul>
                                                        </div>
                                                        <div class="time-choice__inner type-toggle type-min fl">
                                                            <ul class="time-choice__list type-min">
                                                                @for($i=0; $i<6; $i++)
                                                                    <li class="time-choice__item type-min {{sprintf("%02d",$i*10)==$check_out_s_i?"is-active":""}}">{{sprintf("%02d",$i*10)}}</li>
                                                                @endfor
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <button type="button" class="time-choice__close"></button>
                                                </div>
                                            </div>
                                            <p class="time-choice__btn"></p>
                                            <div class="time-choice__open"></div>
                                        </div>
                                        <div class="time-choice fr">
                                            <div class="time-choice__wrap fl clb">
                                                @php
                                                    $check_out_e = isset($userInfo)&&$userInfo->client_check_out_end!=""?date("A",strtotime($userInfo->client_check_out_end)):date("A");
                                                    $check_out_e_h = isset($userInfo)&&$userInfo->client_check_out_end!=""?date("h",strtotime($userInfo->client_check_out_end)):date("h");
                                                    $check_out_e_i = isset($userInfo)&&$userInfo->client_check_out_end!=""?date("i",strtotime($userInfo->client_check_out_end)):date("i");
                                                    $check_out_e_i = ceil($check_out_e_i/10)*10;
                                                @endphp
                                                <div class="time-input type-apm fl">
                                                    <input type="text" name="client_check_out_end[]" class="time-input__input type-apm" value="{{$check_out_e=="AM"?"오전":"오후"}}" readonly>
                                                </div>
                                                <div class="time-choice__inner type-time fl clb">
                                                    <div class="time-input type-time fl">
                                                        <input type="text" name="client_check_out_end[]" class="time-input__input type-hour" value="{{$check_out_e_h}}" readonly>
                                                    </div>
                                                    <div class="time-input type-time fl">
                                                        <input type="text" name="client_check_out_end[]" class="time-input__input type-min" value="{{$check_out_e_i}}" readonly>
                                                    </div>
                                                </div>
                                                <!-- 토글박스 -->
                                                <div class="time-choice__toggle">
                                                    <div class="time-choice__inbox type-toggle clb">
                                                        <div class="time-choice__inner type-toggle type-apm fl">
                                                            <ul class="time-choice__list type-apm">
                                                                <li class="time-choice__item type-apm {{$check_out_e=="AM"?"is-active":""}}">오전</li>
                                                                <li class="time-choice__item type-apm {{$check_out_e=="AM"?"":"is-active"}} is-active">오후</li>
                                                            </ul>
                                                        </div>
                                                        <div class="time-choice__inner type-toggle type-hour fl">
                                                            <ul class="time-choice__list type-hour">
                                                                @for($i=1; $i<=12; $i++)
                                                                    <li class="time-choice__item type-hour {{sprintf("%02d",$i)==$check_out_e_h?"is-active":""}}">{{sprintf("%02d",$i)}}</li>
                                                                @endfor
                                                            </ul>
                                                        </div>
                                                        <div class="time-choice__inner type-toggle type-min fl">
                                                            <ul class="time-choice__list type-min">
                                                                @for($i=0; $i<6; $i++)
                                                                    <li class="time-choice__item type-min {{sprintf("%02d",$i*10)==$check_out_e_i?"is-active":""}}">{{sprintf("%02d",$i*10)}}</li>
                                                                @endfor
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <button type="button" class="time-choice__close"></button>
                                                </div>
                                            </div>
                                            <p class="time-choice__btn"></p>
                                             <div class="time-choice__open"></div>
                                        </div>
                                    </div>
								</td>
							</tr>


							<tr class="table-a__tr">
								<td class="table-a__td type-nobd type-right type-top lh-28 type-grey" >
									가격노출기간
								</td>
								<td colspan="3" class="table-a__td type-nobd type-left">
									<div class="input-wrap" style="width:100px;">
										<input type="text" name="cnt_day" id="cnt_day" class="input-v1 ta-r" value="{{ isset($userInfo)?$userInfo->cnt_day:60 }}" data-min="{{ isset($userInfo)?(($userInfo->cnt_day-30)<1?1:$userInfo->cnt_day-30):30 }}" data-max="{{ isset($userInfo)?$userInfo->cnt_day+30:90 }}" />
									</div>
								</td>

								<td class="table-a__td type-nobd type-right type-top lh-28 type-grey" >
									스킨(미작업)
								</td>
								<td colspan="3" class="table-a__td type-nobd type-left">
									<div class="input-wrap">
										<div class="select-wrap" style="width:193px;">
                                            @php $skin = \App\Http\Controllers\Controller::getCode("skin_reserve"); @endphp
											<select name="codeDesign" id="codeDesign" class="select-v1 noto">
                                                @foreach($skin as $s)
												<option value="{{$s->code}}">{{$s->name}}</option>
                                                @endforeach
											</select>
										</div>
									</div>
								</td>

								<td class="table-a__td type-nobd type-right type-top lh-28 type-grey" >
								    <span>대행사</span>
								</td>
								<td colspan="3" class="table-a__td type-nobd type-left">
									<div class="input-wrap">
										<div class="select-wrap" style="width:193px;">
											<select name="agency" id="agencySelect" class="select-v1 noto">
                                                <option value="">대행사없음</option>
                                                @foreach($agency as $k => $a)
												<option value="{{$a->user_id}}">{{$a->agency_name}}</option>
                                                @endforeach
											</select>
										</div>
									</div>
								</td>
							</tr>

                            <tr class="table-a__tr">
<!--
                                <td class="table-a__td type-nobd pd-0" colspan="12" >
                                    <div class="table-a noto">
                                        <table class="table-a__table">
                                           <colgroup>
                                               <col width="148px">
                                               <col>
                                               <col width="8%">
                                               <col>
                                               <col width="8%">
                                               <col>
                                               <col width="8%">
                                               <col>
                                           </colgroup>
                                            <tr>
                                                <td class="table-a__td type-nobd type-grey type-right nobd-b">영유아</td>
                                                <td class="table-a__td type-nobd nobd-b ta-l">
                                                     <input  type="checkbox" id="double_young" class="checkbox-v1 type-center" name="double_young" value="Y" />
                                                     <label for="double_young">가능</label>
                                                    <div class="input-wrap" style="width:150px;">
                                                        <input type="text" name="double_young_text" class="input-v1" />
                                                    </div>
                                                </td>
                                                <td class="table-a__td type-nobd type-grey type-right nobd-b">유아</td>
                                                <td class="table-a__td type-nobd nobd-b ta-l">
                                                    <input  type="checkbox" id="young" class="checkbox-v1 type-center" name="young" value="Y" />
                                                     <label for="young">가능</label>
                                                    <div class="input-wrap" style="width:150px;">
                                                        <input type="text" name="young_text" class="input-v1" />
                                                    </div>
                                                </td>
                                                <td class="table-a__td type-nobd type-grey type-right nobd-b">아동</td>
                                                <td class="table-a__td type-nobd nobd-b ta-l">
                                                    <input  type="checkbox" class="checkbox-v1 type-center" name="child" value="Y" id="child"/ >
                                                     <label for="child">가능</label>
                                                    <div class="input-wrap" style="width:150px;">
                                                        <input type="text" name="child_text" class="input-v1" />
                                                    </div>
                                                </td>
                                                <td class="table-a__td type-nobd type-grey type-right nobd-b">성인</td>
                                                <td class="table-a__td type-nobd nobd-b ta-l">
                                                    <input  type="checkbox" class="checkbox-v1 type-center" name="adult" value="Y" id="adult" />
                                                    <label for="adult">가능</label>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </td>
-->
                                <td class="table-a__td type-nobd type-right type-top lh-28 type-grey" >
                                    영유아
                                </td>
                                <td colspan="2" class="table-a__td type-nobd type-left">
                                    <input  type="checkbox" id="double_young" class="checkbox-v1 type-center" name="double_young" value="Y" />
                                    <label for="double_young">가능</label>
                                    <div class="input-wrap" style="width:80px;">
                                        <input type="text" name="double_young_text" class="input-v1" />
                                    </div>
                                </td>
                                <td class="table-a__td type-nobd type-right type-top lh-28 type-grey" >
                                    유아
                                </td>
                                <td colspan="2" class="table-a__td type-nobd type-left">
                                    <input  type="checkbox" id="young" class="checkbox-v1 type-center" name="young" value="Y" />
                                    <label for="young">가능</label>
                                    <div class="input-wrap" style="width:80px;">
                                        <input type="text" name="young_text" class="input-v1" />
                                    </div>
                                </td>
                                <td class="table-a__td type-nobd type-right type-top lh-28 type-grey" >
                                    아동
                                </td>
                                <td colspan="2" class="table-a__td type-nobd type-left">
                                    <input  type="checkbox" class="checkbox-v1 type-center" name="child" value="Y" id="child"/ >
                                    <label for="child">가능</label>
                                    <div class="input-wrap" style="width:80px;">
                                        <input type="text" name="child_text" class="input-v1" />
                                    </div>
                                </td>
                                <td class="table-a__td type-nobd type-right type-top lh-28 type-grey" >
                                    성인
                                </td>
                                <td colspan="2" class="table-a__td type-nobd type-left">
                                     <input  type="checkbox" class="checkbox-v1 type-center" name="adult" value="Y" id="adult" />
                                     <label for="adult">가능</label>
                                </td>

                            </tr>
						</table>
					</div>
					<div class="btn-wrap type-fg">
						<button type="button" class="btn-v4 type-save">저장</button>
					</div>
				</div>
			</div>
        </form>
	</div>

<script>
    function allCheck(val) {
        if($("#"+val+"_all").prop("checked")) {
            $("input[name='"+val+"[]']").each(function(){
                $(this).prop("checked",true);
            });
        }
        else {
            $("input[name='"+val+"[]']").each(function(){
                $(this).prop("checked",false);
            });
        }
    }
     //메일주소 disabled -select
    $(".js-mail-select").change(function(){
        var mail_input = $(this).closest(".mail-after").find(".js-mail-input");
        if($(this).val() == "direct"){
            $(mail_input).prop("disabled",false);
           $(mail_input).focus();
        }else{
            $(mail_input).prop("disabled",true);
             $(mail_input).val("");
        }
    });
</script>


@endsection
