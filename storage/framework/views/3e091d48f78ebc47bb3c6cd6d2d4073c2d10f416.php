

<?php $__env->startSection("title"); ?>할인 판매 추가/수정<?php $__env->stopSection(); ?>

<?php $__env->startSection("scripts"); ?>
    <script>
        $(function () {
            <?php if(!isset($AdditionEtcPrice)): ?>{
                $('.right_now').hide();
            }
            <?php else: ?>{
                <?php if(isset($AdditionEtcPrice)&&$AdditionEtcPrice->etc_name==""): ?>{
                    $('.right_now').hide();
                }<?php elseif(isset($AdditionEtcPrice)&&$AdditionEtcPrice->etc_name!=""): ?>{
                    $('.right_now').show();
                    $(":input:radio[name=etc_name][value=Right]").prop("checked", true);
                }
                <?php endif; ?>
            }
            <?php endif; ?>
        })

        $(function () {
            $("input[name^='etc_name']").change(function () {
                console.log($(this).val());
                if($(this).val() =="Right"){
                    $('.right_now').show();
                    $('.right_now').html("<div class='position-relative form-group'>" +
                        "<label for='clientName'style='color: blue'>직접입력</label>" +
                        "<input type='text' name='right_now_value'>" +
                        "</div>");
                }else{
                    $('.right_now').hide();
                }
            });
            $('#room_id_all').change(function () {
                console.log($(this).val());
                if($(this).is(":checked")){
                    $("input[name^='room_id']").each(function () {
                        $(this).prop("checked",true);
                    });
                }else{
                    $("input[name^='room_id']").each(function () {
                        $(this).prop("checked",false);
                    });
                }
            })
        });
    </script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection("styles"); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection("contents"); ?>
    <div class="row">
        <div class="main-card mb-3 card" style="width:100%; ">
            <div class="card-body"><h5 class="card-title">Discount List</h5>
                <?php
                    $path = $_SERVER["HTTP_HOST"];
                    $path = str_replace(".einet.co.kr","",$path);
                ?>
                <?php if($path=="client"): ?>
                <form method='post' name='teewetwer' class='client_form' action='/info/etc/save/<?php echo e(isset($did)?$did:""); ?>'>
                <?php else: ?>
                    <form method='post' name='teewetwer' class='client_form' action='<?php echo e(url()->current()); ?>'>
                <?php endif; ?>
                    <?php echo e(csrf_field()); ?>

                    <?php if($isset == ""): ?>
                        <div class="position-relative form-group">
                            <label for="clientName" class="" style="color: blue">추가이용명</label>
                            <?php $__currentLoopData = $Code; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <input type="radio" name="etc_name" value="<?php echo e(isset($Code)?$v->code:""); ?>"/><?php echo e($v->code_name); ?>

                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <input type="radio" name="etc_name" value="Right"/>직접입력
                        </div>
                    <?php else: ?>
                        <div class="position-relative form-group">
                            <label for="clientName" class="" style="color: blue">추가이용명</label>
                            <?php $__currentLoopData = $Code; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <input type="radio" name="etc_name" value="<?php echo e($c->code); ?>" <?php if(($c->code)==($AdditionEtcPrice->code)): ?> checked <?php endif; ?>/><?php echo e($c->code_name); ?>

                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <input type="radio" name="etc_name" value="Right" <?php if(isset($AdditionEtcPrice->etc_name)): ?> checked <?php endif; ?>/>직접입력
                        </div>
                    <?php endif; ?>



                    <div class="right_now">
                        <div class='position-relative form-group'>
                            <label for='clientName'style='color: blue'>직접입력</label>
                            <input type='text' name='right_now_value' value="<?php echo e(isset($AdditionEtcPrice->etc_name)?$AdditionEtcPrice->etc_name:""); ?>">
                        </div>
                    </div>

                    <div class="position-relative form-group">
                        <label for="clientName" class="" style="color: blue">상세 설명</label>
                    </div>
                    <textarea cols="30" rows="10" name="content" ><?php echo e(isset($AdditionEtcPrice)?$AdditionEtcPrice->etc_content:""); ?>

                    </textarea>


                    <div class="position-relative form-group">
                        <label for="clientName" class="" style="color: blue">기본 금액</label>
                        <input type="text" name="price" value="<?php echo e(isset($AdditionEtcPrice)?$AdditionEtcPrice->etc_price:""); ?>">원
                    </div>
                    <div class="position-relative form-group">
                        <label for="clientName" class="" style="color: blue">단위</label>
                        <input type="text" name="dan" value="<?php echo e(isset($AdditionEtcPrice)?$AdditionEtcPrice->etc_dan:""); ?>">
                    </div>

                    <div class="position-relative form-group">
                        <label for="clientName" class="" style="color: blue">기본/최대 수량</label>
                        기본 : <input type="text" name="etc_min" value="<?php echo e(isset($AdditionEtcPrice)?$AdditionEtcPrice->etc_min:""); ?>">
                        최대 : <input type="text" name="etc_max" value="<?php echo e(isset($AdditionEtcPrice)?$AdditionEtcPrice->etc_max:""); ?>">
                    </div>
                    <?php if($isset==""): ?>
                        <div class="position-relative form-group">
                            <label for="clientName" class="" style="color: blue">판매 객실</label>
                            <input type="checkbox" id="room_id_all" value="Y">전체 객실 선택
                            <?php
                                $ClientTypeRooms = \App\Models\ClientTypeRoom::where('user_id',$user_id)->get();
                            ?>
                            <?php $__currentLoopData = $ClientTypeRooms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <input type="checkbox" name="room_id[]" value="<?php echo e($v->id); ?>"><?php echo e($v->room_name); ?>

                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    <?php else: ?>
                        <div class="position-relative form-group">
                            <label for="clientName" class="" style="color: blue">판매 객실</label>
                            <input type="checkbox" id="room_id_all" value="Y">전체 객실 선택
                            <?php
                                $ClientTypeRooms = \App\Models\ClientTypeRoom::where('user_id',$user_id)->get();
                                $room_id = \App\Models\AdditionEtcPriceRoom::where('user_id',$user_id)->value('room_id');
                            ?>
                            <?php $__currentLoopData = $ClientTypeRoom; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <input type="checkbox" name="room_id[]" value="<?php echo e($v->id); ?>" <?php if(isset($v->room_id)): ?> checked <?php endif; ?> /><?php echo e($v->room_name); ?>

                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    <?php endif; ?>

                    <div class="position-relative form-group">
                        <label for="clientName" class="" style="color: blue">결제 방법</label>
                        <input type="radio" name="etc_payment_flag" value="Y" <?php if(isset($AdditionEtcPrice) && ($AdditionEtcPrice->etc_payment_flag)=="Y"): ?> checked <?php endif; ?>/>예약시 결제
                        <input type="radio" name="etc_payment_flag" value="N" <?php if(isset($AdditionEtcPrice) && ($AdditionEtcPrice->etc_payment_flag)=="N"): ?> checked <?php endif; ?>/>현장 결제
                    </div>
                    <div class="position-relative form-group">
                        <label for="clientName" class="" style="color: blue">당일 예약</label>
                        <input type="radio" name="etc_reservation_flag" value="Y" <?php if(isset($AdditionEtcPrice) && ($AdditionEtcPrice->etc_reservation_flag)=="Y"): ?> checked <?php endif; ?>/>가능
                        <input type="radio" name="etc_reservation_flag" value="N" <?php if(isset($AdditionEtcPrice) && ($AdditionEtcPrice->etc_reservation_flag)=="N"): ?> checked <?php endif; ?>/>불가능
                    </div>
                    <div class="position-relative form-group">
                        <label for="clientName" class="" style="color: blue">판매 상태</label>
                        <input type="radio" name="etc_flag" value="Y" <?php if(isset($AdditionEtcPrice) && ($AdditionEtcPrice->etc_flag)=="Y"): ?> checked <?php endif; ?>/>판매
                        <input type="radio" name="etc_flag" value="N" <?php if(isset($AdditionEtcPrice) && ($AdditionEtcPrice->etc_flag)=="N"): ?> checked <?php endif; ?>/>비공개
                    </div>
                    <div><button class="mr-2 btn btn-focus" >저장</button></div>
                </form>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>



<?php echo $__env->make("admin.pc.layout.basic", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/www/real_resarvation/resources/views/admin/pc/include/price/etc1_view.blade.php ENDPATH**/ ?>