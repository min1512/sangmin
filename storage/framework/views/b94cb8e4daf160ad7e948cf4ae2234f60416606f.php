<script src="https://t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>
<script>
    function search_postcode() {
        new daum.Postcode({
            oncomplete: function(data) {
                // 팝업에서 검색결과 항목을 클릭했을때 실행할 코드를 작성하는 부분.

                // 도로명 주소의 노출 규칙에 따라 주소를 표시한다.
                // 내려오는 변수가 값이 없는 경우엔 공백('')값을 가지므로, 이를 참고하여 분기 한다.
                var roadAddr = data.roadAddress; // 도로명 주소 변수
                var extraRoadAddr = ''; // 참고 항목 변수

                // 법정동명이 있을 경우 추가한다. (법정리는 제외)
                // 법정동의 경우 마지막 문자가 "동/로/가"로 끝난다.
                if(data.bname !== '' && /[동|로|가]$/g.test(data.bname)){
                    extraRoadAddr += data.bname;
                }
                // 건물명이 있고, 공동주택일 경우 추가한다.
                if(data.buildingName !== '' && data.apartment === 'Y'){
                    extraRoadAddr += (extraRoadAddr !== '' ? ', ' + data.buildingName : data.buildingName);
                }
                // 표시할 참고항목이 있을 경우, 괄호까지 추가한 최종 문자열을 만든다.
                if(extraRoadAddr !== ''){
                    extraRoadAddr = ' (' + extraRoadAddr + ')';
                }

                // 우편번호와 주소 정보를 해당 필드에 넣는다.
                document.getElementById('clientPost').value = data.zonecode;
                document.getElementById("clientAddrBasic").value = roadAddr;

                // 참고항목 문자열이 있을 경우 해당 필드에 넣는다.
                if(roadAddr !== ''){
                    document.getElementById("clientAddrDetail").value = extraRoadAddr;
                } else {
                    document.getElementById("clientAddrDetail").value = '';
                }
            }
        }).open();
    }
    <?php
        $codeHp = \App\Http\Controllers\Controller::getCode('phone_number');
    ?>
    $(function () {
        $('#number_add').click(function () {
            $(this).parent().append(
                                '<label id="bb">'+
                                '<br/>'+
                                '<select name="clientHp_recevie[]" id="clientHp1" class="form-control">' +
                                    <?php $__currentLoopData = $codeHp; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        '<option value="<?php echo e($c->code); ?>"><?php echo e($c->name); ?></option>' +
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
            var size = <?php echo e(sizeof($file)>0?sizeof($file):0); ?>

            $(this).parent().append(
                '<div style="border: 1px solid red;">'+
                '<p style="display: none"><input id="fileName" class="file_input_textbox" readonly value="값을입력하세요"/></p>'+
                '<input type="hidden" id="file_name_'+size+'" name="file_name['+size+']" value="">'+
                '<p><input type="file" id="'+size+'" class="'+size+'" name="file[]" onchange="javascript:file_change(this.value);"/></p>'+
                '<p><a  class="img_label_'+size+'" id="img_label_'+size+'" style="color: red;">삭제</a></p>'+
                '</div>'
            );
            console.log(size+"::");
            $('.img_label_'+size).click(function () {
                console.log(size+":::");
                $('#file_name_'+size+'').val("");
                $(this).parent().parent().hide();
            });

            $("input[name^='file']").click(function () {
                var i =0;
                $("input[name^='file']").each(function () {
                    var id = $(this).attr("id");
                    $('#img_label_'+id).click(function () {
                        console.log(id);
                        $('#file_name_'+id+'').val("");
                        $(this).parent().parent().hide();
                    });
                    console.log(id);
                    $("."+id).change(function () {
                        if($('#file_name_'+id+'').val() != $("#fileName").val()){
                            //hidden값( 저장된 값)
                            console.log($('#file_name_'+id+'').val());
                            //바로바로 변경된값
                            console.log($("#fileName").val());
                            console.log("변경");
                            $('#file_name_'+id+'').val($("#fileName").val());
                        } else{
                            //hidden값( 저장된 값)
                            console.log($('#file_name_'+id+'').val());
                            //바로바로 변경된값
                            console.log($("#fileName").val());
                            console.log("같음");
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
            console.log(checkBoxLength);
            console.log(checkedLength);
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
            console.log(checkBoxLength);
            console.log(checkedLength);
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
            console.log(checkBoxLength);
            console.log(checkedLength);
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
        var db_client_facility = <?php echo e(sizeof($db_client_facility)>0?sizeof($db_client_facility):0); ?>

        var type_facility = <?php echo e(sizeof($type_facility)>0?sizeof($type_facility):0); ?>

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
        var db_client_service = <?php echo e(sizeof($db_client_service)>0?sizeof($db_client_service):0); ?>

        var type_service = <?php echo e(sizeof($type_service)>0?sizeof($type_service):0); ?>

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
        var db_client_torisit = <?php echo e(sizeof($db_client_torisit)>0?sizeof($db_client_torisit):0); ?>

        var type_torisit = <?php echo e(sizeof($type_torisit)>0?sizeof($type_torisit):0); ?>

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
        console.log($(obj).attr("src"));
        $('#preview3 img').attr("src",$(obj).attr("src"));
        $('#preview3').show();
        $('#close').click(function () {
            $('#preview3').hide();
        })
    };

    $(function () {
        $("#dobule_young").change(function () {
            $("input[name='dobule_young']").prop("checked",true);
        });
        $("#young").change(function () {
            $("input[name='young']").prop("checked",true);
        });
        $("#child").change(function () {
            $("input[name='child']").prop("checked",true);
        });
        $(("input[name='dobule_young']")).click(function () {
            if($("input[name='dobule_young']").is(":checked")==false){
                $("#dobule_young").val("default");
            }
        })
        $(("input[name='young']")).click(function () {
            if($("input[name='young']").is(":checked")==false){
                $("#young").val("default");
            }
        })
        $(("input[name='child']")).click(function () {
            if($("input[name='child']").is(":checked")==false){
                $("#child").val("default");
            }
        })
    })

    $(function () {
        $(".btn-primary").click(function () {
            var dobule_young = $("#dobule_young").val();
            var young = $("#young").val();
            var child = $("#child").val();
            if(dobule_young != "default" && young != "default" && child != "default"){
                if(dobule_young >= young || dobule_young >= child){
                    alert("나이기준 값이 잘못 입력되었습니다.");
                    return false;
                }else if(young >= child){
                    alert("나이기준 값이 잘못 입력되었습니다.");
                    return false;
                }else{
                    return true;
                }
            }else if(($("input[name='young']").is(":checked")==true)==true){
                if(($("#young").val()=="default")){
                    alert("나이기준 값이 입력 되지 않았습니다.");
                    return false;
                }
            }else if(($("input[name='child']").is(":checked")==true)==true){
                if(($("#child").val()=="default")){
                    alert("나이기준 값이 입력 되지 않았습니다.");
                    return false;
                }
            }else if(($("input[name='adult']").is(":checked")==true)==true){
                if(($("#adult").val()=="default")){
                    alert("나이기준 값이 입력 되지 않았습니다.");
                    return false;
                }
            }else{
                return true;
            }
        })
    })




</script>

<form method="post" action="<?php echo e(route('user.client.save',['id'=>$id])); ?>" enctype="multipart/form-data">
    <?php echo e(csrf_field()); ?>

    <table class="default" cellpadding="0" cellspacing="0">
        <input type="hidden" name="check" value="<?php echo e($_SERVER['REQUEST_URI']); ?>">
        <thead>
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        </thead>
        <tbody>
            <tr>
                <td class="test">업소명</td>
                <td><input name="clientName" id="userEmail" placeholder="업소명을 입력해주세요" class="form-control" value="<?php echo e(isset($userInfo)&&$userInfo->client_name!=""?$userInfo->client_name:""); ?>" /></td>
            </tr>
            <tr>
                <td class="test">업소명(영어)</td>
                <td>
                    <input name="clientNameEn" id="clientNameEn" placeholder="숙박업체 이름(염문)을 입력하세요" type="text" class="form-control" value="<?php echo e(isset($userInfo)&&$userInfo->client_name_en!=""?$userInfo->client_name_en:""); ?>" />
                </td>
            </tr>
            <tr>
                <td class="test">API토큰 값</td>
                <td>
                    <?php echo e(isset($userInfo)&&$userInfo->api_token!=""?$userInfo->api_token:""); ?>

                </td>
            </tr>
            <tr>
                <td class="test">업소구분</td>
                <?php $client_gubun = \App\Http\Controllers\Controller::getCode('client_gubun'); ?>
                <td>
                    <select name="client_gubun" id="client_gubun" class="form-control">
                        <?php $__currentLoopData = $client_gubun; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($c->code); ?>" <?php echo e(isset($userInfo)&&$userInfo->client_gubun==$c->code?"selected":""); ?>><?php echo e($c->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td class="test">Email</td>
                <td><input name="email" id="userEmail" placeholder="이메일 주소를 입력하세요" type="text" class="form-control" value="<?php echo e(isset($user)&&$user->email!=""?$user->email:""); ?>" /></td>
            </tr>
            <tr>
                <td class="test">대표자명</td>
                <td><input name="clientOwner" id="userEmail" placeholder="대표자명을 입력해주세요" class="form-control" value="<?php echo e(isset($userInfo)&&$userInfo->client_owner!=""?$userInfo->client_owner:""); ?>" /></td>
            </tr>
            <tr>
                <td class="test">연락처</td>
                <td>
                    <?php
                        $telephone = ["","",""];
                        if(isset($userInfo)&&$userInfo->client_tel!="") {
                            $telephone = explode("-",$userInfo->client_tel);
                        }
                    ?>
                    <?php $codeTel = \App\Http\Controllers\Controller::getCode('area_number'); ?>
                    <select name="clientTel[]" id="clientTel1" class="form-control">
                        <?php $__currentLoopData = $codeTel; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($c->code); ?>" <?php echo e($telephone[0]==$c->code?"selected":""); ?>><?php echo e($c->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <input name="clientTel[]" id="clientTel2" size="4" placeholder="전화번호를 입력하세요" type="text" class="form-control" value="<?php echo e($telephone[1]); ?>" />
                    <input name="clientTel[]" id="clientTel3" size="4" placeholder="전화번호를 입력하세요" type="text" class="form-control" value="<?php echo e($telephone[2]); ?>" />
                </td>
            </tr>
            <tr>
                <td class="test">대표연락처(발신)</td>
                <td>
                    <?php
                        $cellphone = ["","",""];
                        if(isset($userInfo)&&$userInfo->client_hp!="") {
                            $cellphone = explode("-",$userInfo->client_hp);
                        }
                    ?>
                    <?php $codeHp = \App\Http\Controllers\Controller::getCode('phone_number'); ?>
                    <select name="clientHp[]" id="clientHp1" class="form-control">
                        <?php $__currentLoopData = $codeHp; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($c->code); ?>" <?php echo e($cellphone[0]==$c->code?"selected":""); ?>><?php echo e($c->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <input name="clientHp[]" id="clientHp2" size="4" placeholder="전화번호를 입력하세요" type="text" class="form-control" value="<?php echo e($cellphone[1]); ?>" />
                    <input name="clientHp[]" id="clientHp3" size="4" placeholder="전화번호를 입력하세요" type="text" class="form-control" value="<?php echo e($cellphone[2]); ?>" />
                </td>
            </tr>
            <tr>
                <td class="test">예약수신번호</td>
                <td>
                    <?php
                        $cellphone_recevie = [];
                        if(isset($userInfo)&&$userInfo->clientHp_recevie!="") {
                            $cellphone_recevie = explode("-",$userInfo->clientHp_recevie);
                        }
                    ?>
                    <?php $codeHp = \App\Http\Controllers\Controller::getCode('phone_number'); ?>
                    <?php for($i=0;$i<sizeof($cellphone_recevie); $i++): ?>
                        <?php if($i%3!=0): ?>
                            <input name="clientHp_recevie[]"  size="4" placeholder="전화번호를 입력하세요" type="text" class="form-control" value="<?php echo e($cellphone_recevie[$i]); ?>" /><?php if($i%3==2): ?><a style="color: black;" class="number_delete">X</a></label><br/><?php endif; ?>
                        <?php elseif($i==0): ?>
                            <label id="bb">
                            <select name="clientHp_recevie[]" id="clientHp1" class="form-control">
                                <?php $__currentLoopData = $codeHp; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($c->code); ?>" <?php echo e($cellphone_recevie[0]==$c->code?"selected":""); ?>><?php echo e($c->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        <?php elseif($i%3==0): ?>
                            <label id="bb">
                            <select name="clientHp_recevie[]" id="clientHp1" class="form-control">
                                <?php $__currentLoopData = $codeHp; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($c->code); ?>" <?php echo e($cellphone_recevie[$i]==$c->code?"selected":""); ?>><?php echo e($c->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        <?php endif; ?>
                    <?php endfor; ?>
                    <a style="color: black;" id="number_add">추가</a>
                </td>
            </tr>
            <tr>
                <td class="test">주소</td>
                <td>
                    <input type="hidden" name="clientPost" id="clientPost" value="<?php echo e(isset($userInfo)&&$userInfo->client_post!=""?$userInfo->client_post:""); ?>" />
                    <button class="mb-2 mr-2 btn btn-focus" type="button" onclick="search_postcode()">우편번호찾기</button>
                    <input name="clientAddrBasic" id="clientAddrBasic" placeholder="우편번호를 입력하세요" type="text" class="form-control" value="<?php echo e(isset($userInfo)&&$userInfo->client_addr_basic!=""?$userInfo->client_addr_basic:""); ?>" />
                    <input name="clientAddrDetail" id="clientAddrDetail" placeholder="주소를 입력하세요" type="text" class="form-control" value="<?php echo e(isset($userInfo)&&$userInfo->client_addr_detail!=""?$userInfo->client_addr_detail:""); ?>" />
                </td>
            </tr>
            <tr>
                <td class="test">결제 방법</td>
                <td>
                    <?php
                        $client_fee = $userInfo->client_fee;
                        $arr = explode(',',$client_fee);
                    ?>
                    <input type='checkbox' name="card" id="card" class="form-control" value="card" <?php for($i=0; $i<count($arr); $i++): ?> <?php if($arr[$i]=="card"): ?> checked <?php endif; ?> <?php endfor; ?>  /> 카드결제
                    <input type='checkbox' name="reserve" id="reserve" class="form-control" value="reserve" <?php for($i=0; $i<count($arr); $i++): ?> <?php if($arr[$i]=="reserve"): ?> checked <?php endif; ?> <?php endfor; ?>  /> 예약대행
                    <input type='checkbox' name="account" id="account" class="form-control" value="account" <?php for($i=0; $i<count($arr); $i++): ?> <?php if($arr[$i]=="account"): ?> checked <?php endif; ?> <?php endfor; ?>  /> 무통장입금
                </td>
            </tr>
            <tr>
                <td class="test">카드 수수료</td>
                <td>
                    <input type="text" name="clientFeePayment" id="clientFeePayment" class="form-control" placeholder="FeePayment" value="<?php echo e(isset($userInfo)&&$userInfo->client_fee_payment!=""?$userInfo->client_fee_payment:""); ?>" />
                    <?php $fee_unit = \App\Http\Controllers\Controller::getCode('fee_order_unit'); ?>
                    <select name="clientFeePaymentUnit" id="clientFeePaymentUnit" class="form-control">
                        <?php $__currentLoopData = $fee_unit; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $f): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($f->code); ?>" <?php echo e(isset($userInfo)&&$userInfo->client_fee_payment_unit==$f->code?"selected":""); ?>><?php echo e($f->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td class="test">예약대행 수수료</td>
                <td>
                    <input type="text" name="clientFeeAgency" id="clientFeeAgency" class="form-control" placeholder="FeeAgency" value="<?php echo e(isset($userInfo)&&$userInfo->client_fee_agency!=""?$userInfo->client_fee_agency:""); ?>" />
                    <?php $fee_unit = \App\Http\Controllers\Controller::getCode('fee_order_unit'); ?>
                    <select name="clientFeeAgencyUnit" id="clientFeeAgencyUnit" class="form-control">
                        <?php $__currentLoopData = $fee_unit; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $f): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($f->code); ?>" <?php echo e(isset($userInfo)&&$userInfo->client_fee_agency_unit==$f->code?"selected":""); ?>><?php echo e($f->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                    <?php $clientType = \App\Http\Controllers\Controller::getCode('client_type'); ?>
                    <?php $__currentLoopData = $clientType; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="custom-radio custom-control custom-control-inline">
                            <input type="radio" name="codeType" id="clientType<?php echo e($k); ?>" class="custom-control-input" value="<?php echo e($c->code); ?>" <?php echo e(isset($userInfo)&&$userInfo->code_type==$c->code?"checked":""); ?> />
                            <label class="custom-control-label" for="clientType<?php echo e($k); ?>"><?php echo e($c->name); ?></label>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </td>
            </tr>
            <tr>
                <td class="test">도메인</td>
                <td>
                    <input type="text" id="clientSiteUrl" name="clientSiteUrl" placeholder="도메인 주소를 입력하세요" class="form-control" value="<?php echo e(isset($userInfo)&&$userInfo->client_site_url!=""?$userInfo->client_site_url:""); ?>" />
                </td>
            </tr>
            <tr>
                <td class="test">펜션사진</td>
                <td>
                    <p><a style="color: black;" class="img_add">추가</a></p>
                    <?php $__currentLoopData = $file; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div style="border: 1px solid red;">
                            <p style="display: none"><input id="fileName" class="file_input_textbox" readonly value="<?php echo e(isset($file)&&$v->file_name? $v->file_name :""); ?>"/></p>
                            <p><input type="hidden" id="file_name_<?php echo e($k); ?>" name="file_name[<?php echo e($k); ?>]" value="<?php echo e(isset($file)&&$v->file_name? $v->file_name :""); ?>"></p>
                            <p><input type="file" class="<?php echo e($k); ?>" id="<?php echo e($k); ?>" name="file[]" value="<?php echo e(isset($file)&&$v->file_name? $v->file_name :""); ?>" onchange="javascript:file_change(this.value);" /></p>
                            <p><a id="file_text"><?php echo e(isset($file)&&$v->file_name? $v->file_name :""); ?></a></p>
                            <p><img style="width: 50px; height: 50px;" onclick="newOpen(this)" id="preview" src="/data/<?php echo e(isset($file)&&$v->path?$v->path:""); ?>" /></p>
                            <p><a id="img_label_<?php echo e($k); ?>" style="color: red;">삭제</a></p>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <div id="preview3" style="display:none; "><img src="" /><a id="close" style="color: red; font-size: 15px;">닫기</a></div>
                </td>
            </tr>

            <script>
                var ord = <?php echo e(sizeof($file)); ?>;
                $(function () {
                    var i =0;
                    $("input[name^='file']").each(function () {
                        var id = $(this).attr("id");
                        $("."+id).change(function () {
                            if($('#file_name_'+id+'').val() != $("#fileName").val()){
                                //hidden값( 저장된 값)
                                console.log($('#file_name_'+id+'').val());
                                //바로바로 변경된값
                                console.log($("#fileName").val());
                                console.log("변경");
                                $('#file_name_'+id+'').val($("#fileName").val());
                            } else{
                                //hidden값( 저장된 값)
                                console.log($('#file_name_'+id+'').val());
                                //바로바로 변경된값
                                console.log($("#fileName").val());
                                console.log("같음");
                                $('#file_name_'+id+'').val($("#fileName").val());
                            }
                        });
                    })
                });

                $(function () {
                    $("input[name^='file']").each(function () {
                        var id = $(this).attr("id");
                        $('#img_label_'+id).click(function () {
                            console.log(id);
                            $('#file_name_'+id+'').val("");
                            $(this).parent().parent().hide();
                        });
                    });
                });
            </script>

            <tr>
                <td class="test">공용부대시설</td>
                <?php
                    $type_facility = \App\Http\Controllers\Controller::getCode('type_facility');
                    $UserClientFacility = \App\Models\UserClientFacility::where('user_id',$id)->first();
                 ?>
                <?php if($UserClientFacility!=""): ?>
                    <td class="test1"><input type="checkbox" id="facilityCommon_all"  value="Y">전체 선택</td>
                    <td class="test2">
                        <?php $__currentLoopData = $user_client_facility; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if(isset($c->code_facility)): ?>
                                <input type="checkbox" id="facilityCommon" name="facilityCommon[]" class="form-control" value="<?php echo e($c->code); ?>" <?php echo e(isset($user_client_facility)&&$c->code_facility==$c->code?"checked":""); ?> /><?php echo e($c->code_name); ?>

                            <?php else: ?>
                                <input type="checkbox" id="facilityCommon" name="facilityCommon[]" class="form-control" value="<?php echo e($c->code); ?>" <?php echo e(isset($user_client_facility)&&$c->code_facility==$c->code?"checked":""); ?> /><?php echo e($c->code_name); ?>

                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </td>
                <?php else: ?>
                    <td class="test1"><input type="checkbox" id="facilityCommon_all"  value="Y">전체 선택</td>
                    <td class="test2">
                        <?php $__currentLoopData = $type_facility; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <input type="checkbox" id="facilityCommon" name="facilityCommon[]" class="form-control" value="<?php echo e($c->code); ?>" /><?php echo e($c->name); ?>

                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </td>
                <?php endif; ?>

            </tr>
            <tr>
                <td class="test">서비스</td>
                <?php
                    $service = \App\Http\Controllers\Controller::getCode('service');
                    $UserClientService = \App\Models\UserClientService::where('user_id',$id)->first();

                ?>
                <?php if($UserClientService!=""): ?>
                    <td class="test1"><input type="checkbox" id="Service_all" value="Y">전체 선택</td>
                    <td class="test2">
                        <?php $__currentLoopData = $user_client_service; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if(isset($c->code_facility)): ?>
                                <input type="checkbox" id="Service[]" name="Service[]" class="form-control" value="<?php echo e($c->code); ?>" <?php echo e(isset($user_client_service)&&$c->code_facility==$c->code?"checked":""); ?> /><?php echo e($c->code_name); ?>

                            <?php else: ?>
                                <input type="checkbox" id="Service[]" name="Service[]" class="form-control" value="<?php echo e($c->code); ?>" <?php echo e(isset($user_client_service)&&$c->code_facility==$c->code?"checked":""); ?> /><?php echo e($c->code_name); ?>

                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </td>
                <?php else: ?>
                    <td class="test1"><input type="checkbox" id="Service_all" value="Y">전체 선택</td>
                    <td class="test2">
                        <?php $__currentLoopData = $service; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <input type="checkbox" id="Service[]" name="Service[]" class="form-control" value="<?php echo e($c->code); ?>" /><?php echo e($c->name); ?>

                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </td>
                <?php endif; ?>

            </tr>
            <tr>
                <td class="test">주변관광지</td>
                <?php
                    $Nearby_tourist_spots = \App\Http\Controllers\Controller::getCode('Nearbytouristspots');
                    $UserClientTorisit = \App\Models\UserClientTorisit::where('user_id',$id)->first();
                ?>
                <?php if($UserClientTorisit!=""): ?>
                    <td class="test1"><input type="checkbox" id="Nearby_tourist_spots_all" value="Y">전체 선택</td>
                    <td class="test2">
                        <?php $__currentLoopData = $user_client_torisit; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if(isset($c->code_facility)): ?>
                                <input type="checkbox" id="Nearby_tourist_spots[]" name="Nearby_tourist_spots[]" class="form-control" value="<?php echo e($c->code); ?>" <?php echo e(isset($user_client_torisit)&&$c->code_facility==$c->code?"checked":""); ?> /><?php echo e($c->code_name); ?>

                            <?php else: ?>
                                <input type="checkbox" id="Nearby_tourist_spots[]" name="Nearby_tourist_spots[]" class="form-control" value="<?php echo e($c->code); ?>" <?php echo e(isset($user_client_torisit)&&$c->code_facility==$c->code?"checked":""); ?> /><?php echo e($c->code_name); ?>

                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </td>
                <?php else: ?>
                    <td class="test1"><input type="checkbox" id="Nearby_tourist_spots_all" value="Y">전체 선택</td>
                    <td class="test2">
                    <?php $__currentLoopData = $Nearby_tourist_spots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <input type="checkbox" id="Nearby_tourist_spots[]" name="Nearby_tourist_spots[]" class="form-control" value="<?php echo e($c->code); ?>" /><?php echo e($c->name); ?>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </td>
                <?php endif; ?>

            </tr>
            <tr>
                <td class="test">검색 키워드</td>
                <td>
                    <input type="text" name="keyword" id="keyword" class="form-control" placeholder="검색키워드를 입력하세요" value="<?php echo e(isset($userInfo)&&$userInfo->keyword!=""?$userInfo->keyword:""); ?>" />
                </td>
            </tr>
            <tr>
                <td class="test">숙박업체 체크인</td>
                <td>
                    <input type="time" name="clientCheckInStart" id="clientCheckIn" class="form-control" value="<?php echo e(isset($userInfo)&&$userInfo->client_check_in_start!=""?$userInfo->client_check_in_start:""); ?>" /><br/>
                    <p>~</p>
                    <input type="time" name="clientCheckInEnd" id="clientCheckIn" class="form-control" value="<?php echo e(isset($userInfo)&&$userInfo->client_check_in_end!=""?$userInfo->client_check_in_end:""); ?>" />
                </td>
            </tr>
            <tr>
                <td class="test">숙박업체 체크아웃</td>
                <td>
                    <input type="time" name="clientCheckOutStart" id="clientCheckOut" class="form-control" value="<?php echo e(isset($userInfo)&&$userInfo->client_check_out_start!=""?$userInfo->client_check_out_start:""); ?>" /><br/>
                    <p>~</p>
                    <input type="time" name="clientCheckOutEnd" id="clientCheckOut" class="form-control" value="<?php echo e(isset($userInfo)&&$userInfo->client_check_out_end!=""?$userInfo->client_check_out_end:""); ?>" />
                </td>
            </tr>
            <tr>
                <td class="test">스킨</td>
                <td>
                    <?php $skinReserve = \App\Http\Controllers\Controller::getCode('skin_reserve'); ?>
                    <select name="codeDesign" id="codeDesign" class="form-control">
                        <option value="">::스킨선택::</option>
                        <?php $__currentLoopData = $skinReserve; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($s->code); ?>" <?php echo e(isset($userInfo)&&$userInfo->code_design==$s->code?"selected":""); ?>><?php echo e($s->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td class="test">나이 기준(숙박 가능 한지 불가 한지)</td>
                <td>
                    <input type="checkbox" name="dobule_young" value="Y"<?php if($userInfo->dobule_young=="Y"): ?>checked <?php endif; ?> />영유아
                </td>
                <td>
                    <input type="checkbox" name="young" value="Y"<?php if($userInfo->young=="Y"): ?>checked <?php endif; ?> />유아
                </td>
                <td>
                    <input type="checkbox" name="child" value="Y"<?php if($userInfo->child=="Y"): ?>checked <?php endif; ?> />아이
                </td>
                <td>
                    <input type="checkbox" name="adult" checked="checked" value="Y" <?php if($userInfo->adult=="Y"): ?>checked <?php endif; ?> />성인
                </td>
            </tr>
            <tr>
                <td>
                </td>
                <td>
                    <select name="sleep_check_value" class="form-control">
                        <option value="0">0개월</option>
                    </select>
                    ~
                    <select name="sleep_check_value_dobule_young" class="form-control" id="dobule_young">
                        <option value="default" <?php echo e(isset($userInfo)&&$userInfo->sleep_check_value_dobule_young=="default"?"selected":""); ?>>선택해주세요</option>
                        <?php for($i=0; $i<=36; $i++): ?>
                            <option value="<?php echo e($i); ?>" <?php echo e(isset($userInfo)&&$userInfo->sleep_check_value_dobule_young==$i?"selected":""); ?>><?php echo e($i); ?>개월</option>
                        <?php endfor; ?>
                    </select>
                </td>
                <td>
                    ~
                    <select name="sleep_check_value_young" class="form-control" id="young">
                        <option value="default" <?php echo e(isset($userInfo)&&$userInfo->sleep_check_value_young=="default"?"selected":""); ?>>선택해주세요</option>
                        <?php for($i=1; $i<=36; $i++): ?>
                            <option value="<?php echo e($i); ?>" <?php echo e(isset($userInfo)&&$userInfo->sleep_check_value_young==$i?"selected":""); ?>><?php echo e($i); ?>개월</option>
                        <?php endfor; ?>
                    </select>
                </td>
                <td>
                    ~
                    <select name="sleep_check_value_child" class="form-control" id="child">
                        <option value="default" <?php echo e(isset($userInfo)&&$userInfo->sleep_check_value_child=="default"?"selected":""); ?>>선택해주세요</option>
                        <?php for($i=1; $i<=36; $i++): ?>
                            <option value="<?php echo e($i); ?>" <?php echo e(isset($userInfo)&&$userInfo->sleep_check_value_child==$i?"selected":""); ?>><?php echo e($i); ?>개월</option>
                        <?php endfor; ?>
                    </select>
                </td>
                <td>
                    ~
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
<?php /**PATH /home/www/real_resarvation/resources/views/admin/pc/include/client_info.blade.php ENDPATH**/ ?>