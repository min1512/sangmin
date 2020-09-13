<script src="https://t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>
<script>
    function search_postcode() {
        new daum.Postcode({
            oncomplete: function(data) {
                var roadAddr = data.roadAddress; // 도로명 주소 변수
                var extraRoadAddr = ''; // 참고 항목 변수

                if(data.bname !== '' && /[동|로|가]$/g.test(data.bname)){
                    extraRoadAddr += data.bname;
                }
                if(data.buildingName !== '' && data.apartment === 'Y'){
                    extraRoadAddr += (extraRoadAddr !== '' ? ', ' + data.buildingName : data.buildingName);
                }
                if(extraRoadAddr !== ''){
                    extraRoadAddr = ' (' + extraRoadAddr + ')';
                }

                document.getElementById('clientPost').value = data.zonecode;
                document.getElementById("clientAddrBasic").value = roadAddr;

                if(roadAddr !== ''){
                    document.getElementById("clientAddrDetail").value = extraRoadAddr;
                } else {
                    document.getElementById("clientAddrDetail").value = '';
                }
            }
        }).open();
    }
    @php
        $codeHp = \App\Http\Controllers\Controller::getCode('phone_number');
    @endphp
    $(function () {
        $('#number_add').click(function () {
            $(this).parent().append(
                                '<label id="bb">'+
                                '<br/>'+
                                '<select name="clientHp_recevie[]" id="clientHp1" class="form-control">' +
                                    @foreach($codeHp as $c)
                                        '<option value="{{$c->code}}">{{ $c->name }}</option>' +
                                    @endforeach
                                '</select>'+
                        '<input name="clientHp_recevie[]" id="clientHp2" size="4" type="text" class="form-control" value="" />' +
                        '<input name="clientHp_recevie[]" id="clientHp3" size="4" type="text" class="form-control" value="" /><a style="color: black;" class="number_delete">X</a>'+
                        '</label>'
                        );
            $(function () {
                $('.number_delete').click(function () {
                    $(this).parents("label").remove();
                });
            })
        });
        $('.number_delete').click(function () {
            $(this).parents("label").remove();
        })
        $('.img_add').click(function () {
            var size = {{ sizeof($file)>0?sizeof($file):0 }}
            $(this).parent().append(
                '<div style="border: 1px solid red;">'+
                '<p style="display: none"><input id="fileName" class="file_input_textbox" readonly value="값을입력하세요"/></p>'+
                '<input type="hidden" id="file_name_'+size+'" name="file_name['+size+']" value="">'+
                '<p><input type="file" id="'+size+'" class="'+size+'" name="file[]" onchange="javascript:file_change(this.value);"/></p>'+
                '<p><a  class="img_label_'+size+'" id="img_label_'+size+'" style="color: red;">삭제</a></p>'+
                '</div>'
            );
            $('.img_label_'+size).click(function () {
                $('#file_name_'+size+'').val("");
                $(this).parent().parent().hide();
            });

            $("input[name^='file']").click(function () {
                var i =0;
                $("input[name^='file']").each(function () {
                    var id = $(this).attr("id");
                    $('#img_label_'+id).click(function () {
                        $('#file_name_'+id+'').val("");
                        $(this).parent().parent().hide();
                    });
                    $("."+id).change(function () {
                        if($('#file_name_'+id+'').val() != $("#fileName").val()){
                            $('#file_name_'+id+'').val($("#fileName").val());
                        } else{
                            $('#file_name_'+id+'').val($("#fileName").val());
                        }
                    });

                })

            })
        })
    });

    function pictureUpload() {
        $(document).ready(function() {
            var imagepath = "file:\\" + $("#myImage").val();
            $("#replaceMe").attr("src", imagepath);
            alert(imagepath);
        });
    }

    function file_change(file){
        var str=file.lastIndexOf("\\")+1;	//파일 마지막 "\" 루트의 길이 이후부터 글자를 잘라 파일명만 가져온다.
        file = file.substring(str, file.length);
        document.getElementById('fileName').value=file;
    }

    function oneCheck(a){
        if($(a).prop("checked")){
            var checkBoxLength = $("input[name^='facilityCommon']").length;
            var checkedLength = $("input[name^='facilityCommon']:checked").length;
            if(checkBoxLength==checkedLength){
                $("#facilityCommon_all").prop("checked", true);
            }else{
                $("#facilityCommon_all").prop("checked", false);
            }
        }else{
            $("#facilityCommon_all").prop("checked", false);
        }
    }

    function oneCheck_Service(a){
        if($(a).prop("checked")){
            var checkBoxLength = $("input[name^='Service']").length;
            var checkedLength = $("input[name^='Service']:checked").length;
            if(checkBoxLength==checkedLength){
                $("#Service_all").prop("checked", true);
            }else{
                $("#Service_all").prop("checked", false);
            }
        }else{
            $("#Service_all").prop("checked", false);
        }
    }

    function oneCheck_tourist(a){
        if($(a).prop("checked")){
            var checkBoxLength = $("input[name^='Nearby_tourist_spots']").length;
            var checkedLength = $("input[name^='Nearby_tourist_spots']:checked").length;
            if(checkBoxLength==checkedLength){
                $("#Nearby_tourist_spots_all").prop("checked", true);
            }else{
                $("#Nearby_tourist_spots_all").prop("checked", false);
            }
        }else{
            $("#Nearby_tourist_spots_all").prop("checked", false);
        }
    }

    $(function () {
        var db_client_facility = {{ sizeof($db_client_facility)>0?sizeof($db_client_facility):0 }}
        var type_facility = {{ sizeof($type_facility)>0?sizeof($type_facility):0 }}
        if(db_client_facility == type_facility){
            $("#facilityCommon_all").prop("checked", true);
        }
        $("input[name^='facilityCommon']").click(function () {
            $("input[name^='facilityCommon']").each(function () {
                oneCheck($(this));
            })
        })
    });

    $(function () {
        var db_client_service = {{ sizeof($db_client_service)>0?sizeof($db_client_service):0 }}
        var type_service = {{ sizeof($type_service)>0?sizeof($type_service):0 }}
        if(db_client_service == type_service){
            $("#Service_all").prop("checked", true);
        }
        $("input[name^='Service']").click(function () {
            $("input[name^='Service']").each(function () {
                oneCheck_Service($(this));
            })
        })
    });

    $(function () {
        var db_client_torisit = {{ sizeof($db_client_torisit)>0?sizeof($db_client_torisit):0 }}
        var type_torisit = {{ sizeof($type_torisit)>0?sizeof($type_torisit):0 }}
        if(db_client_torisit == type_torisit){
            $("#Nearby_tourist_spots_all").prop("checked", true);
        }
        $("input[name^='Nearby_tourist_spots']").click(function () {
            $("input[name^='Nearby_tourist_spots']").each(function () {
                oneCheck_tourist($(this));
            })
        })
    });

    $(function () {
        $('#facilityCommon_all').click(function () {
            if($(this).is(":checked")==true){
                $("input[name^='facilityCommon']").each(function () {
                    $(this).prop("checked", true);
                })
            }else{
                $("input[name^='facilityCommon']").each(function () {
                    $(this).prop("checked", false);
                })
            }
        })
    })
    $(function () {
        $('#Service_all').click(function () {
            if($(this).is(":checked")==true){
                $("input[name^='Service']").each(function () {
                    $(this).prop("checked", true);
                })
            }else{
                $("input[name^='Service']").each(function () {
                    $(this).prop("checked", false);
                })
            }

        })
    })
    $(function () {
        $('#Nearby_tourist_spots_all').click(function () {
            if($(this).is(":checked")==true){
                $("input[name^='Nearby_tourist_spots']").each(function () {
                    $(this).prop("checked", true);
                })
            }else{
                $("input[name^='Nearby_tourist_spots']").each(function () {
                    $(this).prop("checked", false);
                })
            }

        })
    })
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#preview').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    $('#file').change(function(){
        readURL(this);
    });

    function newOpen(obj) {
        $('#preview3 img').attr("src",$(obj).attr("src"));
        $('#preview3').show();
        $('#close').click(function () {
            $('#preview3').hide();
        })
    };
</script>

<form method="post" name="frmUserClient" onSubmit="return frmUserClient('frmUserClient')" enctype="multipart/form-data">
    {{ csrf_field() }}
    <table class="default" cellpadding="0" cellspacing="0">
        <input type="hidden" name="check" value="{{$_SERVER['REQUEST_URI']}}">
        <tbody>
            <tr>
                <td class="test">업소명</td>
                <td><input name="clientName" id="userEmail" placeholder="업소명을 입력해주세요" class="form-control" value="{{ isset($userInfo)&&$userInfo->client_name!=""?$userInfo->client_name:"" }}" /></td>
            </tr>
            <tr>
                <td class="test">업소명(영어)</td>
                <td>
                    <input name="clientNameEn" id="clientNameEn" placeholder="숙박업체 이름(염문)을 입력하세요" type="text" class="form-control" value="{{ isset($userInfo)&&$userInfo->client_name_en!=""?$userInfo->client_name_en:"" }}" />
                </td>
            </tr>
            <tr>
                <td class="test">API토큰 값</td>
                <td>
                    {{isset($userInfo)&&$userInfo->api_token!=""?$userInfo->api_token:""}}
                </td>
            </tr>
            <tr>
                <td class="test">업소구분</td>
                @php $client_gubun = \App\Http\Controllers\Controller::getCode('client_gubun'); @endphp
                <td>
                    <select name="client_gubun" id="client_gubun" class="form-control">
                        @foreach($client_gubun as $k=>$c)
                            <option value="{{$c->code}}" {{isset($userInfo)&&$userInfo->client_gubun==$c->code?"selected":""}}>{{$c->name}}</option>
                        @endforeach
                    </select>
                </td>
            </tr>
            <tr>
                <td class="test">Email</td>
                <td><input name="email" id="userEmail" placeholder="이메일 주소를 입력하세요" type="text" class="form-control" value="{{ isset($user)&&$user->email!=""?$user->email:"" }}" /></td>
            </tr>
            <tr>
                <td class="test">대표자명</td>
                <td><input name="clientOwner" id="userEmail" placeholder="대표자명을 입력해주세요" class="form-control" value="{{ isset($userInfo)&&$userInfo->client_owner!=""?$userInfo->client_owner:"" }}" /></td>
            </tr>
            <tr>
                <td class="test">연락처</td>
                <td>
                    @php
                        $telephone = ["","",""];
                        if(isset($userInfo)&&$userInfo->client_tel!="") {
                            $telephone = explode("-",$userInfo->client_tel);
                        }
                    @endphp
                    @php $codeTel = \App\Http\Controllers\Controller::getCode('area_number'); @endphp
                    <select name="clientTel[]" id="clientTel1" class="form-control">
                        @foreach($codeTel as $c)
                            <option value="{{$c->code}}" {{$telephone[0]==$c->code?"selected":""}}>{{ $c->name }}</option>
                        @endforeach
                    </select>
                    <input name="clientTel[]" id="clientTel2" size="4" placeholder="전화번호를 입력하세요" type="text" class="form-control" value="{{$telephone[1]}}" />
                    <input name="clientTel[]" id="clientTel3" size="4" placeholder="전화번호를 입력하세요" type="text" class="form-control" value="{{$telephone[2]}}" />
                </td>
            </tr>
            <tr>
                <td class="test">대표연락처(발신)</td>
                <td>
                    @php
                        $cellphone = ["","",""];
                        if(isset($userInfo)&&$userInfo->client_hp!="") {
                            $cellphone = explode("-",$userInfo->client_hp);
                        }
                    @endphp
                    @php $codeHp = \App\Http\Controllers\Controller::getCode('phone_number'); @endphp
                    <select name="clientHp[]" id="clientHp1" class="form-control">
                        @foreach($codeHp as $c)
                            <option value="{{$c->code}}" {{$cellphone[0]==$c->code?"selected":""}}>{{ $c->name }}</option>
                        @endforeach
                    </select>
                    <input name="clientHp[]" id="clientHp2" size="4" placeholder="전화번호를 입력하세요" type="text" class="form-control" value="{{$cellphone[1]}}" />
                    <input name="clientHp[]" id="clientHp3" size="4" placeholder="전화번호를 입력하세요" type="text" class="form-control" value="{{$cellphone[2]}}" />
                </td>
            </tr>
            <tr>
                <td class="test">예약수신번호</td>
                <td>
                    @php
                        $cellphone_recevie = [];
                        if(isset($userInfo)&&$userInfo->clientHp_recevie!="") {
                            $cellphone_recevie = explode("-",$userInfo->clientHp_recevie);
                        }
                    @endphp
                    @php $codeHp = \App\Http\Controllers\Controller::getCode('phone_number'); @endphp
                    @for($i=0;$i<sizeof($cellphone_recevie); $i++)
                        @if($i%3!=0)
                            <input name="clientHp_recevie[]"  size="4" placeholder="전화번호를 입력하세요" type="text" class="form-control" value="{{$cellphone_recevie[$i]}}" />@if($i%3==2)<a style="color: black;" class="number_delete">X</a></label><br/>@endif
                        @elseif($i==0)
                            <label id="bb">
                            <select name="clientHp_recevie[]" id="clientHp1" class="form-control">
                                @foreach($codeHp as $c)
                                    <option value="{{$c->code}}" {{$cellphone_recevie[0]==$c->code?"selected":""}}>{{ $c->name }}</option>
                                @endforeach
                            </select>
                        @elseif($i%3==0)
                            <label id="bb">
                            <select name="clientHp_recevie[]" id="clientHp1" class="form-control">
                                @foreach($codeHp as $c)
                                    <option value="{{$c->code}}" {{$cellphone_recevie[$i]==$c->code?"selected":""}}>{{ $c->name }}</option>
                                @endforeach
                            </select>
                        @endif
                    @endfor
                    <a style="color: black;" id="number_add">추가</a>
                </td>
            </tr>
            <tr>
                <td class="test">주소</td>
                <td>
                    <input type="hidden" name="clientPost" id="clientPost" value="{{ isset($userInfo)&&$userInfo->client_post!=""?$userInfo->client_post:"" }}" />
                    <button class="mb-2 mr-2 btn btn-focus" type="button" onclick="search_postcode()">우편번호찾기</button>
                    <input name="clientAddrBasic" id="clientAddrBasic" placeholder="우편번호를 입력하세요" type="text" class="form-control" value="{{ isset($userInfo)&&$userInfo->client_addr_basic!=""?$userInfo->client_addr_basic:"" }}" />
                    <input name="clientAddrDetail" id="clientAddrDetail" placeholder="주소를 입력하세요" type="text" class="form-control" value="{{ isset($userInfo)&&$userInfo->client_addr_detail!=""?$userInfo->client_addr_detail:"" }}" />
                </td>
            </tr>
            <tr>
                <td class="test">결제 방법</td>
                <td>
                    @php
                        $client_fee = $userInfo->client_fee;
                        $arr = explode(',',$client_fee);
                    @endphp
                    <input type='checkbox' name="card" id="card" class="form-control" value="card" @for($i=0; $i<count($arr); $i++) @if($arr[$i]=="card") checked @endif @endfor  /> 카드결제
                    <input type='checkbox' name="reserve" id="reserve" class="form-control" value="reserve" @for($i=0; $i<count($arr); $i++) @if($arr[$i]=="reserve") checked @endif @endfor  /> 예약대행
                    <input type='checkbox' name="account" id="account" class="form-control" value="account" @for($i=0; $i<count($arr); $i++) @if($arr[$i]=="account") checked @endif @endfor  /> 무통장입금
                </td>
            </tr>
            <tr>
                <td class="test">카드 수수료</td>
                <td>
                    <input type="text" name="clientFeePayment" id="clientFeePayment" class="form-control" placeholder="FeePayment" value="{{ isset($userInfo)&&$userInfo->client_fee_payment!=""?$userInfo->client_fee_payment:"" }}" />
                    @php $fee_unit = \App\Http\Controllers\Controller::getCode('fee_order_unit'); @endphp
                    <select name="clientFeePaymentUnit" id="clientFeePaymentUnit" class="form-control">
                        @foreach($fee_unit as $f)
                            <option value="{{$f->code}}" {{isset($userInfo)&&$userInfo->client_fee_payment_unit==$f->code?"selected":""}}>{{ $f->name }}</option>
                        @endforeach
                    </select>
                </td>
            </tr>
            <tr>
                <td class="test">예약대행 수수료</td>
                <td>
                    <input type="text" name="clientFeeAgency" id="clientFeeAgency" class="form-control" placeholder="FeeAgency" value="{{ isset($userInfo)&&$userInfo->client_fee_agency!=""?$userInfo->client_fee_agency:"" }}" />
                    @php $fee_unit = \App\Http\Controllers\Controller::getCode('fee_order_unit'); @endphp
                    <select name="clientFeeAgencyUnit" id="clientFeeAgencyUnit" class="form-control">
                        @foreach($fee_unit as $f)
                            <option value="{{$f->code}}" {{isset($userInfo)&&$userInfo->client_fee_agency_unit==$f->code?"selected":""}}>{{ $f->name }}</option>
                        @endforeach
                    </select>
                </td>
            </tr>
            <tr>
                <td class="test">정산정보</td>
                <td>

                </td>
            </tr>
            <tr>
                <td class="test">업소형태</td>
                <td>
                    @php $clientType = \App\Http\Controllers\Controller::getCode('client_type'); @endphp
                    @foreach($clientType as $k => $c)
                        <div class="custom-radio custom-control custom-control-inline">
                            <input type="radio" name="codeType" id="clientType{{$k}}" class="custom-control-input" value="{{$c->code}}" {{ isset($userInfo)&&$userInfo->code_type==$c->code?"checked":"" }} />
                            <label class="custom-control-label" for="clientType{{$k}}">{{$c->name}}</label>
                        </div>
                    @endforeach
                </td>
            </tr>
            <tr>
                <td class="test">도메인</td>
                <td>
                    <input type="text" id="clientSiteUrl" name="clientSiteUrl" placeholder="도메인 주소를 입력하세요" class="form-control" value="{{ isset($userInfo)&&$userInfo->client_site_url!=""?$userInfo->client_site_url:"" }}" />
                </td>
            </tr>
            <tr>
                <td class="test">펜션사진</td>
                <td>
                    <p><a style="color: black;" class="img_add">추가</a></p>
                    @foreach($file as $k => $v)
                        <div style="border: 1px solid red;">
                            <p style="display: none"><input id="fileName" class="file_input_textbox" readonly value="{{isset($file)&&$v->file_name? $v->file_name :""}}"/></p>
                            <p><input type="hidden" id="file_name_{{$k}}" name="file_name[{{$k}}]" value="{{isset($file)&&$v->file_name? $v->file_name :""}}"></p>
                            <p><input type="file" class="{{$k}}" id="{{$k}}" name="file[]" value="{{isset($file)&&$v->file_name? $v->file_name :""}}" onchange="javascript:file_change(this.value);" /></p>
                            <p><a id="file_text">{{isset($file)&&$v->file_name? $v->file_name :""}}</a></p>
                            <p><img style="width: 50px; height: 50px;" onclick="newOpen(this)" id="preview" src="/data/{{isset($file)&&$v->path?$v->path:""}}" /></p>
                            <p><a id="img_label_{{$k}}" style="color: red;">삭제</a></p>
                        </div>
                    @endforeach
                    <div id="preview3" style="display:none; "><img src="" /><a id="close" style="color: red; font-size: 15px;">닫기</a></div>
                </td>
            </tr>

            <script>
                var ord = {{sizeof($file)}};
                $(function () {
                    var i =0;
                    $("input[name^='file']").each(function () {
                        var id = $(this).attr("id");
                        $("."+id).change(function () {
                            if($('#file_name_'+id+'').val() != $("#fileName").val()){
                                $('#file_name_'+id+'').val($("#fileName").val());
                            } else{
                                $('#file_name_'+id+'').val($("#fileName").val());
                            }
                        });
                    })
                });

                $(function () {
                    $("input[name^='file']").each(function () {
                        var id = $(this).attr("id");
                        $('#img_label_'+id).click(function () {
                            $('#file_name_'+id+'').val("");
                            $(this).parent().parent().hide();
                        });
                    });
                });
            </script>

            <tr>
                <td class="test">공용부대시설</td>
                @php
                    $type_facility = \App\Http\Controllers\Controller::getCode('type_facility');
                    $UserClientFacility = \App\Models\UserClientFacility::where('user_id',$id)->first();
                 @endphp
                @if($UserClientFacility!="")
                    <td class="test1"><input type="checkbox" id="facilityCommon_all"  value="Y">전체 선택</td>
                    <td>
                        @foreach($user_client_facility as $k=>$c)
                            @if(isset($c->code_facility))
                                <input type="checkbox" id="facilityCommon" name="facilityCommon[]" class="form-control" value="{{$c->code}}" {{isset($user_client_facility)&&$c->code_facility==$c->code?"checked":""}} />{{$c->code_name}}
                            @else
                                <input type="checkbox" id="facilityCommon" name="facilityCommon[]" class="form-control" value="{{$c->code}}" {{isset($user_client_facility)&&$c->code_facility==$c->code?"checked":""}} />{{$c->code_name}}
                            @endif
                        @endforeach
                    </td>
                @else
                    <td class="test1"><input type="checkbox" id="facilityCommon_all"  value="Y">전체 선택</td>
                    <td>
                        @foreach($type_facility as $k=>$c)
                            <input type="checkbox" id="facilityCommon" name="facilityCommon[]" class="form-control" value="{{$c->code}}" />{{$c->name}}
                        @endforeach
                    </td>
                @endif

            </tr>
            <tr>
                <td class="test">서비스</td>
                @php
                    $service = \App\Http\Controllers\Controller::getCode('service');
                    $UserClientService = \App\Models\UserClientService::where('user_id',$id)->first();

                @endphp
                @if($UserClientService!="")
                    <td class="test1"><input type="checkbox" id="Service_all" value="Y">전체 선택</td>
                    <td>
                        @foreach($user_client_service as $k=>$c)
                            @if(isset($c->code_facility))
                                <input type="checkbox" id="Service[]" name="Service[]" class="form-control" value="{{$c->code}}" {{isset($user_client_service)&&$c->code_facility==$c->code?"checked":""}} />{{$c->code_name}}
                            @else
                                <input type="checkbox" id="Service[]" name="Service[]" class="form-control" value="{{$c->code}}" {{isset($user_client_service)&&$c->code_facility==$c->code?"checked":""}} />{{$c->code_name}}
                            @endif
                        @endforeach
                    </td>
                @else
                    <td class="test1"><input type="checkbox" id="Service_all" value="Y">전체 선택</td>
                    <td>
                        @foreach($service as $k=>$c)
                            <input type="checkbox" id="Service[]" name="Service[]" class="form-control" value="{{$c->code}}" />{{$c->name}}
                        @endforeach
                    </td>
                @endif

            </tr>
            <tr>
                <td class="test">주변관광지</td>
                @php
                    $Nearby_tourist_spots = \App\Http\Controllers\Controller::getCode('Nearbytouristspots');
                    $UserClientTorisit = \App\Models\UserClientTorisit::where('user_id',$id)->first();
                @endphp
                @if($UserClientTorisit!="")
                    <td class="test1"><input type="checkbox" id="Nearby_tourist_spots_all" value="Y">전체 선택</td>
                    <td>
                        @foreach($user_client_torisit as $k=>$c)
                            @if(isset($c->code_facility))
                                <input type="checkbox" id="Nearby_tourist_spots[]" name="Nearby_tourist_spots[]" class="form-control" value="{{$c->code}}" {{isset($user_client_torisit)&&$c->code_facility==$c->code?"checked":""}} />{{$c->code_name}}
                            @else
                                <input type="checkbox" id="Nearby_tourist_spots[]" name="Nearby_tourist_spots[]" class="form-control" value="{{$c->code}}" {{isset($user_client_torisit)&&$c->code_facility==$c->code?"checked":""}} />{{$c->code_name}}
                            @endif
                        @endforeach
                    </td>
                @else
                    <td class="test1"><input type="checkbox" id="Nearby_tourist_spots_all" value="Y">전체 선택</td>
                    <td>
                    @foreach($Nearby_tourist_spots as $k=>$c)
                        <input type="checkbox" id="Nearby_tourist_spots[]" name="Nearby_tourist_spots[]" class="form-control" value="{{$c->code}}" />{{$c->name}}
                    @endforeach
                    </td>
                @endif

            </tr>
            <tr>
                <td class="test">검색 키워드</td>
                <td>
                    <input type="text" name="keyword" id="keyword" class="form-control" placeholder="검색키워드를 입력하세요" value="{{ isset($userInfo)&&$userInfo->keyword!=""?$userInfo->keyword:"" }}" />
                </td>
            </tr>
            <tr>
                <td class="test">숙박업체 체크인</td>
                <td>
                    <input type="time" name="clientCheckInStart" id="clientCheckIn" class="form-control" value="{{ isset($userInfo)&&$userInfo->client_check_in_start!=""?$userInfo->client_check_in_start:"" }}" /><br/>
                    <p>~</p>
                    <input type="time" name="clientCheckInEnd" id="clientCheckIn" class="form-control" value="{{ isset($userInfo)&&$userInfo->client_check_in_end!=""?$userInfo->client_check_in_end:"" }}" />
                </td>
            </tr>
            <tr>
                <td class="test">숙박업체 체크아웃</td>
                <td>
                    <input type="time" name="clientCheckOutStart" id="clientCheckOut" class="form-control" value="{{ isset($userInfo)&&$userInfo->client_check_out_start!=""?$userInfo->client_check_out_start:"" }}" /><br/>
                    <p>~</p>
                    <input type="time" name="clientCheckOutEnd" id="clientCheckOut" class="form-control" value="{{ isset($userInfo)&&$userInfo->client_check_out_end!=""?$userInfo->client_check_out_end:"" }}" />
                </td>
            </tr>
            <tr>
                <td class="test">가격노출기간</td>
                <td>
                    <input type="text" id="cnt_day" name="cnt_day" value="{{ isset($userInfo)?$userInfo->cnt_day:60 }}" data-min="{{ isset($userInfo)?(($userInfo->cnt_day-30)<1?1:$userInfo->cnt_day-30):30 }}" data-max="{{ isset($userInfo)?$userInfo->cnt_day+30:90 }}" />
{{--
                    <select name="cnt_day" id="cnt_day" class="form-control">
                        <option value="">::노출기간::</option>
                        <option value="60" {{ isset($userInfo)&&$userInfo->cnt_day==60?"selected":"" }}>60일</option>
                        <option value="90" {{ isset($userInfo)&&$userInfo->cnt_day==90?"selected":"" }}>90일</option>
                        <option value="120" {{ isset($userInfo)&&$userInfo->cnt_day==120?"selected":"" }}>120일</option>
                        <option value="150" {{ isset($userInfo)&&$userInfo->cnt_day==150?"selected":"" }}>150일</option>
                        <option value="180" {{ isset($userInfo)&&$userInfo->cnt_day==180?"selected":"" }}>180일</option>
                    </select>
--}}
                </td>
            </tr>
            <tr>
                <td class="test">스킨</td>
                <td>
                    @php $skinReserve = \App\Http\Controllers\Controller::getCode('skin_reserve'); @endphp
                    <select name="codeDesign" id="codeDesign" class="form-control">
                        <option value="">::스킨선택::</option>
                        @foreach($skinReserve as $s)
                            <option value="{{$s->code}}" {{ isset($userInfo)&&$userInfo->code_design==$s->code?"selected":"" }}>{{$s->name}}</option>
                        @endforeach
                    </select>
                </td>
            </tr>
            <tr>
                <td class="test">대행사(코드에서 자동화)</td>
                <td>
                    <select name="agency" id="agencySelect" class="form-control">
                        <option value="">::대행사선택::</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td class="test">서비스(코드에서 자동화)-객실의 부대시설과 차이에 대한 내용 확인 후 진행</td>
                <td>

                </td>
            </tr>
        </tbody>
    </table>
    <button class="mt-1 btn btn-primary" type="submit">등록</button>
</form>
