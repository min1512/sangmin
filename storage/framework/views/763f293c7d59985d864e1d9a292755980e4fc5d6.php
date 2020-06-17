<?php $__env->startSection("title"); ?>숙박업소관리-연박설정<?php $__env->stopSection(); ?>

<?php $__env->startSection("styles"); ?>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<?php $__env->stopSection(); ?>

<?php $__env->startSection("scripts"); ?>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
        function callOver(type, id) {
            $.post(
                "<?php echo e(route('client.over.call',['id'=>$id])); ?>"
                , { _token: '<?php echo e(csrf_token()); ?>', id: id }
                , function(data){
                    $("button.info_over[data-over="+type+"]").click();
                    $("input#id").val(data.id);
                    $("input#over_start").val(data.over_start);
                    $("input#over_end").val(data.over_end);
                    var tmp_day = data.target_day;
                    if(tmp_day!=null) {
                        var tmp_day2 = tmp_day.split(',');
                        $("input[name^='target_day[]']").each(function () {
                            if ($.inArray($(this).val(), tmp_day2)!=-1) $(this).prop("checked", true);
                            else $(this).prop("checked", false);
                        });
                    }
                    $("select#over_day").val(data.over_day);
                    var tmp_room = data.room_id;
                    if(tmp_room!=null) {
                        var tmp_room2 = tmp_room.split(',');
                        $("input[name^='room[]']").each(function () {
                            if ($.inArray($(this).val(), tmp_room2)!=-1) $(this).prop("checked", true);
                            else $(this).prop("checked", false);
                        });
                    }

                    $("input#over_discount_name").val(data.over_discount_name);
                    $("input#over_discount_start").val(data.over_discount_start);
                    $("input#over_discount_end").val(data.over_discount_end);
                    $("select#over_discount_type").val(data.over_discount_type);
                    $("input#over_discount_price").val(data.over_discount_price);
                    $("select#over_discount_unit").val(data.over_discount_unit);
                }
                , "json"
            )
        }
        $(function(){
            $(".info_over").click(function(){
                var html = "";
                html += "<form method='post' name='frmOver' action='<?php echo e(route('client.over',['id'=>$id])); ?>'>";
                html += "<input type='hidden' name='_token' value='<?php echo e(csrf_token()); ?>' />";
                html += "<input type='hidden' name='over_type' value='"+$(this).data("over")+"' />";
                html += "<input type='hidden' name='id' id='id' value='' />";
                if($(this).data("over")=="O"){
                    html += "<div style='padding:10px; '>";
                    html += "<div>연박등록</div>";
                    html += "<div>기간선택<input type='date' name='over_start' id='over_start' />~<input type='date' name='over_end' id='over_end' /></div>";
                    html += "<div>";
                    html += "<p style='display:inline; '><input type='checkbox' name='target_day[]' value='0' />일</p>";
                    html += "<p style='display:inline; '><input type='checkbox' name='target_day[]' value='1' />월</p>";
                    html += "<p style='display:inline; '><input type='checkbox' name='target_day[]' value='2' />화</p>";
                    html += "<p style='display:inline; '><input type='checkbox' name='target_day[]' value='3' />수</p>";
                    html += "<p style='display:inline; '><input type='checkbox' name='target_day[]' value='4' />목</p>";
                    html += "<p style='display:inline; '><input type='checkbox' name='target_day[]' value='5' />금</p>";
                    html += "<p style='display:inline; '><input type='checkbox' name='target_day[]' value='6' />토</p>";
                    html += "</div>";
                    html += "<div>연박일수 위 기간동안 ";
                    html += "<select name='over_day' id='over_day'>";
                    for(var i=0; i<10; i++){
                        html += "<option value='"+i+"'>"+i+"</option>";
                    }
                    html += "</select>";
                    html += "이상만 숙박 가능</div>";
                    html += "<div>객실선택";
                    html += "<input type='checkbox' name='allCheck' />전체객실";
                    <?php $__currentLoopData = $room; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        html += "<p style='display:inline; '><input type='checkbox' name='room[]' value='<?php echo e($r->id); ?>' /><?php echo e($r->room_name); ?></p>";
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        html += "</div>";
                    html += "<p><button type='submit'>저장</button></p>";
                    html += "</div>";
                }
                else if($(this).data("over")=="D"){
                    html += "<div style='padding:10px; '>";
                    html += "<div>연박할인등록</div>";
                    html += "<div>할인명<input type='text' name='over_discount_name' id='over_discount_name' /></div>";
                    html += "<div>예약기간<input type='text' name='over_discount_start' id='over_discount_start' />~<input type='text' name='over_discount_end' id='over_discount_end' /></div>";
                    html += "<div>할인적용기간<input type='date' name='over_start' id='over_start' />~<input type='date' name='over_end' id='over_end' /></div>";
                    html += "<div>";
                    html += "<p style='display:inline; '><input type='checkbox' name='target_day[]' value=0 />일</p>";
                    html += "<p style='display:inline; '><input type='checkbox' name='target_day[]' value=1 />월</p>";
                    html += "<p style='display:inline; '><input type='checkbox' name='target_day[]' value=2 />화</p>";
                    html += "<p style='display:inline; '><input type='checkbox' name='target_day[]' value=3 />수</p>";
                    html += "<p style='display:inline; '><input type='checkbox' name='target_day[]' value=4 />목</p>";
                    html += "<p style='display:inline; '><input type='checkbox' name='target_day[]' value=5 />금</p>";
                    html += "<p style='display:inline; '><input type='checkbox' name='target_day[]' value=6 />토</p>";
                    html += "</div>";
                    html += "<div>연박일수 위 기간동안 ";
                    html += "<select name='over_day'>";
                    for(var i=0; i<10; i++){
                        html += "<option value='"+i+"'>"+i+"</option>";
                    }
                    html += "</select>";
                    html += "이상만 숙박 가능</div>";

                    html += "<div>할인내용 ";
                    html += "<select name='over_discount_type' id='over_discount_type'>";
                    html += "<option value='ALL'>총객실가</option>";
                    html += "<option value='PER'>객실가(박)</option>";
                    html += "</select>";
                    html += "<input type='text' name='over_discount_price' id='over_discount_price' />";
                    html += "<select name='over_discount_unit' id='over_discount_unit'>";
                    html += "<option value='원'>원</option>";
                    html += "<option value='%'>%</option>";
                    html += "</select>";
                    html += "</div>";

                    html += "<div>객실선택";
                    html += "<input type='checkbox' name='allCheck' />전체객실";
                    <?php $__currentLoopData = $room; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        html += "<p style='display:inline; '><input type='checkbox' name='room[]' value='<?php echo e($r->id); ?>' /><?php echo e($r->room_name); ?></p>";
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        html += "</div>";
                    html += "<p><button type='submit'>저장</button></p>";
                    html += "</div>";
                }
                html += "</form>";

                $("#over_window").show().html(html).draggable();
            });
        })
    </script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection("contents"); ?>
    <p>연박만 받기설정</p>
    <table>
        <thead>
        <tr>
            <td>번호</td>
            <td>객실</td>
            <td>연박적용기간</td>
            <td>연박일수</td>
        </tr>
        </thead>
        <tbody>
        <?php $__currentLoopData = $over; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $o): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr style="cursor:pointer; " onclick="callOver('O','<?php echo e($o->id); ?>')">
            <td><?php echo e($o->id); ?></td>
            <td>객실</td>
            <td><?php echo e($o->over_start); ?> ~ <?php echo e($o->over_end); ?> (대상요일:<?php echo e($o->target_day); ?>)</td>
            <td><?php echo e($o->over_day); ?></td>
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
    <div style="text-align:right; "><button type="button" class="info_over" data-over="O">연박만 받기 등록</button></div>
    <?php echo e($over->appends(['over'=>$over->currentPage(), 'discount'=>$discount->currentPage()])->links()); ?>

    <p style="margin-top:20px; ">연박 할인 설정</p>
    <table>
        <thead>
        <tr>
            <td>할인명</td>
            <td>예약기간</td>
            <td>연박적용기간</td>
            <td>연박일수</td>
        </tr>
        </thead>
        <tbody>
        <?php $__currentLoopData = $discount; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr style="cursor:pointer; " onclick="callOver('D','<?php echo e($d->id); ?>')">
                <td><?php echo e($d->over_discount_name); ?></td>
                <td><?php echo e($d->over_discount_start); ?> ~ <?php echo e($d->over_discount_end); ?></td>
                <td><?php echo e($o->over_start); ?> ~ <?php echo e($o->over_end); ?> (대상요일:<?php echo e($o->target_day); ?>)</td>
                <td><?php echo e($o->over_day); ?></td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
    <div style="text-align:right; "><button type="button" class="info_over" data-over="D">연박할인</button></div>
    <?php echo e($discount->appends(['over'=>$over->currentPage(), 'discount'=>$discount->currentPage()])->links()); ?>

    <div id="over_window" style="position:absolute; left:100px; top:100px; background-color:#fff; display:none; ">
        여기정보
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make("admin.pc.layout.basic", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/www/real_resarvation/resources/views/admin/pc/client/client_over.blade.php ENDPATH**/ ?>