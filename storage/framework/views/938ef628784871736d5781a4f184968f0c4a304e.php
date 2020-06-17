

<?php $__env->startSection("title"); ?>요금관리목록<?php $__env->stopSection(); ?>

<?php $__env->startSection("scripts"); ?>
    <script>
        $(document).ready(function(e){
            genRowspan("gubun");
            genRowspan("gubun1");
        });
        function genRowspan(className){
            $("." + className).each(function() {
                var rows = $("." + className + ":contains('" + $(this).text() + "')");
                if (rows.length > 1) {
                    rows.eq(0).attr("rowspan", rows.length);
                    rows.not(":eq(0)").remove();
                }
            });
        }
    </script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection("styles"); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection("contents"); ?>
        <table class="default" cellpadding="0" cellspacing="0">
            <thead>
            <tr>
                <td>업체명</td>
                <td colspan="4">관리 버튼</td>
            </tr>
            </thead>
            <tbody>
            <?php $__currentLoopData = $UserClient; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($v->client_name); ?></td>
                    <td><button class="btn_gray_00" onclick="goUrl('<?php echo e(route('price.calendar',['user_id'=>$v->user_id])); ?>');">일자별 요금설정 </button></td>
                    <td><button class="btn_gray_00" onclick="goUrl('<?php echo e(route('price.list',['user_id'=>$v->user_id])); ?>');">성수기/시즌 </button></td>
                    <td><button class="btn_gray_00" onclick="goUrl('<?php echo e(route('price.discount',['user_id'=>$v->user_id])); ?>');">할인판매설정 </button></td>
                    <td><button class="btn_gray_00" onclick="goUrl('<?php echo e(route('price.autoset',['user_id'=>$v->user_id])); ?>');" >자동할인설정</button></td>
                    <td><button class="btn_gray_00" onclick="goUrl('<?php echo e(route('price.facility',['user_id'=>$v->user_id])); ?>');" >기타이용요금</button></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
<?php $__env->stopSection(); ?>

<?php echo $__env->make("admin.pc.layout.basic", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/www/real_resarvation/resources/views/admin/pc/price/price_list.blade.php ENDPATH**/ ?>