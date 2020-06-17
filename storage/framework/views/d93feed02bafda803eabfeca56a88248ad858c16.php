<?php $__env->startSection("title"); ?>코드관리<?php $__env->stopSection(); ?>

<?php $__env->startSection("scripts"); ?>
    <script>
        $(function(){
            $(".list-code").click(function(){
                // $(this).data("depth");
                // $(this).data("id");
                $.post(
                    "<?php echo e(route('config.code.call')); ?>"
                    ,{
                        id: $(this).data("id")
                        , depth: $(this).data("depth")
                    }
                    ,function(data){
                        console.log(data);
                        if(data.code==200){
                            var item = data.info;
                            $("select[name=up_id]").val(item.up_id);
                            $("#id").val(item.id);
                            $("#code").val(item.code);
                            $("#code_name").val(item.code_name);
                            $("#simple").val(item.simple);
                            $("input[name=flag_use][value="+item.flag_use+"]").prop("checked",true);
                            $("input[name=flag_view][value="+item.flag_view+"]").prop("checked",true);
                        }
                        else {
                            alert(data.message);
                        }
                    }
                )
            })
        });
    </script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection("styles"); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection("contents"); ?>
    <div style="float:left; width:400px; ">
        <input type="button" value="추가" onclick="frmReset('frmCodeSave'); " />
        <ul>
        
        <?php $__currentLoopData = $codeList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li>
                <span class="list-code" data-depth="<?php echo e($c['info']->depth); ?>" data-id="<?php echo e($c['info']->id); ?>"><?php echo e($c['info']->code."::".$c['info']->code_name); ?></span>
                
                <?php if(isset($c['sub'])): ?>
                <ul>
                <?php $__currentLoopData = $c['sub']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k2 => $c2): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li>
                        <span class="list-code" data-depth="<?php echo e($c2['info']->depth); ?>" data-id="<?php echo e($c2['info']->id); ?>"><?php echo e($c2['info']->code."::".$c2['info']->code_name); ?></span>
                        
                        <?php if(isset($c2['sub'])): ?>
                            <ul>
                                <?php $__currentLoopData = $c2['sub']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k3 => $c3): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li>
                                        <span class="list-code" data-depth="<?php echo e($c3['info']->depth); ?>" data-id="<?php echo e($c3['info']->id); ?>"><?php echo e($c3['info']->code."::".$c3['info']->code_name); ?></span>
                                        
                                        <?php if(isset($c3['sub'])): ?>
                                            <ul>
                                                <?php $__currentLoopData = $c3['sub']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k4 => $c4): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <li>
                                                        <span class="list-code" data-depth="<?php echo e($c4['info']->depth); ?>" data-id="<?php echo e($c4['info']->id); ?>"><?php echo e($c4['info']->code."::".$c4['info']->code_name); ?></span>
                                                    </li>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </ul>
                                        <?php endif; ?>
                                    </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        <?php endif; ?>
                    </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
                <?php endif; ?>
            </li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    </div>

    <div style="float:left; width:400px; ">
        <form method="post" name="frmCodeSave" action="<?php echo e(url()->current()); ?>">
            <?php echo e(csrf_field()); ?>

            <input type="hidden" name="id" id="id" />
            <div>
                상위카테고리
                <select name="up_id">
                    <option value="">::선택::</option>
                    <?php $__currentLoopData = $codeList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($c['info']->id); ?>"><?php echo e($c['info']->code."::".$c['info']->code_name); ?></option>
                        
                        <?php if(isset($c['sub'])): ?>
                        <?php $__currentLoopData = $c['sub']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k2 => $c2): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($c2['info']->id); ?>">&nbsp;-&nbsp;<?php echo e($c2['info']->code."::".$c2['info']->code_name); ?></option>
                            
                            <?php if(isset($c2['sub'])): ?>
                            <?php $__currentLoopData = $c2['sub']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k3 => $c3): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($c3['info']->id); ?>" style="padding-left:15px; ">&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;<?php echo e($c3['info']->code."::".$c3['info']->code_name); ?></option>
                                
                                <?php if(isset($c3['sub'])): ?>
                                <?php $__currentLoopData = $c3['sub']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k4 => $c4): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($c4['info']->id); ?>" style="padding-left:15px; ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;<?php echo e($c4['info']->code."::".$c4['info']->code_name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div>코드: <input type="text" name="code" id="code" /></div>
            <div>코드명: <input type="text" name="code_name" id="code_name" /></div>
            <div>설명: <input type="text" name="simple" id="simple" /></div>
            <div>
                사용여부:
                <input type="radio" name="flag_use" id="flag_use_Y" value="Y" checked />사용함
                <input type="radio" name="flag_use" id="flag_use_N" value="N" />사용안함
            </div>
            <div>
                노출여부:
                <input type="radio" name="flag_view" id="flag_view_Y" value="Y" checked />노출
                <input type="radio" name="flag_view" id="flag_view_N" value="N" />노출안함
                (카테고리만 적용 중)
            </div>
            <input type="submit" value="저장" />
        </form>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make("admin.pc.layout.basic", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/www/real_resarvation/resources/views/admin/pc/config/code_list.blade.php ENDPATH**/ ?>