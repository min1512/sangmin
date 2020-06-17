<?php $__env->startSection("title"); ?>예약시스템 로그인<?php $__env->stopSection(); ?>

<?php $__env->startSection("scripts"); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection("styles"); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection("contents"); ?>
    <?php echo e($user->email); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make("admin.pc.layout.basic", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/www/real_resarvation/resources/views/admin/pc/main/staff.blade.php ENDPATH**/ ?>