<?php $__env->startSection("title"); ?>실시간 예약시스템<?php $__env->stopSection(); ?>

<?php $__env->startSection("scripts"); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection("styles"); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection("contents"); ?>
    <form method="post" name="frmLogin" action="<?php echo e(url()->current()); ?>">
        <?php echo e(csrf_field()); ?>

        <div class="login-header">이아이넷 실시간 예약 시스템</div>
        <div class="content card">
            <div class="form-group">
                <label>이메일 </label>
                <input id="email" type="text" name="email" placeholder="Enter email" class="form-control">
            </div>
            <div class="form-group">
                <label>비밀번호</label>
                <input id="password" type="password" name="password" placeholder="Password" class="form-control">
            </div>
            <div class=" text-center">
                <button id="login" class="btn login-btn  ">로그인 </button></a><br>
            </div>
            <ul class="login_fing">
                <li>
                    <input id=" " type="checkbox" checked="checked" class="form-control_r ">
                    <label class="p-l-5">	<a href="#"	>아이디 저장 </a></label>
                </li>
            </ul>
        </div>
    </form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make("admin.pc.layout.blank", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/www/real_resarvation/resources/views/admin/pc/member/login.blade.php ENDPATH**/ ?>