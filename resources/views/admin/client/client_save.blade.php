@extends("layout.basic")

@section("title")숙박업체@endsection

@section("scripts")
@endsection

@section("styles")
@endsection

@section("contents")
    <div class="row">
        <div class="main-card card" style="width:100%; ">
            <div class="card-body"><h5 class="card-title">Controls Types</h5>
                <form class="client_form" method="post" action="./saves">
                    {{ csrf_field() }}
                    <div class="position-relative form-group">
                        <label for="clientName" class="">업소명</label>
                        <input type="text" name="clientName" id="clientName" placeholder="업소명을 입력하세요" class="form-control" />
                    </div>
                    <div class="position-relative form-group">
                        <label for="email" class="">Email</label>
                        <input type="email" name="email" id="email" placeholder="Email을 입력하세요" class="form-control" />
                    </div>
                    <div class="position-relative form-group">
                        <label for="password" class="">비밀번호</label>
                        <input type="password" name="password" id="password" placeholder="비밀번호를 입력하세요" class="form-control" />
                    </div>
                    <div class="position-relative form-group">
                        <label for="clientOwner" class="">대표자명</label>
                        <input type="text" name="clientOwner" id="clientOwner" placeholder="대표자명을 입력하세요" class="form-control" />
                    </div>
                    <div class="position-relative form-group">
                        <label for="clientTel_1" class="">대표 연락처</label>
                        <div class="form-row">
                            <div class="col-md-1">
                                <select name="clientTel[]" id="clientTel1" class="form-control">
                                    <option value="02">02(서울)</option>
                                    <option value="031">031(경기)</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <input type="text" name="clientTel[]" id="clientTel2" placeholder="전화번호를 입력하세요" class="form-control">
                            </div>
                            <div class="col-md-2">
                                <input type="text" name="clientTel[]" id="clientTel3" placeholder="전화번호를 입력하세요" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="position-relative form-group">
                        <label for="clientHp_1" class="">예약 수신번호</label>
                        <div class="form-row">
                            <div class="col-md-1">
                                <select name="clientHp[]" id="clientHp1" class="form-control">
                                    <option value="010">010</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <input type="text" name="clientHp[]" id="clientHp2" placeholder="휴대폰번호를 입력하세요" class="form-control">
                            </div>
                            <div class="col-md-2">
                                <input type="text" name="clientHp[]" id="clientHp3" placeholder="휴대폰번호를 입력하세요" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="position-relative form-group">
                        <label for="clientAddress" class="">업체주소</label>
                        <div class="form-row">
                            <div>
                                <input type="hidden" name="clientPost" id="clientPost" value="" />
                                <button class="mr-2 btn btn-focus">우편번호찾기</button>
                            </div>
                            <div class="col-md-4">
                                <input name="clientAddrBasic" id="clientAddrBasic" placeholder="우편번호를 입력하세요" type="text" class="form-control" value="" />
                            </div>
                            <div class="col-md-4">
                                <input name="clientAddrDetail" id="clientAddrDetail" placeholder="주소를 입력하세요" type="text" class="form-control" value="" />
                            </div>
                        </div>
                    </div>
                    <div class="position-relative form-group">
                        <div>
                            <div class="custom-checkbox custom-control custom-control-inline">
                                <input type="checkbox" name="clientFee[]" id="clientFee_1" class="custom-control-input" value="무통장입금" />
                                <label class="custom-control-label" for="clientFee_1">무통장입금</label>
                            </div>
                            <div class="custom-checkbox custom-control custom-control-inline">
                                <input type="checkbox" name="clientFee[]" id="clientFee_2" class="custom-control-input" value="카드결제" />
                                <label class="custom-control-label" for="clientFee_2">카드결제</label>
                                <input type="text" name="clientFeePayment" id="clientFeePayment" class="form-control col-md-3" value="" />
                                <select name="clientFeePaymentUnit" id="clientFeePaymentUnit" class="form-control col-md-3">
                                    <option value="%">%</option>
                                    <option value="원">원</option>
                                </select>
                            </div>
                            <div class="custom-checkbox custom-control custom-control-inline">
                                <input type="checkbox" name="clientFee[]" id="clientFee_3" class="custom-control-input" value="예약대행" />
                                <label class="custom-control-label" for="clientFee_3">예약대행</label>
                                <input type="text" name="clientFeeAgency" id="clientFeeAgency" class="form-control col-md-3" value="" />
                                <select name="clientFeeAgencyUnit" id="clientFeeAgencyUnit" class="form-control col-md-3">
                                    <option value="%">%</option>
                                    <option value="원">원</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="position-relative form-group">
                        <label for="clientAddress" class="">정산정보</label>
                        <button class="mr-2 btn btn-focus">정산정보</button>
                    </div>
                    <div class="position-relative form-group">
                        <div>
                            <div class="custom-checkbox custom-control custom-control-inline">
                                <input type="checkbox" name="codeType[]" id="codeType_1" class="custom-control-input" value="pension" />
                                <label class="custom-control-label" for="codeType_1">펜션</label>
                            </div>
                            <div class="custom-checkbox custom-control custom-control-inline">
                                <input type="checkbox" name="codeType[]" id="codeType_2" class="custom-control-input" value="poolvilla" />
                                <label class="custom-control-label" for="codeType_2">풀빌라</label>
                            </div>
                            <div class="custom-checkbox custom-control custom-control-inline">
                                <input type="checkbox" name="codeType[]" id="codeType_3" class="custom-control-input" value="camping" />
                                <label class="custom-control-label" for="codeType_3">캠핑</label>
                            </div>
                        </div>
                    </div>
                    <div class="position-relative form-group">
                        <label for="clientSiteUrl" class="">홈페이지</label>
                        <input type="text" name="clientSiteUrl" id="clientSiteUrl" placeholder="홈페이지 주소를 입력하세요" class="form-control" />
                    </div>
                    <button class="mt-1 btn btn-primary">저장</button>
                </form>
            </div>
        </div>
    </div>
@endsection

