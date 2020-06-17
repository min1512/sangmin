<div class="row">
    <div class="main-card mb-3 card" style="width:100%; ">
        <div class="card-body"><h5 class="card-title">Season List</h5>
            <table class="mb-0 table table-hover" style="width: 1000px;" >
                <tr>
                    <th>&nbsp;</th>
                    <th>할인 적용일</th>
                    <th>할인 내용</th>
                    <th>기간</th>
                    <th>객실</th>
                    <th><a id="delete_discount" name="delete_discount" class="mr-2 btn btn-info" style="color: white;">할인 삭제</a></th>
                    <th><button class="mr-2 btn btn-focus" onclick="goUrl('<?php echo e(isset($client) && $client=="client" ? route('info.autoset.view',['did'=>isset($did)?$did:""]) : route('price.autoset.view',['user_id'=>isset($user_id)?$user_id:"", 'did'=>isset($did)?$did:""])); ?>');">자동 할인 추가</button></th>
                </tr>
                <?php $__currentLoopData = $discountList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=> $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <?php
                            $date_array = explode(',',$s->day);
                            $date_list="";
                            for ($i=0; $i<sizeof($date_array); $i++){
                                if($date_array[$i]==1){
                                    $date_list = $date_list."월,";
                                }elseif ($date_array[$i]==2){
                                    $date_list = $date_list."화,";
                                }elseif ($date_array[$i]==3){
                                    $date_list = $date_list."수,";
                                }elseif ($date_array[$i]==4){
                                    $date_list = $date_list."목,";
                                }elseif ($date_array[$i]==5){
                                    $date_list = $date_list."금,";
                                }elseif ($date_array[$i]==6){
                                    $date_list = $date_list."토";
                                }elseif ($date_array[$i]==0){
                                    $date_list = $date_list."일,";
                                }
                            }
                        ?>
                        <td><?php echo e($k+1); ?></td>
                        <td>
                            <?php if($client=="client"): ?>
                                <a href="/info/auto_discount/view/<?php echo e($s->id); ?>"><?php echo e($date_list); ?></a>
                            <?php else: ?>
                                <a href="/price/autoset/view/<?php echo e($user_id); ?>/<?php echo e($s->id); ?>"><?php echo e($date_list); ?></a>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php
                                $aaaa = \App\Models\AutosetDiscountHowmuch::where('autoset_id',$s->id)->orderBy('date','asc')->get();
                            ?>
                            <?php $__currentLoopData = $aaaa; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $a): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($a->date=="0"): ?>
                                    <p>입실 당일: <?php echo e($a->autoset_discount_howmuch); ?></p>
                                <?php else: ?>
                                    <p>입실 <?php echo e($a->date); ?>일전: <?php echo e($a->autoset_discount_howmuch); ?></p>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </td>
                        <td><?php if($s->term_check=="N"): ?>상시<?php elseif($s->term_check=="Y"): ?><?php echo e($s->discount_start); ?> ~ <?php echo e($s->discount_end); ?><?php endif; ?></td>
                        <td>
                            <?php $__currentLoopData = $Client_type_room; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($v->autoset_id==$s->id): ?>
                                    <p><?php echo e($v->room_name); ?></p>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </td>
                        <td colspan="2"></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <th id="add_discount_list"></th>
                </tr>
            </table>
        </div>
    </div>
</div>
<?php /**PATH /home/www/real_resarvation/resources/views/admin/pc/include/auto_discount/discount_list.blade.php ENDPATH**/ ?>