<div class="row fl between-32 js-height" style="width:48%;min-width:460px;">
    <div class="">
        <div class="card-body">
            <?php
            $path = $_SERVER["HTTP_HOST"];
            $path = str_replace(".einet.co.kr","",$path);
            ?>
            <?php if($path=="client"): ?>
            <form id="live_room" name="live_room" method="post" action="/info/room/check">
                <?php else: ?>
                <form id="live_room" name="live_room" method="post" action="<?php echo e(url()->current()); ?>">
                    <?php endif; ?>
                    <?php echo e(csrf_field()); ?>

                    <div class="table-a noto">
                        <div class="table-a__head clb">
                            <h5 class="table-a__tit fl">Room List</h5>
                            <div class="table-a__inbox type-head fr">
                                <button class="btn-v1">변경</button>
                            </div>
                        </div>

                        <table class="table-a__table">
                            <colgroup>
                                <col width="7%">
                                <col width="48%">
                                <col width="18%">
                                <col width="18%">
                                <col width="9%">
                            </colgroup>
                            <tr class="table-a__tr type-th">
                                <th class="table-a__th">번호</th>
                                <th class="table-a__th">객실명</th>
                                <th class="table-a__th">실시간 예약</th>
                                <th class="table-a__th">온라인 예약</th>
                                <th class="table-a__th">삭제</th>
                            </tr>
                        </table>
                        <div class="scroll" id="js-scroll" style="height:300px;" onresize="scroll_height()">
                            <table class="table-a__table">
                                <colgroup>
                                    <col width="7%">
                                    <col width="48%">
                                    <col width="18%">
                                    <col width="18%">
                                    <col width="9%">
                                </colgroup>
                            
                            
                            
                                <tbody>
                                    <?php $__currentLoopData = $ClientTypeRoom; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td class="table-a__td">
                                            <div class="table-a__inbox">
                                                <span><?php echo e($k+1); ?></span>
                                            </div>
                                        </td>
                                        <td class="table-a__td">
                                            <div class="table-a__inbox ta_l">
                                                <span><?php echo e($c->room_name); ?></span>
                                            </div>
                                        </td>
                                        <td class="table-a__td">
                                            <div class="table-a__inbox ta_l">
                                                <div>
                                                    <input type="radio" id="now_<?php echo e($k+1); ?>" class="radio-v1"  name="now_<?php echo e($k+1); ?>" value="Y" <?php if(($c->flag_realtime)=='Y'): ?> checked="checked"<?php endif; ?> checked />
                                                    <label for="now_<?php echo e($k+1); ?>">판매함</label>
                                                </div>
                                                <div>
                                                    <input type="radio" id="now_<?php echo e($k+1); ?>-1" class="radio-v1" name="now_<?php echo e($k+1); ?>" value="N" <?php if(($c->flag_realtime)!='Y'): ?> checked="checked" <?php endif; ?> />
                                                    <label for="now_<?php echo e($k+1); ?>-1">판매안함</label>
                                                </div>
                            <!--
                                                <input type="radio" name="now_<?php echo e($k+1); ?>" value="Y" <?php if(($c->flag_realtime)=='Y'): ?> checked="checked"<?php endif; ?>>판매
                                                <input type="radio" name="now_<?php echo e($k+1); ?>" value="N" <?php if(($c->flag_realtime)!='Y'): ?> checked="checked" <?php endif; ?>>판매 안함
                            -->
                                            </div>
                                        </td>
                                        <td class="table-a__td">
                                            <div class="table-a__inbox ta_l">
                                               <div>
                                                    <input type="radio" id="online_<?php echo e($k+1); ?>" class="radio-v2"  name="online_<?php echo e($k+1); ?>" value="Y" <?php if(($c->flag_online)=='Y'): ?> checked="checked" <?php endif; ?>>
                                                    <label for="online_<?php echo e($k+1); ?>">판매함</label>
                                                </div>
                                                <div>
                                                    <input type="radio" id="online_<?php echo e($k+1); ?>-1" class="radio-v2" name="online_<?php echo e($k+1); ?>" value="N" <?php if(($c->flag_online)!='Y'): ?> checked="checked"<?php endif; ?> />
                                                    <label for="online_<?php echo e($k+1); ?>-1">판매안함</label>
                                                </div>
                            <!--
                                                <input type="radio" name="online_<?php echo e($k+1); ?>" value="Y" <?php if(($c->flag_online)=='Y'): ?> checked="checked" <?php endif; ?>>판매 
                                                <input type="radio" name="online_<?php echo e($k+1); ?>" value="N" <?php if(($c->flag_online)!='Y'): ?> checked="checked"<?php endif; ?>>판매 안함
                            -->
                                            </div>
                                        </td>
                                        <td class="table-a__td">
                                            <div class="table-a__inbox">
                                               <input type="checkbox" id="delete_<?php echo e($k+1); ?>" class="checkbox-v1 type-notxt" name="delete_<?php echo e($k+1); ?>" value="ok"><label for="delete_<?php echo e($k+1); ?>"></label>
                            <!--                                            <input type="checkbox" name="delete_<?php echo e($k+1); ?>" value="ok">-->
                                            </div>
                                        </td>
                            
                                        <!--
                                    <td scope="row"><?php echo e($k+1); ?></td>
                                    <td><input type="hidden" name="client_type_room_group_<?php echo e($k+1); ?>" value="<?php echo e(isset($ClientTypeRoom)?$c->type_id:""); ?>"></td>
                                    <td><input type="hidden" name="client_type_room_id_<?php echo e($k+1); ?>" value="<?php echo e(isset($ClientTypeRoom)?$c->id:""); ?>"></td>
                                    <td><?php echo e($c->room_name); ?></td>
                                    <td><input type="radio" name="now_<?php echo e($k+1); ?>"  value="Y" <?php if(($c->flag_realtime)=='Y'): ?> checked="checked"<?php endif; ?>>판매<input type="radio" name="now_<?php echo e($k+1); ?>" value="N" <?php if(($c->flag_realtime)!='Y'): ?> checked="checked" <?php endif; ?>>판매 안함</td>
                                    <td>
                                    <input type="radio" name="online_<?php echo e($k+1); ?>" value="Y" <?php if(($c->flag_online)=='Y'): ?> checked="checked" <?php endif; ?>>판매  <input type="radio" name="online_<?php echo e($k+1); ?>" value="N" <?php if(($c->flag_online)!='Y'): ?> checked="checked"<?php endif; ?>>판매 안함</td>
                                    <td><input type="checkbox" name="delete_<?php echo e($k+1); ?>" value="ok"></td>
                            -->
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    
                                    
                                    
                                   
                            
                                </tbody>
                            </table>
                        </div>
                    </div>
                </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        //로딩시 높이지정
        scroll_height();
        
        function scroll_height(ab){
            var who = document.getElementById("js-scroll");
            
            var wH = window.innerHeight;
            var scrollH = wH - 350;
            
            who.style.height = scrollH + "px";
        }
         
        
        
        
        
        
        
    });
    
    
    
    
    
    
    
    
    
    
    
    
    
</script>
<?php /**PATH /home/www/real_resarvation/resources/views/admin/pc/include/price/etc_list2.blade.php ENDPATH**/ ?>