<?php $__env->startSection("title"); ?>직원관리<?php $__env->stopSection(); ?>

<?php $__env->startSection("scripts"); ?>
    <script>
        $(function(){
            $("input.btnSave").click(function(){
                document.location.href='<?php echo e(route('user.staff.save')); ?>/'+$(this).data("id");
            });
        });
    </script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection("styles"); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection("contents"); ?>
    <table class="default" cellpadding="0" cellspacing="0">
        <thead>
        <tr>
            <td>직원명</td>
            <td>이메일</td>
            <td>연락처</td>
            <td>생년월일</td>
            <td><button class="btn_gray_00" onclick="goUrl('<?php echo e(route('user.staff.save',['id'=>0])); ?>');">신규 등록</button></td>
            <td>&nbsp;</td>
        </tr>
        </thead>
        <tbody>
        <?php $__currentLoopData = $staff; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($s->staff_name); ?></td>
                <td><?php echo e($s->email); ?></td>
                <td><?php echo e($s->staff_hp); ?></td>
                <td><?php echo e($s->staff_birth); ?>(<?php echo e($s->staff_lunar=="Y"?"-":"+"); ?>)</td>
                <td><input type="button" value="수정" class="btnSave" data-id="<?php echo e($s->user_id); ?>"/></td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        </tbody>
    </table>
<?php $__env->stopSection(); ?>

<?php echo $__env->make("admin.pc.layout.basic", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/www/real_resarvation/resources/views/admin/pc/user/staff_list.blade.php ENDPATH**/ ?>