<?php $__env->startSection("title"); ?>숙박업체 관리<?php $__env->stopSection(); ?>

<?php $__env->startSection("scripts"); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection("styles"); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection("contents"); ?>
    <div class="tab-content">
        <div class="row">
            <div class="col-md">
                <div class="main-card mb-3 card">
                    <div class="card-body">
                        <?php echo $__env->make("admin.pc.include.client_info",['user'=>$user, 'userInfo'=>$userInfo, 'user_client_facility' =>$user_client_facility,'user_client_service'=>$user_client_service,'user_client_torisit'=>$user_client_torisit], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make("admin.pc.layout.basic", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/www/real_resarvation/resources/views/admin/pc/user/client_save.blade.php ENDPATH**/ ?>