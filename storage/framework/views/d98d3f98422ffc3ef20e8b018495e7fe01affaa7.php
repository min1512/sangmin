<div class="row">
    <div class="main-card mb-3 card" style="width:100%; ">
        <div class="card-body"><h5 class="card-title">Season List</h5>
            <table class="mb-0 table table-hover" style="width: 1000px;">
                <tr>
                    <th>할인명</th>
                    <th>할인 기간</th>
                    <th>할인 요일</th>
                    <th>할인명 노출</th>
                    <th>상세 내용</th>
                    <th><a id="delete_discount" name="delete_discount" class="mr-2 btn btn-info" style="color: white;">할인 삭제</a></th>
                    <th><button class="mr-2 btn btn-focus" onclick="goUrl('<?php echo e(isset($client) && $client=="client"? route('info.discount.view',['did'=>isset($did)?$did:""]) : route('price.discount.view',['user_id'=>isset($user_id)?$user_id:"", 'did'=>isset($did)?$did:""])); ?>');">할인 추가</button></th>
                </tr>
                <?php $__currentLoopData = $discountList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($k+1); ?></td>
                    <td>
                        <?php if($client=="client"): ?>
                            <a href="/info/discount/view/<?php echo e($s->id); ?>"><?php echo e($s->discount_name); ?></a>
                        <?php else: ?>
                            <a href="/price/discount/view/<?php echo e($user_id); ?>/<?php echo e($s->id); ?>"><?php echo e($s->discount_name); ?></a>
                        <?php endif; ?>

                    </td>
                    <td><?php echo e($s->discount_start); ?> ~ <?php echo e($s->discount_end); ?></td>
                    <td>
                        <?php
                            $date_array = explode(',',$s->date);
                            for ($i=0; $i<sizeof($date_array); $i++){
                                if($date_array[$i]==1){
                                    echo "월,";
                                }elseif ($date_array[$i]==2){
                                    echo "화,";
                                }elseif ($date_array[$i]==3){
                                    echo "수,";
                                }elseif ($date_array[$i]==4){
                                    echo "목,";
                                }elseif ($date_array[$i]==5){
                                    echo "금,";
                                }elseif ($date_array[$i]==6){
                                    echo "토,";
                                }elseif ($date_array[$i]==0){
                                    echo "일";
                                }
                            }
                        ?>
                    </td>
                    <td><?php echo e($s->flag_use); ?></td>
                    <td></td>
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
<?php /**PATH /home/www/real_resarvation/resources/views/admin/pc/include/discount/discount_list.blade.php ENDPATH**/ ?>