<?php $__env->startSection("title"); ?>업체별 요금 목록<?php $__env->stopSection(); ?>

<?php $__env->startSection("scripts"); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection("styles"); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection("contents"); ?>
    <?php echo $__env->make("admin.pc.include.content_title", [
        'title'=>'업체별 요금정보',
        'mean'=>'Client Price'
    ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <ul>
    <?php $__currentLoopData = $clientList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <li>
            <span><?php echo e($c->id); ?></span>
            <span><?php echo e($c->client_name); ?></span>
            <span>
                <button type="button" onclick="goUrl('<?php echo e(route('price.list.calc',['id'=>$c->id])); ?>')">요금설정</button>
                <button type="button" onclick="goUrl('<?php echo e(route('price.list.season',['id'=>$c->id])); ?>')">시즌/시즌요금</button>
                <button type="button" onclick="goUrl('<?php echo e(route('price.list.discount',['id'=>$c->id])); ?>')">할인판매설정</button>
                <button type="button" onclick="goUrl('<?php echo e(route('price.list.autoset',['id'=>$c->id])); ?>')">자동할인설정</button>
                <button type="button" onclick="goUrl('<?php echo e(route('price.list.etc',['id'=>$c->id])); ?>')">기타이용요금</button>
            </span>
        </li>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ul>
<?php $__env->stopSection(); ?>

<?php echo $__env->make("admin.pc.layout.main", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/www/real_resarvation/resources/views/admin/pc/price/info_list.blade.php ENDPATH**/ ?>