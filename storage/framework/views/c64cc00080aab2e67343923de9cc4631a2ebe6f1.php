<?php $__env->startSection("title"); ?>숙박업체 관리<?php $__env->stopSection(); ?>

<?php $__env->startSection("scripts"); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection("styles"); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection("contents"); ?>

    <table class="default" cellpadding="0" cellspacing="0">
        <thead>
        <tr>
            <td>업소번호</td>
            <td>회원구분</td>
            <td>업소명</td>
            <td>사용여부</td>
            <td>지역</td>
            <td>시스템설치</td>
            <td>카드수수료</td>
            <td>예대수수료</td>
            <td>업소종류</td>
            <td>등록일자</td>
            <td><button class="btn_gray_00" onclick="goUrl('<?php echo e(route('user.client.save',['id'=>0])); ?>');">신규 등록</button></td>
        </tr>
        </thead>
        <tbody>
        <?php $__currentLoopData = $clientList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <th scope="row"><?php echo e($clientList->total()-$k); ?></th>
                <td><?php echo e($c->client_gubun); ?></td>
                <td><?php echo e($c->client_name); ?></td>
                <td><?php if($c->flag_use=="Y"): ?>사용<?php else: ?>사용안함<?php endif; ?></td>
                <td><?php echo e($c->client_addr_basic); ?></td>
                <td>시스템설치</td>
                <td><?php echo e($c->client_fee_payment.$c->client_fee_payment_unit); ?></td>
                <td><?php echo e($c->client_fee_agency.$c->client_fee_agency_unit); ?></td>
                <?php $client_type = \App\Http\Controllers\Controller::getCode('client_type'); ?>
                <td>
                    <?php $__currentLoopData = $client_type; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if(isset($c->code_type) && $v->code == $c->code_type): ?><?php echo e($v->name); ?><?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </td>
                <td><?php echo e($c->created_at); ?></td>
                <td>
                    <button class="mr-2 btn btn-success" onclick="goUrl('<?php echo e(route('user.client.save',['id'=>$c->user_id])); ?>');">업체정보</button>
                    <button class="mr-2 btn btn-info" onclick="goUrl('<?php echo e(route('user.client.settle',['id'=>$c->user_id])); ?>');">사업자/정산정보</button>
                </td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
<?php $__env->stopSection(); ?>

<?php echo $__env->make("admin.pc.layout.basic", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/www/real_resarvation/resources/views/admin/pc/user/client_list.blade.php ENDPATH**/ ?>