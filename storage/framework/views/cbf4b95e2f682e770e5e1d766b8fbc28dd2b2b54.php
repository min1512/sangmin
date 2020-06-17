<div class="row">
    <div class="main-card mb-3 card" style="width:100%; ">
        <div class="card-body"><h5 class="card-title">Price List</h5>
            <table class="mb-0 table table-hover" name="price_season_table" id="price_season_table">
                <?php
                    $path = $_SERVER["HTTP_HOST"];
                    $path = explode(".",$path);
                    if($path[0]=="staff"){
                        $PATH= $curPathstaff."/".$user_id;
                    }else{
                        $PATH = $curPath.'/save';
                    }
                ?>
                <form action="<?php echo e($PATH); ?>" method="post">
                    <input type="hidden" name="user_id" value="<?php echo e(isset($user_id)?$user_id:""); ?>" />
                    <?php echo e(csrf_field()); ?>

                    <thead>
                    <tr>
                        <th colspan="3" style="text-align: center">객실</th>
                        <th colspan="4" style="text-align: center">객실 기본요금</th>
                        <th colspan="3" style="text-align: center">추가 인원 요금</th>
                    </tr>
                    <tr>
                        <td>그룹명</td>
                        <td>기준</td>
                        <td width="fit-content">객실명</td>
                        <td width="fit-content"><input type="checkbox" id="season_all">전체 선택(시즌)</td>
                        <td>일요일</td>
                        <td>주중</td>
                        <td>금요일</td>
                        <td>토요일(공휴일 전날)</td>
                        <td>성인</td>
                        <td>아동</td>
                        <td>유아</td>
                    </tr>
                    </thead>
                    <?php $__currentLoopData = $room; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php $__currentLoopData = $season; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td class="gubun"><?php echo e($r->type_name); ?></td>
                                <td><?php echo e($r->room_cnt_basic); ?></td>
                                <td><?php echo e($r->room_name); ?></td>
                                <td><input type="checkbox" name="all_price_<?php echo e($r->id); ?>_<?php echo e($s->id); ?>" id='all_price_<?php echo e($r->id); ?>_<?php echo e($s->id); ?>' value="all_price_<?php echo e($r->id); ?>_<?php echo e($s->id); ?>" /><?php echo e($s->season_name); ?></td>
                                <td>
                                    <input type='text' size='9'  class="number" name='price[0][<?php echo e($r->id); ?>][<?php echo e($s->id); ?>]' id="price_0_<?php echo e($r->id); ?>_<?php echo e($s->id); ?>" value="<?php echo e(isset($roomSeasonPrice[$r->id][$s->id])?number_format($roomSeasonPrice[$r->id][$s->id]->price_day_0):0); ?>" />
                                </td>
                                <td>
                                    <input type='text' size='9'  class="number" name='price[1][<?php echo e($r->id); ?>][<?php echo e($s->id); ?>]' id="price_1_<?php echo e($r->id); ?>_<?php echo e($s->id); ?>" value="<?php echo e(isset($roomSeasonPrice[$r->id][$s->id])?number_format($roomSeasonPrice[$r->id][$s->id]->price_day_1):0); ?>" />

                                </td>
                                <td>
                                    <input type='text' size='9'  class="number" name='price[5][<?php echo e($r->id); ?>][<?php echo e($s->id); ?>]' id="price_5_<?php echo e($r->id); ?>_<?php echo e($s->id); ?>" value="<?php echo e(isset($roomSeasonPrice[$r->id][$s->id])?number_format($roomSeasonPrice[$r->id][$s->id]->price_day_5):0); ?>" />

                                </td>
                                <td>
                                    <input type='text' size='9'  class="number" name='price[6][<?php echo e($r->id); ?>][<?php echo e($s->id); ?>]' id="price_6_<?php echo e($r->id); ?>_<?php echo e($s->id); ?>" value="<?php echo e(isset($roomSeasonPrice[$r->id][$s->id])?number_format($roomSeasonPrice[$r->id][$s->id]->price_day_6):0); ?>" />

                                </td>
                                <td>
                                    <input type='text' size='9'  class="number" name='price[11][<?php echo e($r->id); ?>][<?php echo e($s->id); ?>]' id="price_11_<?php echo e($r->id); ?>_<?php echo e($s->id); ?>" value="<?php echo e(isset($roomSeasonPrice[$r->id][$s->id])?number_format($roomSeasonPrice[$r->id][$s->id]->add_adult):0); ?>" />

                                </td>
                                <td>
                                    <input type='text' size='9'  class="number" name='price[12][<?php echo e($r->id); ?>][<?php echo e($s->id); ?>]' id="price_12_<?php echo e($r->id); ?>_<?php echo e($s->id); ?>" value="<?php echo e(isset($roomSeasonPrice[$r->id][$s->id])?number_format($roomSeasonPrice[$r->id][$s->id]->add_child):0); ?>" />

                                </td>
                                <td>
                                    <input type='text' size='9'  class="number" name='price[13][<?php echo e($r->id); ?>][<?php echo e($s->id); ?>]' id="price_13_<?php echo e($r->id); ?>_<?php echo e($s->id); ?>" value="<?php echo e(isset($roomSeasonPrice[$r->id][$s->id])?number_format($roomSeasonPrice[$r->id][$s->id]->add_baby):0); ?>" />

                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <th style="text-align: center; width: 150px;"><button class="mr-2 btn btn-info">요금 등록</button></th>
                    </tr>
                </form>
            </table>
        </div>
    </div>
</div>
<div class='many_price_insert'>
</div>
<?php /**PATH /home/www/real_resarvation/resources/views/admin/pc/include/price/season_price.blade.php ENDPATH**/ ?>