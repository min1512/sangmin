<?php $__env->startSection("title"); ?>룸타입목록<?php $__env->stopSection(); ?>

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
        <?php $__currentLoopData = $user_client; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($v->client_name); ?></td>
                <td><button class="btn_gray_00" onclick="goUrl('<?php echo e(route('user.client.save',['id'=>$v->user_id,'check'=>"check"])); ?>');">숙박업소 관리</button></td>
                <td><button class="btn_gray_00">설정</button></td>
                <td><button class="btn_gray_00" onclick="goUrl('<?php echo e(route('room.list',['user_id'=>$v->user_id])); ?>');">객실 관리</button></td>
                <td><button class="btn_gray_00" onclick="goUrl('<?php echo e(route('client.block',['id'=>$v->user_id])); ?>');">방막기</button></td>
                <td><button class="btn_gray_00" onclick="goUrl('<?php echo e(route('client.over',['id'=>$v->user_id])); ?>');" >연박 설정</button></td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
<?php $__env->stopSection(); ?>

<?php echo $__env->make("admin.pc.layout.basic", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/www/real_resarvation/resources/views/admin/pc/room/room_list.blade.php ENDPATH**/ ?>