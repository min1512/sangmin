<?php $__env->startSection("title"); ?>할인 판매 설정<?php $__env->stopSection(); ?>

<?php $__env->startSection("scripts"); ?>
<script>

</script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection("styles"); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection("contents"); ?>
    <?php echo $__env->make("admin.pc.include.discount.discount_search",['search'=>isset($search)?$search:[]], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <?php echo $__env->make("admin.pc.include.discount.discount_list",['discountList'=>$discountList,'client'=>$client,'user_id'=>$user_id], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php echo $__env->make("admin.pc.layout.basic", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/www/real_resarvation/resources/views/admin/pc/price/discount.blade.php ENDPATH**/ ?>