

<?php $__env->startSection("title"); ?>자동 할인 판매 설정<?php $__env->stopSection(); ?>

<?php $__env->startSection("scripts"); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection("styles"); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection("contents"); ?>
    <?php echo $__env->make("admin.pc.include.auto_discount.discount_search",['search'=>isset($search)?$search:[]], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <?php echo $__env->make("admin.pc.include.auto_discount.discount_list",['discountList'=>$discountList, 'client'=>$client,'user_id'=>$user_id, 'Client_type_room'=>$Client_type_room], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php echo $__env->make("admin.pc.layout.basic", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/www/real_resarvation/resources/views/admin/pc/price/autodiscount.blade.php ENDPATH**/ ?>