<form method="post" action="{{ route('user.client.company',['id'=>$user->id]) }}" class="">
    {{ csrf_field() }}
    숙박업체 사업자정보와 정산정보를 수정 하기 전 사업자 선택하는 화면 필요
{{--
    <div class="position-relative form-group">
        <label for="userEmail" class="">Email</label>
        <input name="email" id="userEmail" placeholder="이메일 주소를 입력하세요" type="email" class="form-control" value="{{ isset($user)&&$user->email!=""?$user->email:"" }}" />
        <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
    </div>
    <div class="position-relative form-group">
        <label for="userPassword" class="">비밀번호</label>
        <input name="password" id="userPassword" placeholder="비밀번호를 입력하세요" type="password" class="form-control" />
        <small id="passwordHelp" class="form-text text-muted">영문, 숫자, 특수문자 각 1개이상을 사용하여 8~20자리로 사용해야 합니다.</small>
    </div>
    <div class="position-relative form-group">
        <label for="userPassword2" class="">비밀번호 확인</label>
        <input name="password2" id="userPassword2" placeholder="비밀번호를 입력하세요" type="password" class="form-control" />
        <small id="password2Help" class="form-text text-muted">입력하신 비밀번호를 한번 더 입력해주세요</small>
    </div>
    <div class="position-relative form-group">
        <label for="agencySelect" class="">대행사(코드에서 자동화)</label>
        <select name="agency" id="agencySelect" class="form-control">
            <option value="">::대행사선택::</option>
        </select>
    </div>
    <div class="position-relative form-group">
        <label for="clientSelect" class="">유형</label>
        <div>
            @php $clientType = \App\Http\Controllers\Controller::getCode('client_type'); @endphp
            @foreach($clientType as $k => $c)
            <div class="custom-radio custom-control custom-control-inline">
                <input type="radio" name="codeType" id="clientType{{$k}}" class="custom-control-input" value="{{$c->code}}" />
                <label class="custom-control-label" for="clientType{{$k}}">{{$c->name}}</label>
            </div>
            @endforeach
        </div>
    </div>
    <div class="position-relative form-group">
        <label for="codeDesign" class="">스킨</label>
        @php $skinReserve = \App\Http\Controllers\Controller::getCode('skin_reserve'); @endphp
        <select name="codeDesign" id="codeDesign" class="form-control">
            <option value="">::스킨선택::</option>
            @foreach($skinReserve as $s)
                <option value="{{$s->code}}">{{$s->name}}</option>
            @endforeach
        </select>
    </div>
    <div class="position-relative form-group">
        <label for="clientName" class="">숙박업체명(한글)</label>
        <input name="clientName" id="clientName" placeholder="숙박업체 이름을 입력하세요" type="text" class="form-control" value="{{ isset($userInfo)&&$userInfo->client_name!=""?$userInfo->client_name:"" }}" />
    </div>
    <div class="position-relative form-group">
        <label for="clientNameEn" class="">숙박업체명(영문)</label>
        <input name="clientNameEn" id="clientNameEn" placeholder="숙박업체 이름(염문)을 입력하세요" type="text" class="form-control" value="{{ isset($userInfo)&&$userInfo->client_name_en!=""?$userInfo->client_name_en:"" }}" />
    </div>
    <div class="position-relative form-group">
        <label for="clientAddr" class="">주소</label>
        <div class="form-row">
            <div class="col-md-2">
                <input type="hidden" name="clientPost" value="{{ isset($userInfo)&&$userInfo->client_post!=""?$userInfo->client_post:"" }}" />
                <button class="mb-2 mr-2 btn btn-focus">우편번호찾기</button>
            </div>
            <div class="col-md-4">
                <input name="clientAddrBasic" id="clientAddrBasic" placeholder="우편번호를 입력하세요" type="text" class="form-control" value="{{ isset($userInfo)&&$userInfo->client_addr_basic!=""?$userInfo->client_addr_basic:"" }}" />
            </div>
            <div class="col-md-4">
                <input name="clientAddrDetail" id="clientAddrDetail" placeholder="주소를 입력하세요" type="text" class="form-control" value="{{ isset($userInfo)&&$userInfo->client_addr_detail!=""?$userInfo->client_addr_detail:"" }}" />
            </div>
        </div>
    </div>
    <div class="position-relative form-group">
        <label for="clientOwner" class="">대표자</label>
        <input name="clientOwner" id="clientOwner" placeholder="대표자를 입력하세요" type="text" class="form-control" value="{{ isset($userInfo)&&$userInfo->client_owner!=""?$userInfo->client_owner:"" }}" />
    </div>
    <div class="position-relative form-group">
        @php
            $telephone = ["","",""];
            if(isset($userInfo)&&$userInfo->client_tel!="") {
                $telephone = explode("-",$userInfo->client_tel);
            }
        @endphp
        <label for="clientTel" class="">연락처</label>
        <div class="form-row">
            <div class="col-md-2">
                @php $codeTel = \App\Http\Controllers\Controller::getCode('area_number'); @endphp
                <select name="clientTel1" id="clientTel1" class="form-control">
                    @foreach($codeTel as $c)
                        <option value="{{$c->code}}" {{$telephone[0]==$c->code?"selected":""}}>{{ $c->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <input name="clientTel2" id="clientTel2" placeholder="전화번호를 입력하세요" type="text" class="form-control" value="{{$telephone[1]}}" />
            </div>
            <div class="col-md-3">
                <input name="clientTel3" id="clientTel3" placeholder="전화번호를 입력하세요" type="text" class="form-control" value="{{$telephone[2]}}" />
            </div>
        </div>
    </div>
    <div class="position-relative form-group">
        @php
            $cellphone = ["","",""];
            if(isset($userInfo)&&$userInfo->client_hp!="") {
                $cellphone = explode("-",$userInfo->client_hp);
            }
        @endphp
        <label for="clientHp" class="">휴대폰</label>
        <div class="row">
            <div class="col-md-2">
                @php $codeHp = \App\Http\Controllers\Controller::getCode('phone_number'); @endphp
                <select name="clientHp1" id="clientHp1" class="form-control">
                    @foreach($codeHp as $c)
                        <option value="{{$c->code}}" {{$cellphone[0]==$c->code?"selected":""}}>{{ $c->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <input name="clientHp2" id="clientHp2" placeholder="전화번호를 입력하세요" type="text" class="form-control" value="{{$cellphone[1]}}" />
            </div>
            <div class="col-md-3">
                <input name="clientHp3" id="clientHp3" placeholder="전화번호를 입력하세요" type="text" class="form-control" value="{{$cellphone[2]}}" />
            </div>
        </div>
    </div>
    <div class="form-row">
        <div class="col-md-2 mb-3">
            <label for="clientCheckIn">숙박업체 체크인</label>
            <input type="time" name="clientCheckIn" id="clientCheckIn" class="form-control" placeholder="CheckInTime" value="{{ isset($userInfo)&&$userInfo->client_check_in!=""?$userInfo->client_check_in:"" }}" />
            <div class="valid-tooltip">toolTips!!</div>
        </div>
        <div class="col-md-1 mb-3"></div>
        <div class="col-md-2 mb-3">
            <label for="clientCheckOut">숙박업체 체크아웃</label>
            <input type="time" name="clientCheckOut" id="clientCheckOut" class="form-control" placeholder="CheckOutTime" value="{{ isset($userInfo)&&$userInfo->client_check_out!=""?$userInfo->client_check_out:"" }}" />
            <div class="valid-tooltip">toolTips!!</div>
        </div>
    </div>
    <div class="form-row">
        <div class="col-md-2 mb-3">
            <label for="clientFeeAgency">예약대행 수수료</label>
            <input type="text" name="clientFeeAgency" id="clientFeeAgency" class="form-control" placeholder="FeeAgency" value="{{ isset($userInfo)&&$userInfo->client_fee_agency!=""?$userInfo->client_fee_agency:"" }}" />
            <div class="valid-tooltip">toolTips!!</div>
        </div>
        <div class="col-md-1 mb-3">
            <label for="clientFeeAgencyUnit">&nbsp;</label>
            @php $fee_unit = \App\Http\Controllers\Controller::getCode('fee_order_unit'); @endphp
            <select name="clientFeeAgencyUnit" id="clientFeeAgencyUnit" class="form-control">
                @foreach($fee_unit as $f)
                    <option value="{{$f->code}}" {{isset($userInfo)&&$userInfo->client_fee_agency_unit==$f->code?"selected":""}}>{{ $f->name }}</option>
                @endforeach
                <option value="%">%</option>
                <option value="원">원</option>
            </select>
        </div>
        <div class="col-md-1 mb-3"></div>
        <div class="col-md-2 mb-3">
            <label for="clientFeePayment">결제대행 수수료</label>
            <input type="text" name="clientFeePayment" id="clientFeePayment" class="form-control" placeholder="FeePayment" value="{{ isset($userInfo)&&$userInfo->client_fee_payment!=""?$userInfo->client_fee_payment:"" }}" />
            <div class="valid-tooltip">toolTips!!</div>
        </div>
        <div class="col-md-1 mb-3">
            <label for="clientFeePaymentUnit">&nbsp;</label>
            @php $fee_unit = \App\Http\Controllers\Controller::getCode('fee_order_unit'); @endphp
            <select name="clientFeePaymentUnit" id="clientFeePaymentUnit" class="form-control">
                @foreach($fee_unit as $f)
                    <option value="{{$f->code}}" {{isset($userInfo)&&$userInfo->client_fee_payment_unit==$f->code?"selected":""}}>{{ $f->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="position-relative form-group">
        <label for="facilityCommon" class="">공용부대시설(코드에서 자동화)-객실의 부대시설과 차이에 대한 내용 확인 후 진행</label>
        <div>
            <div class="custom-checkbox custom-control custom-control-inline">
                <input type="checkbox" name="facilityCommon" id="facilityCommon1" class="custom-control-input" value="" />
                <label class="custom-control-label" for="facilityCommon1">시설1</label>
            </div>
        </div>
    </div>
    <div class="position-relative form-group">
        <label for="facilityService" class="">서비스(코드에서 자동화)-객실의 부대시설과 차이에 대한 내용 확인 후 진행</label>
        <div>
            <div class="custom-checkbox custom-control custom-control-inline">
                <input type="checkbox" name="facilityService" id="facilityService1" class="custom-control-input" value="" />
                <label class="custom-control-label" for="facilityService1">서비스1</label>
            </div>
        </div>
    </div>
    <button class="mt-1 btn btn-primary">등록</button>
--}}
</form>
