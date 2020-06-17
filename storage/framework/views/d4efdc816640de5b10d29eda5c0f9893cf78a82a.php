

<?php $__env->startSection("title"); ?>기타이용요금<?php $__env->stopSection(); ?>

<?php $__env->startSection("scripts"); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection("styles"); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection("contents"); ?>
    <?php echo $__env->make("admin.pc.include.price.etc1_search",['search'=>isset($search)?$search:[]], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <?php echo $__env->make("admin.pc.include.price.etc1_list",['additionetcprice'=>$additionetcprice,'user_id'=>isset($user_id)?$user_id:""], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make("admin.pc.layout.basic", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/www/real_resarvation/resources/views/admin/pc/price/etc1.blade.php ENDPATH**/ ?>