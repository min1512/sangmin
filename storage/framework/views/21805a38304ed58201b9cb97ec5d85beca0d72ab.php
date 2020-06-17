<?php $__env->startSection("title"); ?>숙박업소관리-방막기<?php $__env->stopSection(); ?>

<?php $__env->startSection("scripts"); ?>
<script>
    $(function () {
        $('#block_tel_show').hide();
        $('#block_tel').click(function () {
            $('#block_tel_show').show();
            $('.button').hide();
            $('.submit2').show();
            $("input[name='all_check[]']").each(function () {
                $("input[name^='custom_price_season["+$(this).val()+"]']").prop("checked",false);
                $(this).prop("checked",false);
            });
            $('.submit2').click(function () {
                var tcnt=0;
                $("input[name^='block_tel_start']").each(function (index) {
                    if (
                        ($("input[name^='block_tel_start']").eq(index).val() > $("input[name^='block_tel_end']").eq(index).val())
                    ) {
                        alert("기간 입력이 잘못 되었습니다");
                        tcnt++;
                    } else if (
                        ($("input[name^='block_tel_start']").eq(index).val() == "" || $("input[name^='block_tel_end']").eq(index).val() == "")
                    ) {
                        alert("기간을 입력해 주세요");
                        tcnt++;
                    }
                });
                var block = $("input:checkbox[name=block]").is(":checked")==false
                var none = $("input:checkbox[name=none]").is(":checked")==false
                var Tel = $("input:checkbox[name=Tel]").is(":checked")==false
                if($("input:checkbox[name^=custom_price_season]:checked").length<1) {
                    alert("1개 이상의 객실을 선택해주세요");
                    tcnt++;
                }else if(block==true && none==true && Tel==true ){
                    alert("기능 선택을 체크 해주세요");
                    tcnt++;
                }

                if(tcnt >0 ){
                    return false;
                }else{
                    return true;
                }
            })
        });

        $("input[name='all_check[]']").click(function () {

            if($(this).prop("checked")===true){
                $("input[name^='custom_price_season["+$(this).val()+"]']").prop("checked",true);
                $('.button').show();
                $("input[name='block']").focus();
                $('#block_tel_show').hide();
                $('.submit2').hide();
            }else{
                $("input[name^='custom_price_season["+$(this).val()+"]']").prop("checked",false);
                $('.button').hide();
            }

        });

        $(function () {
            $("#no_block_tel_add").click(function () {
                $(this).parent().append("<p><input type='date' name='no_block_tel[]' /></p>");
            })
        })

        <?php $__currentLoopData = $room; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            $("input[name='block_tel_all_check']").click(function () {
                if($(this).prop("checked")==true){
                    $("input[name^='custom_price_season[<?php echo e($r->id); ?>]']").prop("checked",true);
                }else{
                    $("input[name^='custom_price_season[<?php echo e($r->id); ?>]']").prop("checked",false);
                }
            });
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        var block_tel_start = $('block_tel_start').val();
        if(block_tel_start != ""){
            $('.button').hide();
        }

    });
</script>
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
        $now_year = date("Y");
        $now_month = date("m");
        $now = date("d");
    ?>
    <div style="margin:0 auto; text-align:center; ">
        <a href="<?php echo e(url()->current()); ?>?year=<?php echo e(date("Y",$prevMonth)); ?>&month=<?php echo e(date("n",$prevMonth)); ?>">◀</a>
        <?php echo e(date("Y-m",$curDate)); ?>

        <a href="<?php echo e(url()->current()); ?>?year=<?php echo e(date("Y",$nextMonth)); ?>&month=<?php echo e(date("n",$nextMonth)); ?>">▶</a>
    </div>
    <form method="post" name="frmCalendarPrice" id="frmCalendarPrice" action="<?php echo e(url()->current()); ?>">
        <?php echo e(csrf_field()); ?>

        <a id='block_tel' class="mr-2 btn btn-focus">기간지정방막기/전화</a>
        <div id="block_tel_show">
            <div>기간 선택</div>
            <div><input type="date" name="block_tel_start">~<input type="date" name="block_tel_end"></div>
            <div>제외 날짜</div>
            <div><input type="date" name="no_block_tel[]"><a id="no_block_tel_add">추가</a></div>
            <div>기능 선택</div>
            <div>
                <input type="checkbox" name="block" value="B"><a class="mr-2 btn btn-focus">방막기</a>
                <input type="checkbox" name="none" value="N"><a class="mr-2 btn btn-focus">방열기</a>
                <input type="checkbox" name="Tel" value="T"><a class="mr-2 btn btn-focus">전화 문의</a>
            </div>
            <div>객실선택</div>
            <div><input type="checkbox" name="block_tel_all_check"> 전체 선택 </div>
            <?php $__currentLoopData = $room; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div><input type="checkbox" name="custom_price_season[<?php echo e($r->id); ?>]"><?php echo e($r->room_name); ?></div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
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
                    <?php if($i==$now && $now_month==date("m",$curDate) && $now_year==date("Y",$curDate)): ?>
                        <td style="border:1px solid #888; background: navajowhite">
                    <?php else: ?>
                        <td style="border:1px solid #888; ">
                    <?php endif; ?>
                        <?php echo e($i); ?>

                        <input type="checkbox" name="all_check[]" value="<?php echo e(date("Y-m-".sprintf("%02d",$i),$curDate)); ?>" />
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
                                $flag = \App\Models\BlockTable::where('day',date("Y-m-".sprintf("%02d",$i),$curDate))->where('room_id',$r->id)->first();
                                if (isset($flag)){
                                    $flags = $flag->flag;
                                }
                            ?>
                            <p>
                                <?php if(isset($flag)): ?>
                                    <input type="checkbox" name="custom_price_season[<?php echo e(date("Y-m-".sprintf("%02d",$i),$curDate)); ?>][<?php echo e($r->id); ?>]">
                                    <?php if($flags=="B"): ?>
                                        <p style="color: green">방막기</p>
                                    <?php elseif($flags=="T"): ?>
                                        <p style="color: brown">전화문의</p>
                                    <?php endif; ?>
                                    <?php echo e($r->room_name); ?>

                                <?php else: ?>
                                    <input type="checkbox" name="custom_price_season[<?php echo e(date("Y-m-".sprintf("%02d",$i),$curDate)); ?>][<?php echo e($r->id); ?>]">
                                    <p style="color: gray">방열기</p>
                                    <?php echo e($r->room_name); ?>

                                <?php endif; ?>
                            </p>
                            <script>
                                $("input[name^='custom_price_season[<?php echo e(date("Y-m-".sprintf("%02d",$i),$curDate)); ?>][<?php echo e($r->id); ?>]']").click(function () {

                                    if($(this).is(":checked")==true){
                                        console.log("show");
                                        $('.button').show();
                                        $("input[name='block']").focus();
                                        $('#block_tel_show').hide();
                                    }else{
                                        console.log("hide");
                                        $('.button').hide();
                                    }

                                })
                            </script>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </td>
                    <?php if($y%7==6): ?> </tr> <?php endif; ?>
            <?php endfor; ?>

            <?php for($i=$y%7,$k=1; $i<7; $i++,$k++): ?>
                <td style="border:1px solid #888; "><?php echo e("+".$k); ?></td>
                <?php if($i%7==6): ?> </tr> <?php endif; ?>
            <?php endfor; ?>
        </table>
        <div class="button">
            <input type="checkbox" name="block" value="B"><a class="mr-2 btn btn-focus">방막기</a>
            <input type="checkbox" name="none" value="N"><a class="mr-2 btn btn-focus">방열기</a>
            <input type="checkbox" name="Tel" value="T"><a class="mr-2 btn btn-focus">전화 문의</a>
            <button type="submit" class="mr-2 btn btn-focus submit1">변경</button>
        </div>
        <button type="submit" class="mr-2 btn btn-focus submit2">변경</button>
    </form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make("admin.pc.layout.basic", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/www/real_resarvation/resources/views/admin/pc/client/client_block.blade.php ENDPATH**/ ?>