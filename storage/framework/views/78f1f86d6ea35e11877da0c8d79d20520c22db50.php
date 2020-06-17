<?php $__env->startSection("title"); ?>대행사관리<?php $__env->stopSection(); ?>

<?php $__env->startSection("scripts"); ?>
    <script>
        $(function(){
            $("input.btnSave").click(function(){
                document.location.href='<?php echo e(route('user.agency.save')); ?>/'+$(this).data("id");
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
            <td>대행사명</td>
            <td>사업자번호</td>
            <td>주소</td>
            <td>이메일</td>
            <td>연락처</td>
            <td><button class="btn_gray_00" onclick="goUrl('<?php echo e(route('user.agency.save',['id'=>0])); ?>');">신규 등록</button></td>
            <td>&nbsp;</td>
        </tr>
        </thead>
        <tbody>
        <?php $__currentLoopData = $agency; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $a): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($a->agency_name); ?></td>
                <td><?php echo e($a->agency_number); ?></td>
                <td><?php echo e($a->agency_addr_basic." ".$a->agency_addr_detail); ?></td>
                <td><?php echo e($a->email); ?></td>
                <td><?php echo e($a->staff_hp); ?></td>
                <td><input type="button" value="수정" class="btnSave" data-id="<?php echo e($a->user_id); ?>"/></td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
<?php $__env->stopSection(); ?>

<?php echo $__env->make("admin.pc.layout.basic", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/www/real_resarvation/resources/views/admin/pc/user/agency_list.blade.php ENDPATH**/ ?>