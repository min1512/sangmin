<?php $__env->startSection("title"); ?>할인 판매 추가/수정<?php $__env->stopSection(); ?>

<?php $__env->startSection("scripts"); ?>
<script>
    var ord = <?php echo e(sizeof($Autoset_Discount_Howmuch)>0?sizeof($Autoset_Discount_Howmuch):1); ?>;
    $(function () {
        $('#date_ban_add').click(function () {
            $('#date_ban_add_list').append(
                '<div class="inlist">' +
                '입실 <span>'+ord+'</span>일전 :' + "<input type='text' class='day' name='discount_howmuch[]'>&nbsp;&nbsp;<a class='change_char'></a><a class='mt-1 btn btn-primary season_delete' style='color: black;'>X</a>" +
                "</div>"
            );
            ord++;
            $(function () {
                $(".season_delete").click(function () {
                    var t = 1;
                    $(this).parent("div").remove();
                    $('#date_ban_add_list').find("div.inlist").each(function(){
                        $(this).find("span").text(t);
                        t++;
                    })
                    ord = t;
                });
            });
            var char = $('#char').val();
            var t_type = char.substr(0,1);
            $('.change_char').text(t_type);
        });
    });
    $(function () {
        $('#char').change(function () {
            var a = $(this).val();
            var t_type =a.substr(0,1);
            $('.change_char').text(t_type);
        });
        var char = $('#char').val();
        var t_type = char.substr(0,1);
        $('.change_char').text(t_type);
    });
    $(function () {
        $('#room_id_all').change(function () {
            if($(this).is(":checked")){
                console.log("YES"+":::");
                $("input[name^='room_id']").each(function () {
                    $(this).prop("checked",true);
                });
            }else{
                console.log("NO"+"::");
                $("input[name^='room_id']").each(function () {
                    $(this).prop("checked",false);
                });
            }
        });
        $('#day_all').change(function () {
            if($(this).is(":checked")){
                console.log("YES"+":::");
                $("input[name^='day']").each(function () {
                    $(this).prop("checked",true);
                });
            }else{
                console.log("NO"+"::");
                $("input[name^='day']").each(function () {
                    $(this).prop("checked",false);
                });
            }
        });
    });
    $(function () {
        $("input[name='term_check']:radio").change(function () {
            var term_check = $(this).val();
            console.log(term_check);
            if(term_check=="Y"){
                $('.term_check_date').show();
            }else{
                $('.term_check_date').hide();
            }
        });
    });
    $(function(){
        <?php if(!isset($Autoset_Discount)): ?> {
            $('.term_check_date').hide();
        }
        <?php else: ?> {
            <?php if(isset($Autoset_Discount) && $Autoset_Discount->term_check=="N"): ?>
            console.log(1);
            $(":input:radio[name=term_check][value=N]").prop("checked", true);
            $('.term_check_date').hide();
            <?php elseif(isset($Autoset_Discount) && $Autoset_Discount->term_check=="Y"): ?>
            console.log(2);
            $(":input:radio[name=term_check][value=Y]").prop("checked", true);
            $('.term_check_date').show();
            <?php else: ?>
            console.log(3);
            $(":input:radio[name=term_check][value=N]").prop("checked", true);
            $('.term_check_date').hide();
            <?php endif; ?>
        }
        <?php endif; ?>
    });
    $(function () {
        $('.btn-focus').click(function () {

            if($("input:radio[name='term_check']:checked").val()=="Y"){
                if($("input[name='start_date']").val()=="" || $("input[name='end_date']").val()=="" ) {
                    alert("기간을 입력하세요");
                    return false;
                }else if($("input[name='start_date']").val() > $("input[name='end_date']").val()){
                    alert("기간을 제대로 입력하세요");
                    return false;
                }else if($("input[name^='discount_howmuch']").val()==""){
                    alert("할인율을 입력 하세요");
                    return false;
                }
                else if( $("input:checkbox[name^='day']:checked").length<1){
                    alert("요일을 선택 해주세요");
                    return false;
                }
                else if( $("input:checkbox[name^='room_id']:checked").length<1){
                    alert("객실을 선택해주세요");
                    return false;
                }
            }

            if( $("input:checkbox[name^='day']:checked").length<1){
                alert("요일을 선택 해주세요");
                return false;
            }
            else if( $("input:checkbox[name^='room_id']:checked").length<1){
                alert("객실을 선택해주세요");
                return false;
            }
            else if($("input[name^='discount_howmuch']").val()==""){
                alert("할인율을 입력 하세요");
                return false;
            }
        });
        if($("input:checkbox[name^='day']:checked").length==7){
            $("input:checkbox[id='day_all']").prop("checked",true);
        }else{
            $("input:checkbox[id='day_all']").prop("checked",false);
        }
        <?php
            $ClientTypeRoomSize = sizeof($ClientTypeRoom);
        ?>
        if($("input:checkbox[name^='room_id']:checked").length==<?php echo e($ClientTypeRoomSize); ?>){
            $("input:checkbox[id='room_id_all']").prop("checked",true);
        }else{
            $("input:checkbox[id='room_id_all']").prop("checked",false);
        }

        $("input[name^='day']").click(function () {
            if($("input:checkbox[name^='day']:checked").length==7){
                $("input:checkbox[id='day_all']").prop("checked",true);
            }else{
                $("input:checkbox[id='day_all']").prop("checked",false);
            }
        })
        $("input[name^='room_id']").click(function () {
            if($("input:checkbox[name^='room_id']:checked").length==<?php echo e($ClientTypeRoomSize); ?>){
                $("input:checkbox[id='room_id_all']").prop("checked",true);
            }else{
                $("input:checkbox[id='room_id_all']").prop("checked",false);
            }
        })
    })
</script>

<?php $__env->stopSection(); ?>

<?php $__env->startSection("styles"); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection("contents"); ?>
    <div class="row">
        <div class="main-card mb-3 card" style="width:100%; ">
            <div class="card-body"><h5 class="card-title">Auto Discount List</h5>
                <?php
                    $path = $_SERVER["HTTP_HOST"];
                    $path = str_replace(".einet.co.kr","",$path);
                ?>
                <?php if($path=="client"): ?>
                    <form method='post' name='teewetwer' class='client_form' action='/info/auto_discount/save/<?php echo e(isset($did)?$did:""); ?>'>
                <?php elseif($path=="staff"): ?>
                        <form method='post' name='teewetwer' class='client_form' action='<?php echo e(url()->current()); ?>'>
                <?php endif; ?>
                    <?php echo e(csrf_field()); ?>

                    <div class="position-relative form-group">
                        <label for="clientName" class="" style="color: blue">기간설정</label>
                        <label for="clientName" class="" style="color: blue">상시</label>
                        <input type="radio" name="term_check" id="term_check" value="N" <?php if(isset($Autoset_Discount) && ($Autoset_Discount->term_check)=="N"): ?> checked <?php endif; ?>/>
                        <label for="clientName" class="" style="color: blue">기간</label>
                        <input type="radio" name="term_check" id="term_check" value="Y" <?php if(isset($Autoset_Discount) && ($Autoset_Discount->term_check)=="Y"): ?> checked <?php endif; ?>/>
                    </div>

                    <div class="term_check_date">
                        <input type="date" name="start_date" value="<?php echo e(isset($Autoset_Discount)&&($Autoset_Discount->discount_start)?$Autoset_Discount->discount_start:""); ?>"> ~ <input type="date" name="end_date" value="<?php echo e(isset($Autoset_Discount)&&($Autoset_Discount->discount_end)?$Autoset_Discount->discount_end:""); ?>">
                    </div>

                    <div class="position-relative form-group">
                        <label for="clientName" class="" style="color: blue">당일할인 달력에 노출</label>
                        <input type="radio" name="autoset_check" id="autoset_check" value="Y" <?php if(isset($Autoset_Discount) && ($Autoset_Discount->autoset_check)=="Y"): ?> checked <?php endif; ?>/>
                        <label for="clientName" class="" style="color: blue">당일할인 달력에 노출 안함</label>
                        <input type="radio" name="autoset_check" id="autoset_check" value="N" <?php if(isset($Autoset_Discount) && ($Autoset_Discount->autoset_check)=="N"): ?> checked <?php endif; ?>/>
                    </div>

                    <div class="position-relative form-group">
                        <label for="clientName" class="" style="color: blue">판매 요금 기준</label>
                        <select id="char" name="char">
                            <option value="%|discount">정률 할인(%)</option>
                            <option value="원|fixed">고정가 판매(원)</option>
                            <option value="원|discount">할인 판매(원)</option>
                        </select>
                    </div>
                    <?php if($isset != ""): ?>
                        <div class="position-relative form-group">
                            <div id="date_ban_add_list">
                                <label for="clientName" class="" style="color: blue">할인율</label><a id="date_ban_add">추가</a>
                                <?php $__currentLoopData = $Autoset_Discount_Howmuch; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if($k>=1): ?>
                                        <div class="inlist">
                                            입실 <span><?php echo e($k); ?></span> 일전 : <input type='text' class='day' name='discount_howmuch[]' value="<?php echo e(isset($v->autoset_discount_howmuch)?$v->autoset_discount_howmuch:""); ?>">&nbsp;&nbsp;<a class="change_char"></a><a class="mt-1 btn btn-primary season_delete" style='color: black;'>X</a>
                                        </div>
                                    <?php elseif($k==0): ?>
                                        <div>
                                            입실 당일 : <input type='text' class='day' name='discount_howmuch[]' value="<?php echo e(isset($v->autoset_discount_howmuch)?$v->autoset_discount_howmuch:""); ?>">&nbsp;<a class="change_char"></a>
                                        </div>
                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="position-relative form-group">
                            <div id="date_ban_add_list">
                                <label for="clientName" class="" style="color: blue">할인율</label><a id="date_ban_add">추가</a>
                                <div>
                                    입실 당일 : <input type='text' class='day' name='discount_howmuch[]'><a class="change_char"></a>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if($isset != ""): ?>
                        <?php
                            $date_array = explode(',',$Autoset_Discount->day);
                            $size_of = sizeof($date_array);
                        ?>
                        <div class="position-relative form-group">
                            <label for="clientName" class="" style="color: blue">할인 요일</label>
                            <input type="checkbox" id="day_all">요일 전체 선택
                            <input type='checkbox' class="day" name='day[]' value="0" <?php for($i=0; $i<$size_of; $i++): ?> <?php if(isset($date_array) && $date_array[$i]==0): ?> checked <?php endif; ?> <?php endfor; ?>>일
                            <input type='checkbox' class="day" name='day[]' value="1" <?php for($i=0; $i<$size_of; $i++): ?> <?php if(isset($date_array) && $date_array[$i]==1): ?> checked <?php endif; ?> <?php endfor; ?>>월
                            <input type='checkbox' class="day" name='day[]' value="2" <?php for($i=0; $i<$size_of; $i++): ?> <?php if(isset($date_array) && $date_array[$i]==2): ?> checked <?php endif; ?> <?php endfor; ?>>화
                            <input type='checkbox' class="day" name='day[]' value="3" <?php for($i=0; $i<$size_of; $i++): ?> <?php if(isset($date_array) && $date_array[$i]==3): ?> checked <?php endif; ?> <?php endfor; ?>>수
                            <input type='checkbox' class="day" name='day[]' value="4" <?php for($i=0; $i<$size_of; $i++): ?> <?php if(isset($date_array) && $date_array[$i]==4): ?> checked <?php endif; ?> <?php endfor; ?>>목
                            <input type='checkbox' class="day" name='day[]' value="5" <?php for($i=0; $i<$size_of; $i++): ?> <?php if(isset($date_array) && $date_array[$i]==5): ?> checked <?php endif; ?> <?php endfor; ?>>금
                            <input type='checkbox' class="day" name='day[]' value="6" <?php for($i=0; $i<$size_of; $i++): ?><?php if(isset($date_array) && $date_array[$i]==6): ?> checked <?php endif; ?> <?php endfor; ?>>토
                        </div>
                    <?php else: ?>
                        <div class="position-relative form-group">
                            <label for="clientName" class="" style="color: blue">할인 요일</label>
                            <input type="checkbox" id="day_all">요일 전체 선택
                            <input type='checkbox' class="day" name='day[]' value="0">일
                            <input type='checkbox' class="day" name='day[]' value="1">월
                            <input type='checkbox' class="day" name='day[]' value="2">화
                            <input type='checkbox' class="day" name='day[]' value="3">수
                            <input type='checkbox' class="day" name='day[]' value="4">목
                            <input type='checkbox' class="day" name='day[]' value="5">금
                            <input type='checkbox' class="day" name='day[]' value="6">토
                        </div>
                    <?php endif; ?>

                    <div class="position-relative form-group">
                        <input type="checkbox" id="room_id_all" value="Y">룸 전체 선택
                    </div>

                    <?php $__currentLoopData = $ClientTypeRoom; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="position-relative form-group">
                            <input type='checkbox' id="room_id_<?php echo e($k); ?>" data-idx="<?php echo e($k); ?>" name='room_id[<?php echo e($k); ?>]' value="<?php echo e($v->id); ?>" <?php echo e(isset($v->room_id)&& $v->room_id != null ? "checked" : ""); ?>><?php echo e($v->room_name); ?>&nbsp;&nbsp;
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <div><button class="mr-2 btn btn-focus" >저장</button></div>

                </form>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>



<?php echo $__env->make("admin.pc.layout.basic", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/www/real_resarvation/resources/views/admin/pc/price/autodiscount_insert.blade.php ENDPATH**/ ?>