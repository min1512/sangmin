<?php if($id=="" || $id==0): ?>
<?php else: ?>
<div class="season_term_list">
    <div class="main-card mb-3 card" style="width:100%; ">
        <div class="card-body"><h5 class="card-title">Season Term</h5>
            <form name="season_term_form" method="post" onsubmit="return test()">
                <table class="mb-0 table table-hover" style="width: 1000px;" id="season_term_table">
                    <input type="hidden" name="user_id" value="<?php echo e(Auth::user()->id); ?>">
                    <input type="hidden" name="season_id" value="<?php echo e($id); ?>">
                    <?php echo e(csrf_field()); ?>

                    <tbody>
                        <tr>
                            <?php $__currentLoopData = $season; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <th>시즌명</th>
                                <td colspan="2"><?php echo e($s->season_name); ?>&nbsp;&nbsp;<a class="mr-2 btn btn-info" id="time_add" style="color: white">기간 추가</a></td>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tr>
                        <?php $__currentLoopData = $season_term; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$st): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <input type="hidden" name="season_term_id[<?php echo e($k); ?>]" value="<?php echo e($st->id); ?>" />
                            <th>기간</th>
                            <td><input type="date" name="start_season[<?php echo e($k); ?>]" value="<?php echo e($st->season_start); ?>">~<input type="date" name="end_season[<?php echo e($k); ?>]" value="<?php echo e($st->season_end); ?>">&nbsp;&nbsp;<a class="mr-2 btn btn-info season_delete" style="color: white" >X</a></td>
                            <td><input type="radio" name="check_season[<?php echo e($k); ?>]" value="Y" <?php if($st->flag_view=="Y"): ?> checked="checked"<?php endif; ?>/>기간 노출함<input type="radio" name="check_season[<?php echo e($k); ?>]" value="N" <?php if($st->flag_view=="N"): ?> checked="checked"<?php endif; ?>/>기간 노출 안함</td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td><button class="mr-2 btn btn-info season_save" id="season_save">저장</button></td>
                        </tr>
                    </tfoot>
                </table>
            </form>
        </div>
    </div>
</div>
<?php endif; ?>
<?php /**PATH /home/www/real_resarvation/resources/views/admin/pc/include/price/season_list_2.blade.php ENDPATH**/ ?>