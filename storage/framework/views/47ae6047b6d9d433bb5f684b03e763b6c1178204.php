<?php $__env->startSection("title"); ?>숙박업체<?php $__env->stopSection(); ?>

<?php $__env->startSection("scripts"); ?>
    <script>

        $(function () {
            $("#facility_all").click(function () {
                if($(this).is(":checked")==true){
                    $("input[name^='facility']").each(function () {
                        $(this).prop("checked",true);
                    })
                }else if($(this).is(":checked")==false){
                    $("input[name^='facility']").each(function () {
                        $(this).prop("checked",false);
                    })
                }
            })
        })

        $(function () {
            $("input[name^='facility']").click(function () {
                $("input[name^='facility']").each(function () {
                    oneCheck($(this));
                })
            })
        })

        function oneCheck(a){
            if($(a).prop("checked")){
                var checkBoxLength = $("input[name^='facility']").length;
                var checkedLength = $("input[name^='facility']:checked").length;
                if(checkBoxLength==checkedLength){
                    $("#facility_all").prop("checked", true);
                }else{
                    $("#facility_all").prop("checked", false);
                }
            }else{
                $("#facility_all").prop("checked", false);
            }
        }

        var ord = <?php echo e(sizeof($room_name)>0?sizeof($room_name):0); ?>;
        $(function () {
            $('#num1').click(function () {
                var num = $('#num').val();
                for (var i = 0; i < num; i++) {
                    $('#num_plus').append(
                        "<div class=\"position-relative form-group\" style='border: 1px solid red;'>\n" +
                        "<div class=\"position-relative form-group\">\n" +
                        "<input type='hidden' name='room_num["+ord+"]' value=" + num + ">\n" +
                        "</div>\n" +
                        "<div class=\"position-relative form-group\">\n" +
                        "객실명\n" +
                        "<input type='text' name='room_name["+ord+"]'>\n" +
                        "</div>\n"+
                        "<div class=\"position-relative form-group\">\n" +
                        "실시간 예약\n" +
                        "<input type='radio' name='now["+ord+"]' value='Y'>판매 <input type='radio' name='now["+ord+"]' value='N'>판매안함\n" +
                        "</div>\n"+
                        "<div class=\"position-relative form-group\">\n" +
                        "온라인 판매 대행\n" +
                        "<input type='radio' name='online["+ord+"]' value='Y'>판매 <input type='radio' name='online["+ord+"]' value='N'>판매안함\n" +
                        "</div>\n"+
                        "<input type='button' class=\"mt-1 btn btn-primary\" name='delete["+ord+"]' value='삭제' onclick='$(this).parent().remove()'>\n" +
                        "</div>"
                    );
                    ord++;
                }
            });
        });
    </script>

    <script>
        var ord = <?php echo e(sizeof($room_name)>0?sizeof($room_name):0); ?>;
        $(function () {
            $('#num1').click(function () {
                var num = $('#num').val();
                for (var i = 0; i < num; i++) {
                    $('#num_plus1').append(
                        "<div class=\"position-relative form-group\" style='border: 1px solid red;'>\n" +
                        "<div class=\"position-relative form-group\">\n" +
                        "<input type='hidden' name='room_num["+ord+"]' value=" + num + ">\n" +
                        "</div>\n" +
                        "<div class=\"position-relative form-group\">\n" +
                        "객실명\n" +
                        "<input type='text' name='room_name["+ord+"]'>\n" +
                        "</div>\n"+
                        "<div class=\"position-relative form-group\">\n" +
                        "실시간 예약\n" +
                        "<input type='radio' name='now["+ord+"]' value='Y'>판매 <input type='radio' name='now["+ord+"]' value='N'>판매안함\n" +
                        "</div>\n"+
                        "<div class=\"position-relative form-group\">\n" +
                        "온라인 판매 대행\n" +
                        "<input type='radio' name='online["+ord+"]' value='Y'>판매 <input type='radio' name='online["+ord+"]' value='N'>판매안함\n" +
                        "</div>\n"+
                        "<input type='button'  name='delete["+ord+"]' value='삭제' onclick='$(this).parent().remove()'>\n" +
                        "</div>"
                    );
                    ord++;
                }
            });
        });
        $(function () {
            $('.room_add').click(function () {
                var size = <?php echo e(sizeof($file)>0?sizeof($file):0); ?>

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
            });
        })
        function file_change(file){
            var str=file.lastIndexOf("\\")+1;	//파일 마지막 "\" 루트의 길이 이후부터 글자를 잘라 파일명만 가져온다.
            file = file.substring(str, file.length);
            document.getElementById('fileName').value=file;
        }

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
<?php $__env->stopSection(); ?>

<?php $__env->startSection("styles"); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection("contents"); ?>
    <div class="row">
        <div class="main-card card" style="width:100%; ">
            <div class="card-body"><h5 class="card-title">Controls Types</h5>
                <?php
                    $path = $_SERVER["HTTP_HOST"];
                    $path = explode(".",$path);
                    $path = $path[0];
                ?>
                <?php if($path=="client"): ?>
                <form method="post" name="rooms" class="client_form" action="/info/room/view/save" enctype="multipart/form-data">
                <?php else: ?>
                    <form method="post" name="rooms" class="client_form" action="<?php echo e(url()->current()); ?>"  enctype="multipart/form-data">
                <?php endif; ?>
                    <?php echo e(csrf_field()); ?>

                    <input type="hidden" name="user_id" value="<?php echo e(isset($user_id)?$user_id:""); ?>" />
                    <input type="hidden" name="type_id" value="<?php echo e(isset($type_id)?$type_id:""); ?>" />
                    <div class="position-relative form-group">
                        <label for="clientName" class="" style="color: blue">그룹명</label>
                        <input type="text" name="type_name" id="type_name" placeholder="그룹명을 입력하세요" class="form-control" value="<?php echo e(isset($ClientRoom)?$ClientRooms[0]->type_name:""); ?>" />
                    </div>

                    <div class="position-relative form-group">
                        <label for="num" class="" style="color: blue">객실수</label>
                        <input type="text" name="num" id="num" placeholder="객실수 입력하세요" class="form-control" value="<?php echo e(isset($ClientRoom)?$ClientRooms[0]->num:""); ?>" /><a id="num1" name="num1" value="0">추가</a></td>
                    </div>
                    <?php if(!isset($room_name)): ?>
                        <div class="position-relative form-group">
                            <a id="num_plus" class="num_plus"></a>
                        </div>
                    <?php endif; ?>
                    <?php $__currentLoopData = $room_name; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t => $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="position-relative form-group" style="border: 1px solid red;">
                            <div class="position-relative form-group">
                                <input type="hidden" name="room_num[<?php echo e($t); ?>]" id="room_num[<?php echo e($t); ?>]" class="form-control" value='<?php echo e(isset($room_name)?$v->id:""); ?>' />
                            </div>
                            <div class="position-relative form-group">
                                <label for="room_name[<?php echo e($t); ?>]" class="">객실명</label>
                                <input type="text" name="room_name[<?php echo e($t); ?>]" id="room_name[<?php echo e($t); ?>]" placeholder="객실명을 입력하세요" class="form-control" value='<?php echo e(isset($room_name)?$v->room_name:""); ?>' />
                            </div>
                            <div class="position-relative form-group">
                                <label for="now[<?php echo e($t); ?>]" class="">실시간 예약</label>
                                <input type="radio" name='now[<?php echo e($t); ?>]' value='Y' <?php echo e(isset($v->flag_realtime)&&$v->flag_realtime=="Y"?"checked":""); ?> />판매
                                <input type='radio' name='now[<?php echo e($t); ?>]' value='N' <?php echo e(isset($v->flag_realtime)&&$v->flag_realtime=="N"?"checked":""); ?> />판매안함
                            </div>
                            <div class="position-relative form-group">
                                <label for="online[<?php echo e($t); ?>]" class="">온라인 판매 대행</label>
                                <input type='radio' name='online[<?php echo e($t); ?>]' value='Y' <?php echo e(isset($v->flag_online)&&$v->flag_online=="Y"?"checked":""); ?> />판매
                                <input type='radio' name='online[<?php echo e($t); ?>]' value='N' <?php echo e(isset($v->flag_online)&&$v->flag_online=="N"?"checked":""); ?> />판매안함
                                <input type='button' name='delete[<?php echo e($t); ?>]' value='삭제' onclick='$(this).parent().parent().remove()'>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php if(isset($room_name)): ?>
                        <div class="position-relative form-group">
                            <a id="num_plus1" class="num_plus1"></a>
                        </div>
                    <?php endif; ?>
                    <div class="position-relative form-group">
                        <label for="room_area" class="" style="color: blue">객실 크기</label>
                        <input type="text" name="room_area" id="room_area" placeholder="객실 크기를 입력하세요" class="form-control" value="<?php echo e(isset($ClientRoom)?$ClientRooms[0]->room_area:""); ?>" />
                    </div>

                    <div class="position-relative form-group">
                        <label for="room_shape" class="" style="color: blue;">객실 형태</label>
                    </div>

                    <div class="position-relative form-group">
                        <?php if($ClientRoom != ""): ?>
                            <input type="radio" name="room_shape" id="room_shape" value="Poisonous" <?php if(($ClientRooms[0]->room_shape)=="Poisonous"): ?>checked="checked"<?php endif; ?>>독채형
                            <input type="radio" name="room_shape" id="room_shape" value="Ventral" <?php if(($ClientRooms[0]->room_shape)=="Ventral"): ?>checked="checked"<?php endif; ?>>복층형
                            <input type="radio" name="room_shape" id="room_shape" value="One-room-type" <?php if(($ClientRooms[0]->room_shape)=="One-room-type"): ?>checked="checked"<?php endif; ?>>원룸형
                            <input type="radio" name="room_shape" id="room_shape" value="Detachable" <?php if(($ClientRooms[0]->room_shape)=="Detachable"): ?>checked="checked"<?php endif; ?>>분리형
                        <?php elseif($ClientRoom ==""): ?>
                            <input type="radio" name="room_shape" id="room_shape" value="Poisonous">독채형
                            <input type="radio" name="room_shape" id="room_shape" value="Ventral">복층형
                            <input type="radio" name="room_shape" id="room_shape" value="One-room-type">원룸형
                            <input type="radio" name="room_shape" id="room_shape" value="Detachable">분리형
                        <?php endif; ?>
                    </div>

                    <div class="position-relative form-group">
                        <label for="" class="" style="color: blue;">객실 내부</label>
                    </div>

                    <?php
                        $type_facility = \App\Http\Controllers\Controller::getCode('inner');
                    ?>
                    <div class="position-relative form-group" style="display: flex;">
                        <?php $__currentLoopData = $type_facility; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                            $name = $c->code;
                            $name = str_replace("inner_","",$name);
                            ?>
                            <label for="<?php echo e($c->code); ?>" class=""><?php echo e($c->name); ?></label>
                            <input type="text" name="<?php echo e($c->code); ?>" id="<?php echo e($c->code); ?>" class="form-control" style="width: 50px" size="2" value="<?php echo e(isset($ClientRoom)?$ClientRooms[0]->$name:""); ?>">개&nbsp;&nbsp;
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    <div class="position-relative form-group">
                        <label for="room_area" class="" style="color: blue;">객실 시설</label>
                    </div>
                    <div class="position-relative form-group">
                        <input type="checkbox" id="facility_all">모두선택
                        <?php
                            $type_facility = \App\Http\Controllers\Controller::getCode('type_facility');
                            $temp = explode(",",$ClientRoomFacilitys->fac);
                        ?>
                        <?php $__currentLoopData = $type_facility; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <input type="checkbox" name="facility[]" value="<?php echo e($c->code); ?>" <?php if($ClientRoomFacilitys->fac != ""): ?><?php echo e(in_array($c->code,$temp)?"checked":""); ?> <?php elseif($ClientRoomFacilitys->fac == ""): ?> checked="checked" <?php endif; ?>><?php echo e($c->name); ?>

                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    <div class="position-relative form-group">
                        <label for="etc" class="" style="color: blue;">특이 사항</label>
                        <input type="text" name="etc" id="etc" placeholder="특이사항을 입력하세요" class="form-control" value="<?php echo e(isset($ClientRoom)?$ClientRooms[0]->etc:""); ?>" />
                    </div>

                    <p><label for="img" class="" style="color: blue;">객실 사진 등록</label>&nbsp;&nbsp;<a class="room_add">추가</a></p>
                    <?php $__currentLoopData = $file; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="position-relative form-group" style="border: 1px solid red;">
                        <p style="display: none"><input id="fileName" class="file_input_textbox" readonly value="<?php echo e(isset($file)&&$v->file_name? $v->file_name :""); ?>"/></p>
                        <p><input type="hidden" id="file_name_<?php echo e($k); ?>" name="file_name[<?php echo e($k); ?>]" value="<?php echo e(isset($file)&&$v->file_name? $v->file_name :""); ?>"></p>
                        <p><input type="file" class="<?php echo e($k); ?>" id="<?php echo e($k); ?>" name="file[]" value="<?php echo e(isset($file)&&$v->file_name? $v->file_name :""); ?>" onchange="javascript:file_change(this.value);" /></p>
                        <p><a id="file_text"><?php echo e(isset($file)&&$v->file_name? $v->file_name :""); ?></a></p>
                        <p><img style="width: 50px; height: 50px;" onclick="newOpen(this)" id="preview" src="/data/<?php echo e(isset($file)&&$v->path?$v->path:""); ?>" /></p>
                        <p><a id="img_label_<?php echo e($k); ?>" style="color: red;">삭제</a></p>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <div id="preview3" style="display:none; "><img src="" /><a id="close" style="color: red; font-size: 15px;">닫기</a></div>

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

                    <div class="position-relative form-group">
                        <label for="room_cnt_max" class="" style="color: blue">최대 투숙 인원</label>
                        <input type="text" name="room_cnt_max" id="room_cnt_max" class="form-control" value="<?php echo e(isset($ClientRoom)?$ClientRooms[0]->room_cnt_max:""); ?>" />
                    </div>

                    <div class="position-relative form-group">
                        <label for="room_cnt_min" class="" style="color: blue">최소 투숙 인원</label>
                        <input type="text" name="room_cnt_min" id="room_cnt_min" class="form-control" value="<?php echo e(isset($ClientRoom)?$ClientRooms[0]->room_cnt_min:""); ?>" />
                    </div>

                    <div class="position-relative form-group">
                        <label for="room_cnt_basic" class="" style="color: blue">기본 투숙 인원</label>
                        <input type="text" name="room_cnt_basic" id="room_cnt_basic" class="form-control" value="<?php echo e(isset($ClientRoom)?$ClientRooms[0]->room_cnt_basic:""); ?>" />
                    </div>
                    <button class="mt-1 btn btn-primary">저장</button>
                </form>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>




<?php echo $__env->make("admin.pc.layout.basic", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/www/real_resarvation/resources/views/admin/pc/include/price/etc_view.blade.php ENDPATH**/ ?>