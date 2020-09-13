@extends("admin.pc.layout.basic")

@section("title")
    예약시스템-숙박업체 사업자/정산정보
@endsection

@section("scripts")
    <script type="text/template" id="settle_info">
        <div class="table-a">
            <input type="hidden" name="id[]" value="" />
            <table class="table-a__table type-top table-a__tr__section">
                <colgroup>
                    <col width="11%">
                    <col width="">
                    <col width="11%">
                    <col width="">
                    <col width="11%">
                    <col width="">
                </colgroup>
                <tr class="table-a__tr table-a__tr__section_de3">
                    <td class="table-a__td type-nobd type-right type-top lh-28">
                        상호명
                    </td>
                    <td class="table-a__td type-nobd type-left">
                        <div class="input-wrap" style="width:150px;">
                            <input type="text" name="company_name[{cnt}]" class="input-v1 ta-r" placeholder="펜션상호명">
                        </div>
                    </td>
                    <td class="table-a__td type-nobd type-right type-top lh-28">
                        대표자명
                    </td>
                    <td class="table-a__td type-nobd type-left">
                        <div class="input-wrap" style="width:150px;">
                            <input type="text" name="company_owner[{cnt}]" class="input-v1 ta-r" placeholder="대표자" />
                        </div>
                    </td>
                    <td class="table-a__td type-nobd type-right type-top lh-28">
                        사업자등록증사본
                    </td>
                    <td class="table-a__td type-nobd type-left">
                        <div class="table-a_inbox type-head">
                            <div class="file-wrap">
                                <div class="input-file-container">
                                    <input class="input-file" id="file_company{cnt}" name="file_company" type="file">
                                    <label tabindex="0" for="file_company{cnt}" class="btn-v1 input-file-trigger">파일추가</label>
                                    <p class="file-return dp-ib">선택된 파일 없음</p>
                                </div>
                            </div>

                        {{-- type="file" name="file_company" ok --}}
                        {{-- input type=file로 변경요청 --}}
                        <!--
                                        <button type="button" class="btn-v1">파일추가</button>
                                        <button type="button" class="btn-v1_w">선택된 파일 없음</button>
-->
                        </div>
                    </td>
                </tr>

                <tr class="table-a__tr table-a__tr__section_de2">
                    <td class="table-a__td type-nopd" colspan="6" style="padding:0!important">
                        <table class="table-a__table">
                            <colgroup>
                                <col width="11%">
                                <col width="39%">
                                <col width="11%">
                                <col width="39%">
                            </colgroup>
                            <tr class="table-a__tr">
                                <td class="table-a__td type-nobd type-right type-top lh-28">
                                    업태 / 종목
                                </td>
                                <td class="table-a__td type-nobd type-left">
                                    <div class="input-wrap" style="width:150px;">
                                        <input type="text" name="company_item1[{cnt}]" class="input-v1 ta-r" placeholder="업태" />
                                    </div>
                                    <div class="input-wrap left-mg" style="width:150px;margin-left:5px;">
                                        <input type="text" name="company_item2[{cnt}]" class="input-v1 ta-r" placeholder="종목" />
                                    </div>
                                </td>
                                <td class="table-a__td type-nobd type-right type-top lh-28">
                                    사업자번호
                                </td>
                                <td colspan="2" class="table-a__td type-nobd type-left">
                                    <div class="table-a__inbox type-left fl lh-28" >
                                        <input type="radio" name="company_type2[{cnt}]" id="company_type2_{cnt}_Y" class="radio-v1 dp-ib" value="Y" />
                                        <label for="company_type2_{cnt}_Y" class="lh-28__label">간이</label>
                                        <input type="radio" name="company_type2[{cnt}]" id="company_type2_{cnt}_N" class="radio-v1 dp-ib" value="N" checked />
                                        <label for="company_type2_{cnt}_N" class="ml-20 lh-28__label">일반</label>
                                    </div>
                                    <div class="fl clb biz-num" style="width:200px;margin-left:40px;">
                                        <div class="input-wrap fl" style="width:30%">
                                            <input type="text" name="company_number1[{cnt}][]" class="input-v1 ta-r" placeholder="000">
                                        </div>
                                        <div class="input-wrap fl type-icon-before" style="width:30%;padding-left:15px;">
                                            <input type="text" name="company_number2[{cnt}][]" class="input-v1 ta-r" placeholder="00">
                                        </div>
                                        <div class="input-wrap fl type-icon-before" style="width:40%;padding-left:15px;">
                                            <input type="text" name="company_number3[{cnt}][]" class="input-v1 ta-r" placeholder="00000">
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr class="table-a__tr">
                                <td class="table-a__td type-nobd type-right type-top lh-28">
                                    통신판매
                                </td>
                                <td class="table-a__td type-nobd type-left">
                                    <div class="input-wrap" style="width:150px;">
                                        <input type="text" name="regist_number1[{cnt}]" class="input-v1 ta-r" placeholder="통신판매" />
                                    </div>
                                </td>

                                <td class="table-a__td type-nobd type-right type-top lh-28">
                                    민박허가
                                </td>
                                <td class="table-a__td type-nobd type-left">
                                    <div class="input-wrap" style="width:150px;">
                                        <input type="text" name="regist_number2[{cnt}]" class="input-v1 ta-r" placeholder="통신판매" />
                                    </div>
                                </td>
                            </tr>
                            <tr class="table-a__tr">
                                <td class="table-a__td type-nobd type-right type-top lh-28" style="border-bottom:0;">
                                    연락처
                                </td>
                                <td class="table-a__td type-nobd type-left" style="border-bottom:0;">
                                    <div class="input-wrap" style="width:150px;">
                                        <input type="text" name="company_tel[{cnt}]" class="input-v1 ta-r" placeholder="012-1203-4567" />
                                    </div>
                                    <div class="input-wrap left-mg" style="width:150px;">
                                        <input type="text" name="company_hp[{cnt}]" class="input-v1 ta-r" placeholder="012-1203-4567" />
                                    </div>
                                </td>
                                <td class="table-a__td type-nobd type-right type-top lh-28" style="border-bottom:0;">
                                    이메일
                                </td>
                                <td class="table-a__td type-nobd type-left" style="border-bottom:0;">
                                    @php $list_email = \App\Http\Controllers\Controller::getCode("email_address"); @endphp
                                    <div class="input-wrap fl" style="width:110px;">
                                        <input type="text" name="company_email_id[{cnt}]" class="input-v1 ta-r" placeholder="메일주소" />
                                    </div>
                                    <div class="mail-after fl">
                                        <div class="input-wrap fl ml-5" style="width:110px;">
                                            <input type="text" name="company_email_ad[]" id="email_address_{cnt}" class="input-v1 ta-r js-mail-input type-mail" placeholder="직접입력" disabled />
                                        </div>
                                        <div class="select-wrap left-mg fl ml-5" style="width:130px;">
                                            {{-- name="company_email_ad[]" value="{{isset($company_email[1])?$company_email[1]:""}}"--}}
                                            {{-- 여기에 input box 요청해요(직접입력용) --}}
                                            <select name="email_direct[{cnt}]" id="email_select_{cnt}" class="select-v1 noto js-mail-select">
                                                @foreach($list_email as $e)
                                                    <option value="{{$e->code}}">{{$e->code}}</option>
                                                @endforeach
                                                <option value="direct">직접입력</option>
                                            </select>
                                        </div>
                                    </div>

                                </td>
                            </tr>
                        </table>
                    </td>


                </tr>

                <tr class="table-a__tr table-a__tr__section_de1">
                    <td class="table-a__td type-nobd type-right type-top lh-28">
                        사업장소재지
                    </td>
                    <td class="table-a__td type-nobd type-left" colspan="5">
                        <div class="input-wrap" style="width:80px;">
                            <input type="text" name="company_post[{cnt}]" id="a{cnt}_post" class="input-v1 ta-r" readonly placeholder="우편번호찾기" onclick="postSearch('a{cnt}')" />
                        </div>

                        <div class="input-wrap left-mg" style="width:213px;">
                            <input type="text" name="company_addr_basic[{cnt}]" id="a{cnt}_addr_basic" class="input-v1 ta-r" readonly placeholder="기본주소" />
                        </div>

                        <div class="input-wrap left-mg" style="width:213px;">
                            <input type="text" name="company_addr_detail[{cnt}]" id="a{cnt}_addr_detail" class="input-v1 ta-r" placeholder="상세주소" />
                        </div>
                    </td>
                </tr>

                <tr class="table-a__tr table-a__tr__section_de1">
                    <td class="table-a__td type-nobd type-right type-top lh-28">
                        정산계좌
                    </td>
                    <td class="table-a__td type-nobd type-left" colspan="5">
                        <div class="select-wrap fl" style="width:113px;">
                            <select name="code_bank[{cnt}]" id="code_bank_{cnt}" class="select-v1 noto">
                                <option value="">::선택::</option>
                                <option value="은행선택">은행선택</option>
                                <option value="국민은행">국민은행</option>
                                <option value="국민은행">국민은행</option>
                                <option value="국민은행">국민은행</option>
                            </select>
                        </div>

                        <div class="input-wrap left-mg fl ml-5" style="width:210px;">

                            <input type="text" name="settle_name[{cnt}]" class="input-v1 ta-r" placeholder="계좌번호" />
                        </div>
                        <div class="input-wrap left-mg fl ml-5" style="width:100px;">

                            <input type="text" name="settle_name[{cnt}]" class="input-v1 ta-r" placeholder="예금주" />
                        </div>
                        <div class="table-a__inbox type-left fl ml-20" >
                            <input type="radio" name="settle_type[{cnt}]" id="settle_type_{cnt}_Y" class="radio-v1 dp-ib" value="Y" checked  />
                            <label for="settle_type_{cnt}_Y" class="lh-28__label lh-28">즉시</label>
                            <input type="radio" name="settle_type[{cnt}]" id="settle_type_{cnt}_N" class="radio-v1 dp-ib" value="N" />
                            <label for="settle_type_{cnt}_N" class="ml-20 lh-28__label lh-28">적용일자</label>
                        </div>
                        <div class="input-wrap fl ml-20" style="width:150px;">
                            <input type="text" name="settle_date[]" class="input-v1 ta-r" placeholder="0000-00-00" />
                        </div>
                    </td>
                    {{-- <textarea name="request"></textarea> --}}
                </tr>
            </table>
        </div>
    </script>
    <script>
        var cnt = {{sizeof($company)}};

        function replaceTemplate(templateStr, data) {
            var result = templateStr;
            for (var key in data) {
                result = result.replace(/{cnt}/gi, data[key]);
            }
            return result;
        }

        function data_insert() {
            var inCont = $("script#settle_info").html();
            var inCont = replaceTemplate(inCont, {'cnt': cnt});
            //$("div.table-a").append(inCont);
            $("form[name=frmCompanyInfo]").append(inCont);
            cnt++;
        }

        $(function(){
            $("button.infoCompanyConfirm").click(function(){
                $.post(
                    "{{ route('user.client.settle.confirm') }}"
                    ,{
                        _token: '{{csrf_token()}}',
                        id: $(this).data("id")
                    }
                    ,function(data) {
                        document.location.reload();
                    }
                    ,"json"
                )
            });
        });

    </script>
@endsection

@section("styles")
<!--<link rel="stylesheet" href="http://staff.einet.co.kr/asset/css/common-b.css">-->
<!--<link rel="stylesheet" href="http://staff.einet.co.kr/asset/css/blade.css?v=<?=time() ?>">-->
<link rel="stylesheet" href="http://staff.einet.co.kr/asset/css/jjh-style.css">
@endsection

@section("contents")
	<div class="guide-box" id="i_client_settle_blade">
        <div class="guide-wrap">
            <div>
                <div class="table-a noto">
                    <div class="table-a__head clb">
                        <p class="table-a__tit fl">사업자 / 정산정보</p>
                        <div class="table-a_inbox type-head fr">
                            <button type="button" class="btn-v1 add-icon" onclick="data_insert()"><img src="http://staff.einet.co.kr/asset/images/form_2/add-icon-w.png"><p>추가</p></button>
                        </div>
                    </div>

                    <form method="post" name="frmCompanyInfo" enctype="multipart/form-data" action="{{ url()->current() }}">
                        {{ csrf_field() }}
                        @foreach($company as $cnt => $c)
                        <div class="table-a">
                        <input type="hidden" name="id[]" value="{{$c->id}}" />
                        @php
                            $company_number = explode("-",$c->company_number);
                            $company_email = explode("@",$c->company_email);
                        @endphp
                        <table class="table-a__table type-top table-a__tr__section">
						 	<colgroup>
								<col width="11%">
								<col width="">
								<col width="11%">
								<col width="">
								<col width="11%">
								<col width="">
						 	</colgroup>
							<tr class="table-a__tr table-a__tr__section_de3">
								<td class="table-a__td type-nobd type-right type-top lh-28">
									상호명
								</td>
								<td class="table-a__td type-nobd type-left">
									<div class="input-wrap" style="width:150px;">
										<input type="text" name="company_name[{{$cnt}}]" class="input-v1 ta-r" value="{{$c->company_name}}" placeholder="펜션상호명">
									</div>
								</td>
                                <td class="table-a__td type-nobd type-right type-top lh-28">
                                    대표자명
                                </td>
                                <td class="table-a__td type-nobd type-left">
                                    <div class="input-wrap" style="width:150px;">
                                        <input type="text" name="company_owner[{{$cnt}}]" class="input-v1 ta-r" value="{{$c->company_owner}}" placeholder="대표자" />
                                    </div>
                                </td>
                                <td class="table-a__td type-nobd type-right type-top lh-28">
                                    사업자등록증사본
                                </td>
                                <td class="table-a__td type-nobd type-left">
                                  <div class="table-a_inbox type-head">
                                   <div class="file-wrap">
                                        <div class="input-file-container">
                                            <input class="input-file" id="file_company{{$cnt}}" name="file_company" type="file">
                                            <label tabindex="0" for="file_company{{$cnt}}" class="btn-v1 input-file-trigger">파일추가</label>
                                            <p class="file-return dp-ib">선택된 파일 없음</p>
                                        </div>
                                    </div>

                                        {{-- type="file" name="file_company" ok --}}
                                        {{-- input type=file로 변경요청 --}}
<!--
                                        <button type="button" class="btn-v1">파일추가</button>
                                        <button type="button" class="btn-v1_w">선택된 파일 없음</button>
-->
                                    </div>
                                </td>
                            </tr>

							<tr class="table-a__tr table-a__tr__section_de2">
							<td class="table-a__td type-nopd" colspan="6" style="padding:0!important">
							    <table class="table-a__table">
                                <colgroup>
                                    <col width="11%">
                                    <col width="39%">
                                    <col width="11%">
                                    <col width="39%">
                                </colgroup>
							        <tr class="table-a__tr">
							            <td class="table-a__td type-nobd type-right type-top lh-28">
									        업태 / 종목
                                        </td>
                                        <td class="table-a__td type-nobd type-left">
                                            <div class="input-wrap" style="width:150px;">
                                                <input type="text" name="company_item1[{{$cnt}}]" value="{{$c->company_item1}}" class="input-v1 ta-r" placeholder="업태" />
                                            </div>
                                            <div class="input-wrap left-mg" style="width:150px;margin-left:5px;">
                                                <input type="text" name="company_item2[{{$cnt}}]" value="{{$c->company_item2}}" class="input-v1 ta-r" placeholder="종목" />
                                            </div>
                                        </td>
                                        <td class="table-a__td type-nobd type-right type-top lh-28">
                                            사업자번호
                                        </td>
                                        <td colspan="2" class="table-a__td type-nobd type-left">
                                            <div class="table-a__inbox type-left fl lh-28" >
                                                <input type="radio" name="company_type2[{{$cnt}}]" id="company_type2_{{$cnt}}_Y" class="radio-v1 dp-ib" value="Y" {{$c->company_type2=="Y"?"selected":""}} />
                                                <label for="company_type2_{{$cnt}}_Y" class="lh-28__label">간이</label>
                                                <input type="radio" name="company_type2[{{$cnt}}]" id="company_type2_{{$cnt}}_N" class="radio-v1 dp-ib" value="N" {{!($c->company_type2)||$c->company_type2=="N"?"checked":""}} />
                                                <label for="company_type2_{{$cnt}}_N" class="ml-20 lh-28__label">일반</label>
                                            </div>
                                            <div class="fl clb biz-num" style="width:200px;margin-left:40px;">
                                                <div class="input-wrap fl" style="width:30%">
                                                    <input type="text" name="company_number1[{{$cnt}}][]" class="input-v1 ta-r" value="{{$company_number[0]}}" placeholder="000">
                                                </div>
                                                <div class="input-wrap fl type-icon-before" style="width:30%;padding-left:15px;">
                                                    <input type="text" name="company_number2[{{$cnt}}][]" class="input-v1 ta-r" value="{{$company_number[1]}}" placeholder="00">
                                                </div>
                                                <div class="input-wrap fl type-icon-before" style="width:40%;padding-left:15px;">
                                                    <input type="text" name="company_number3[{{$cnt}}][]" class="input-v1 ta-r" value="{{$company_number[2]}}" placeholder="00000">
                                                </div>
                                            </div>
                                        </td>
							        </tr>
							        <tr class="table-a__tr">
							            <td class="table-a__td type-nobd type-right type-top lh-28">
                                            통신판매
                                        </td>
                                        <td class="table-a__td type-nobd type-left">
                                            <div class="input-wrap" style="width:150px;">
                                                <input type="text" name="regist_number1[{{$cnt}}]" value="{{$c->regist_number1}}" class="input-v1 ta-r" placeholder="통신판매" />
                                            </div>
                                        </td>

                                        <td class="table-a__td type-nobd type-right type-top lh-28">
                                            민박허가
                                        </td>
                                        <td class="table-a__td type-nobd type-left">
                                            <div class="input-wrap" style="width:150px;">
                                                <input type="text" name="regist_number2[{{$cnt}}]" value="{{$c->regist_number2}}" class="input-v1 ta-r" placeholder="통신판매" />
                                            </div>
                                        </td>
							        </tr>
							        <tr class="table-a__tr">
							            <td class="table-a__td type-nobd type-right type-top lh-28" style="border-bottom:0;">
                                            연락처
                                        </td>
                                        <td class="table-a__td type-nobd type-left" style="border-bottom:0;">
                                            <div class="input-wrap" style="width:150px;">
                                                <input type="text" name="company_tel[{{$cnt}}]" value="{{$c->company_tel}}" class="input-v1 ta-r" placeholder="012-1203-4567" />
                                            </div>
                                            <div class="input-wrap left-mg" style="width:150px;">
                                                <input type="text" name="company_hp[{{$cnt}}]" value="{{$c->company_hp}}" class="input-v1 ta-r" placeholder="012-1203-4567" />
                                            </div>
                                        </td>
                                        <td class="table-a__td type-nobd type-right type-top lh-28" style="border-bottom:0;">
                                            이메일
                                        </td>
                                        <td class="table-a__td type-nobd type-left" style="border-bottom:0;">
                                            @php $list_email = \App\Http\Controllers\Controller::getCode("email_address"); @endphp
                                            <div class="input-wrap fl" style="width:110px;">
                                                <input type="text" name="company_email_id[{{$cnt}}]" value="{{$company_email[0]}}" class="input-v1 ta-r" placeholder="메일주소" />
                                            </div>
                                            <div class="mail-after fl">
                                                <div class="input-wrap fl ml-5" style="width:110px;">
                                                    <input type="text" name="company_email_ad[]" id="email_address_{{$cnt}}" value="{{isset($company_email[1])?$company_email[1]:""}}" class="input-v1 ta-r js-mail-input type-mail" placeholder="직접입력" disabled />
                                                </div>
                                                <div class="select-wrap left-mg fl ml-5" style="width:130px;">
                                                    {{-- name="company_email_ad[]" value="{{isset($company_email[1])?$company_email[1]:""}}"--}}
                                                    {{-- 여기에 input box 요청해요(직접입력용) --}}
                                                    <select name="email_direct[{{$cnt}}]" id="email_select_{{$cnt}}" class="select-v1 noto js-mail-select">
                                                        @foreach($list_email as $e)
                                                        <option value="{{$e->code}}">{{$e->code}}</option>
                                                        @endforeach
                                                        <option value="direct">직접입력</option>
                                                    </select>
                                                </div>
                                            </div>

                                        </td>
							        </tr>
							    </table>
							</td>


                            </tr>

                            <tr class="table-a__tr table-a__tr__section_de1">
								<td class="table-a__td type-nobd type-right type-top lh-28">
									사업장소재지
								</td>
								<td class="table-a__td type-nobd type-left" colspan="5">
									<div class="input-wrap" style="width:80px;">
										<input type="text" name="company_post[{{$cnt}}]" id="a{{$cnt}}_post" value="{{$c->company_post}}" class="input-v1 ta-r" readonly placeholder="우편번호찾기" onclick="postSearch('a{{$cnt}}')" />
									</div>

									<div class="input-wrap left-mg" style="width:213px;">
										<input type="text" name="company_addr_basic[{{$cnt}}]" id="a{{$cnt}}_addr_basic" value="{{$c->company_addr_basic}}" class="input-v1 ta-r" readonly placeholder="기본주소" />
									</div>

									<div class="input-wrap left-mg" style="width:213px;">
										<input type="text" name="company_addr_detail[{{$cnt}}]" id="a{{$cnt}}_addr_detail" value="{{$c->company_addr_detail}}" class="input-v1 ta-r" placeholder="상세주소" />
									</div>
								</td>
							</tr>

                            <tr class="table-a__tr table-a__tr__section_de1">
								<td class="table-a__td type-nobd type-right type-top lh-28">
									정산계좌
								</td>
								<td class="table-a__td type-nobd type-left" colspan="5">
                                    @php $bank = \App\Http\Controllers\Controller::getCode("settle_bank"); @endphp
									<div class="select-wrap fl" style="width:113px;">
                                        <select name="code_bank[{{$cnt}}]" id="code_bank_{{$cnt}}" class="select-v1 noto">
                                            <option value="">::선택::</option>
                                            @foreach($bank as $b)
                                            <option value="{{$b->code}}">{{$b->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>

									<div class="input-wrap left-mg fl ml-5" style="width:210px;">

                                        <input type="text" name="settle_name[{{$cnt}}]" value="{{$c->settle_name}}" class="input-v1 ta-r" placeholder="계좌번호" />
									</div>
                                   <div class="input-wrap left-mg fl ml-5" style="width:100px;">

                                        <input type="text" name="settle_name[{{$cnt}}]" value="{{$c->settle_name}}" class="input-v1 ta-r" placeholder="예금주" />
									</div>
                                    <div class="table-a__inbox type-left fl ml-20" >
                                        <input type="radio" name="settle_type[{{$cnt}}]" id="settle_type_{{$cnt}}_Y" class="radio-v1 dp-ib" value="Y" {{!isset($c->settle_type)||$c->settle_type=="Y"?"selected":""}}  />
                                        <label for="settle_type_{{$cnt}}_Y" class="lh-28__label lh-28">즉시</label>
                                        <input type="radio" name="settle_type[{{$cnt}}]" id="settle_type_{{$cnt}}_N" class="radio-v1 dp-ib" value="N" {{$c->settle_type=="N"?"selected":""}}  />
                                        <label for="settle_type_{{$cnt}}_N" class="ml-20 lh-28__label lh-28">적용일자</label>
                                    </div>
									<div class="input-wrap fl ml-20" style="width:150px;">
										<input type="text" name="settle_date[]" value="{{$c->settle_date}}" class="input-v1 ta-r" placeholder="0000-00-00" />
									</div>
								</td>
                                {{-- <textarea name="request"></textarea> --}}
							</tr>
                        </table>
                        </div>
                        @endforeach
                        <div class="btn-wrap type-fg">
                            <button type="submit" class="btn-v4 type-save">정산문의 및 수정요청</button>
                        </div>
                    </form>
                    @foreach($history as $h)
                    <table class="table-a__table type-top table-a__tr__section bor_bottom table-a__tr__section section-margin">
                        <colgroup>
                            <col width="11%">
                            <col width="39%">
                            <col width="11%">
                            <col width="39%">
                        </colgroup>
                        <tr class="table-a__tr">
                            <td class="table-a__td type-nobd type-right type-top lh-28">
                                상호명
                            </td>
                            <td class="table-a__td type-nobd type-left type-settle">
                                <span>{{$h->company_name}}</span>
                            </td>
                            <td class="table-a__td type-nobd type-right type-top lh-28">
                                전화번호
                            </td>
                            <td class="table-a__td type-nobd type-left type-settle">
                                <span>{{$h->company_tel}}</span>
                            </td>
                        </tr>
                        <tr class="table-a__tr">
                            <td class="table-a__td type-nobd type-right type-top lh-28">
                                사업자번호
                            </td>
                            <td class="table-a__td type-nobd type-left type-settle">
                                <span>{{$h->company_number}}</span>
                            </td>
                            <td class="table-a__td type-nobd type-right type-top lh-28">
                                휴대폰번호
                            </td>
                            <td class="table-a__td type-nobd type-left type-settle">
                                <span>{{$h->company_hp}}</span>
                            </td>
                        </tr>
                        <tr class="table-a__tr">
                            <td class="table-a__td type-nobd type-right type-top lh-28">
                                주소
                            </td>
                            <td class="table-a__td type-nobd type-left type-settle">
                                <span>[{{$h->company_post}}] {{$h->company_addr_basic}} {{$h->company_addr_detail}}</span>
                            </td>
                            <td class="table-a__td type-nobd type-right type-top lh-28">
                                이메일주소
                            </td>
                            <td class="table-a__td type-nobd type-left type-settle">
                                <span>{{$h->company_email}}</span>
                            </td>
                        </tr>
                        <tr class="table-a__tr">
                            <td class="table-a__td type-nobd type-right type-top lh-28">
                                업태/종목
                            </td>
                            <td class="table-a__td type-nobd type-left type-settle">
                                <span>{{$h->company_item1}}/{{$h->company_item2}}</span>
                            </td>
                            <td class="table-a__td type-nobd type-right type-top lh-28">
                                정산정보
                            </td>
                            <td class="table-a__td type-nobd type-left type-settle">
                                 <span>{{$h->code_bank}} {{$h->settle_account}} {{$h->settle_name}}</span>
                            </td>
                        </tr>
                        <tr class="table-a__tr">
                            <td class="table-a__td type-nobd type-right type-top lh-28">
                                반영일
                            </td>
                            <td class="table-a__td type-nobd type-left type-settle">
                                <span>{{$h->settle_type}} {{$h->settle_date}}</span>
                            </td>
                            <td class="table-a__td type-nobd type-right type-top lh-28">
                                <br>
                            </td>
                            <td class="table-a__td type-nobd type-left type-settle">

                            </td>
                        </tr>
                    </table>
                    <div class="btn-wrap type-fg">
                    @if($h->flag=="Y")
                        <button type="button" class="btn-v2" data-id="{{$h->id}}">완료{{$h->id}}[승인자-{{$h->changed_user_id}},{{$h->updated_at}}]</button>
                    @else
                        <button type="button" class="btn-v2 infoCompanyConfirm" data-id="{{$h->id}}">승인{{$h->id}}</button>
                    @endif
                    </div>
                    @endforeach
                </div>
            </div>
            <script>
                $(document).on("click",".add-img__imgbox",function(){
                    $(this).next().trigger("click");
                });
            </script>
            <pre class="brush: html;">
            </pre>
        </div>
	</div>

<script>
    //파일 인풋 트리거
		$(".input-file-trigger").on( "click", function() {
            $(this).closest(".input-file-container").find(".input-file").trigger("click");
		    return false;
		});

		$(".input-file").change(function() {
			var fileValue = $(this).val().split("\\");
			var fileName = fileValue[fileValue.length-1];
            console.log(fileName);
			var name = $(this).closest(".input-file-container").find(".file-return");
            $(name).text(fileName);
		});
    //메일주소 disabled -select
    $(".js-mail-select").change(function(){
        var mail_input = $(this).closest(".mail-after").find(".js-mail-input");
        if($(this).val() == "direct"){
            $(mail_input).prop("disabled",false);

        }else{
            $(mail_input).prop("disabled",true);
             $(mail_input).val("");
        }
    });



</script>









{{--
	<!-- <form method="post" name="frmCompanyInfo" enctype="multipart/form-data" action="{{ url()->current() }}">
	        {{ csrf_field() }}
	        <h2>사업자/정산정보</h2>
	        <p>
	            <button type="button" onclick="data_insert()">추가</button>
	        </p>
	        <div id="list_data">
	        @foreach($company as $c)
	            <div class="infoCompany">
	                <input type="hidden" name="id[]" value="{{$c->id}}" />
	                @php
	                    $company_number = explode("-",$c->company_number);
	                    $company_email = explode("@",$c->company_email);
	                @endphp
	                상호명
	                <input type="text" name="company_name[]" value="{{$c->company_name}}" />--}}
{{--  상호명  --}}{{--

	                대표자
	                <input type="text" name="company_owner[]" value="{{$c->company_owner}}" />--}}
{{--  대표자  --}}{{--

	                업태/종목
	                <input type="text" name="company_item1[]" value="{{$c->company_item1}}" />--}}
{{--  업태  --}}{{--

	                <input type="text" name="company_item2[]" value="{{$c->company_item2}}" />--}}
{{--  종목  --}}{{--

	                사업자번호
	                <input type="radio" name="company_type2[]" value="Y" {{$c->company_type2=="Y"?"selected":""}} />간이
	                <input type="radio" name="company_type2[]" value="N" {{!($c->company_type2)||$c->company_type2=="N"?"checked":""}} />일반
	                <input type="text" name="company_number1[]" maxlength="3" value="{{$company_number[0]}}" />--}}
{{--  사업자번호1  --}}{{--

	                <input type="text" name="company_number2[]" maxlength="2" value="{{$company_number[1]}}" />--}}
{{--  사업자번호2  --}}{{--

	                <input type="text" name="company_number3[]" maxlength="5" value="{{$company_number[2]}}" />--}}
{{--  사업자번호3  --}}{{--

	                신고종류
	                <input type="text" name="regist_number1[]" value="{{$c->regist_number1}}" />--}}
{{--  통신판매업번호  --}}{{--

	                <input type="text" name="regist_number2[]" value="{{$c->regist_number2}}" />--}}
{{--  민박허가번호  --}}{{--

	                사업장소재지
	                <input type="text" name="company_post[]" value="{{$c->company_post}}" />--}}
{{--  우편번호  --}}{{--

	                <input type="text" name="company_addr_basic[]" value="{{$c->company_addr_basic}}" />--}}
{{--  기본주소  --}}{{--

	                <input type="text" name="company_addr_detail[]" value="{{$c->company_addr_detail}}" />--}}
{{--  상세주소  --}}{{--

	                연락처
	                <input type="text" name="company_tel[]" value="{{$c->company_tel}}" />--}}
{{--  휴대폰  --}}{{--

	                <input type="text" name="company_hp[]" value="{{$c->company_hp}}" />--}}
{{--  전화  --}}{{--

	                이메일
	                <input type="text" name="company_email_id[]" value="{{$company_email[0]}}" />--}}
{{--  이메일 아이디  --}}{{--

	                <input type="text" name="company_email_ad[]" value="{{isset($company_email[1])?$company_email[1]:""}}" />--}}
{{--  이메일 주소  --}}{{--

	                사업자등록증사본
	                <input type="file" name="file_company" />--}}
{{-- 사업자등록증 사본 --}}{{--


	                정산계좌:
	                <select name="code_bank">--}}
{{--  은행  --}}{{--

	                    <option value="">::선택::</option>
	                </select>
	                <input type="text" name="settle_account[]" value="{{$c->settle_account}}" />--}}
{{--  계좌번호  --}}{{--

	                <input type="text" name="settle_name[]" value="{{$c->settle_name}}" />--}}
{{--  예금주  --}}{{--

	                <input type="radio" name="settle_type[]" value="Y" {{!isset($c->settle_type)||$c->settle_type=="Y"?"selected":""}} />즉시--}}
{{--  정산계좌 사용시작 예정일자  --}}{{--

	                <input type="radio" name="settle_type[]" value="N" {{$c->settle_type=="N"?"selected":""}} />적용일자
	                <input type="text" name="settle_date[]" value="{{$c->settle_date}}" />--}}
{{--  정산계좌 사용시작 예정일자  --}}{{--

	                <textarea name="request"></textarea>
	            </div>
	        @endforeach
	        </div>
	        <button>정산문의 및 수정요청</button>
	    </form> -->


	    @foreach($history as $h)
	        <!-- <div>
	            상호명: {{$h->company_name}}<br />
	            사업자번호: {{$h->company_number}}<br />
	            주소: [{{$h->company_post}}] {{$h->company_addr_basic}} {{$h->company_addr_detail}}<br />
	            업종/종목: {{$h->company_item1}}/{{$h->company_item2}}<br />
	            전화번호: {{$h->company_tel}}<br />
	            휴대폰번호: {{$h->company_hp}}<br />
	            이메일주소: {{$h->company_email}}<br />
	            정산정보: {{$h->code_bank}} {{$h->settle_account}} {{$h->settle_name}}<br />
	            반영일: {{$h->settle_type}} {{$h->settle_date}}<br />
	            <button type="button" class="infoCompanyConfirm" data-id="{{$h->id}}">승인</button>
	        </div> -->
	    @endforeach
--}}
@endsection
