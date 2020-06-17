<div class="row">
    <div class="main-card mb-3 card" style="width:100%; ">
        <div class="card-body"><h5 class="card-title">Client List</h5>
            <table class="mb-0 table table-hover">
                <?php
                    $path = $_SERVER["HTTP_HOST"];
                    $path = str_replace(".einet.co.kr","",$path);
                ?>
                <thead>
                <tr>
                    <th>순서</th>
                    <th>추가이용명</th>
                    <th>금액</th>
                    <th>기본/최대 수량</th>
                    <th>판매 객실</th>
                    <th>결제방법</th>
                    <th>당일예약</th>
                    <th>판매상태</th>
                    <th><button class="mr-2 btn btn-focus" onclick="goUrl('<?php if($path=="client"): ?> <?php echo e(route('info.etc.view',['did'=>isset($did)?$did:""])); ?> <?php else: ?> <?php echo e(route('price.facility.view',['user_id'=>isset($user_id)?$user_id:"", 'did'=>isset($did)?$did:""])); ?> <?php endif; ?>');">추가이용요금 등록</button></th>
                </tr>
                </thead>
                <tbody>
                <?php $__currentLoopData = $additionetcprice; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <th scope="row"><?php echo e($additionetcprice->total()-$k); ?></th>
                        <td>
                            <?php if($path=="client"): ?>
                            <a href="/info/etc/view/<?php echo e($c->id); ?>">
                            <?php else: ?>
                            <a href="/price/facility/view/<?php echo e($user_id); ?>/<?php echo e($c->id); ?>">
                            <?php endif; ?>
                            <?php if(($c->etc_name)=="" && ($c->code=="spa")): ?>
                                    스파
                            <?php elseif(($c->etc_name)=="" && $c->code=="privatepool"): ?>
                                개별 수영장
                            <?php elseif(($c->etc_name)=="" && $c->code=="bbq"): ?>
                                개별(테라스) 바베큐
                            <?php elseif(($c->etc_name)=="" && $c->code=="bathroom"): ?>
                                욕조
                            <?php elseif(($c->etc_name)=="" && $c->code=="tv"): ?>
                                TV
                            <?php elseif(($c->etc_name)=="" && $c->code=="conditioner"): ?>
                                에어컨
                            <?php elseif(($c->etc_name)=="" && $c->code=="gas"): ?>
                                가스레인지/인덕션
                            <?php elseif(($c->etc_name)=="" && $c->code=="coffee"): ?>
                                커피
                            <?php elseif(($c->etc_name)=="" && $c->code=="refrigerator"): ?>
                                냉장고
                            <?php elseif(($c->etc_name)=="" && $c->code=="table"): ?>
                                식탁
                            <?php elseif(($c->etc_name)=="" && $c->code=="rice"): ?>
                                전기 밥솥
                            <?php elseif(($c->etc_name)=="" && $c->code=="microwave"): ?>
                                전자레인지
                            <?php elseif(($c->etc_name)=="" && $c->code=="bar"): ?>
                                미니바
                            <?php elseif(($c->etc_name)=="" && $c->code=="bidet"): ?>
                                비데
                            <?php elseif(($c->etc_name)=="" && $c->code=="dry"): ?>
                                드라이기
                            <?php else: ?>
                                <?php echo e($c->etc_name); ?>

                            <?php endif; ?>
                            </a>
                        </td>
                        <td><?php echo e($c->etc_price); ?></td>
                        <td><?php echo e($c->etc_min); ?>/<?php echo e($c->etc_max); ?></td>
                        <td><?php echo e($c->etc_price); ?></td>
                        <td><?php echo e($c->etc_payment_flag); ?></td>
                        <td><?php echo e($c->etc_reservation_flag); ?></td>
                        <td><?php echo e($c->etc_flag); ?></td>
                        <td></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    </div>
</div><?php /**PATH /home/www/real_resarvation/resources/views/admin/pc/include/price/etc1_list.blade.php ENDPATH**/ ?>