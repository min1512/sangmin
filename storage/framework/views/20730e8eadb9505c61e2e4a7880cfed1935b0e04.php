<?php $__env->startSection("title"); ?>일자별 요금정보<?php $__env->stopSection(); ?>

<?php $__env->startSection("scripts"); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection("styles"); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection("contents"); ?>
    <?php
        $curDate      = strtotime($year."-".$month."-".$day);
        $dayPerMonth  = date("t",$curDate);
        $yoilStart    = date("w",strtotime($year."-".$month."-1"));

        $prevMonth    = strtotime("-1 month",$curDate);
        $nextMonth    = strtotime("+1 month",$curDate);
        $today = date("d");
    ?>
    <div style="margin:0 auto; text-align:center; ">
        <a href="<?php echo e(url()->current()); ?>?year=<?php echo e(date("Y",$prevMonth)); ?>&month=<?php echo e(date("n",$prevMonth)); ?>">◀</a>
        <?php echo e(date("Y-m",$curDate)); ?>

        <a href="<?php echo e(url()->current()); ?>?year=<?php echo e(date("Y",$nextMonth)); ?>&month=<?php echo e(date("n",$nextMonth)); ?>">▶</a>
    </div>
    <form method="post" name="frmCalendarPrice" id="frmCalendarPrice" action="<?php echo e(url()->current()); ?>">
        <?php echo e(csrf_field()); ?>

        <button type="submit">변경</button>
        <table class="calc">
            <thead>
                <th style="border:1px solid #888; ">일</th>
                <th style="border:1px solid #888; ">월</th>
                <th style="border:1px solid #888; ">화</th>
                <th style="border:1px solid #888; ">수</th>
                <th style="border:1px solid #888; ">목</th>
                <th style="border:1px solid #888; ">금</th>
                <th style="border:1px solid #888; ">토</th>
            </thead>
            <tr>
            <?php for($i=1,$j=$yoilStart; $i<=$yoilStart; $i++,$j--): ?>
                <td style="border:1px solid #888; "><?php echo e("-".$j); ?></td>
            <?php endfor; ?>
            <?php for($i=1,$y=$yoilStart; $i<=$dayPerMonth; $i++,$y++): ?>
                <?php if($y%7==0): ?> <tr> <?php endif; ?>
                <?php if($i==$today): ?> <td style="border:1px solid #888; background: navajowhite"> <?php else: ?> <td style="border:1px solid #888; "> <?php endif; ?>
                     <?php echo e($i); ?>

                    <?php $__currentLoopData = $room; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            if(isset($price_day[$i]) && count($price_day[$i][$r->id][$y%7])>1) {
                                arsort($price_day[$i][$r->id][$y%7]);
                                $tmp_key = key($price_day[$i][$r->id][$y%7]);
                                print_r($price_day[$i][$r->id][$y%7]);
                            }
                            else {
                                $tmp_key = 0;
                            }
                        ?>
                        <p>
                            <?php echo e($r->room_name); ?>

                            <input type="hidden" name="price_season[<?php echo e(date("Y-m-".sprintf("%02d",$i),$curDate)); ?>][<?php echo e($r->id); ?>]" value="<?php echo e($tmp_key); ?>" />
                            <input type="hidden" name="price_daily[<?php echo e(date("Y-m-".sprintf("%02d",$i),$curDate)); ?>][<?php echo e($r->id); ?>]" value="<?php echo e($y%7>0&&$y%7<5?1:$y%7); ?>" />
                            <select name="custom_price_season[<?php echo e(date("Y-m-".sprintf("%02d",$i),$curDate)); ?>][<?php echo e($r->id); ?>]">
                                <?php $__currentLoopData = $season; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($s->id); ?>" <?php echo e(isset($price_custom[$i][$r->id])&&$price_custom[$i][$r->id]->season_id==$s->id?"selected":""); ?>><?php echo e($s->season_name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <select name="custom_price_daily[<?php echo e(date("Y-m-".sprintf("%02d",$i),$curDate)); ?>][<?php echo e($r->id); ?>]">
                                <option value="">::요일::</option>
                                <option value="0" <?php echo e(isset($price_custom[$i][$r->id])&&$price_custom[$i][$r->id]->price_day==0?"selected":($y%7==0?"selected":"")); ?>>일요일</option>
                                <option value="1" <?php echo e(isset($price_custom[$i][$r->id])&&$price_custom[$i][$r->id]->price_day==1?"selected":($y%7>0&&$y%7<5?"selected":"")); ?>>주중</option>
                                <option value="5" <?php echo e(isset($price_custom[$i][$r->id])&&$price_custom[$i][$r->id]->price_day==5?"selected":($y%7==5?"selected":"")); ?>>금요일</option>
                                <option value="6" <?php echo e(isset($price_custom[$i][$r->id])&&$price_custom[$i][$r->id]->price_day==6?"selected":($y%7==6?"selected":"")); ?>>토요일</option>
                            </select>
                        </p>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </td>
                <?php if($y%7==6): ?> </tr> <?php endif; ?>
            <?php endfor; ?>

            <?php for($i=$y%7,$k=1; $i<7; $i++,$k++): ?>
                <td style="border:1px solid #888; "><?php echo e("+".$k); ?></td>
                <?php if($i%7==6): ?> </tr> <?php endif; ?>
            <?php endfor; ?>
        </table>
    </form>

<?php $__env->stopSection(); ?>

<?php echo $__env->make("admin.pc.layout.basic", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/www/real_resarvation/resources/views/admin/pc/price/calendar.blade.php ENDPATH**/ ?>