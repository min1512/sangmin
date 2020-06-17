<?php $__env->startSection("title"); ?>권한설정<?php $__env->stopSection(); ?>

<?php $__env->startSection("scripts"); ?>
    <script>
        function onclickRadio(obj) {
            var tmp_permit = $(obj).val();
            if(tmp_permit=="all") $("table.user_permit_list tr").show();
            else {
                $("table.user_permit_list").find("tbody tr").each(function () {
                    if ($(this).find("td").data("permit") == tmp_permit) $(this).show();
                    else $(this).hide();
                });
            }
        }

        $(function(){
            $("table.user_permit_list tbody").find("tr td a").click(function(){
                $.post(
                    "<?php echo e(route('config.permit.info')); ?>"
                    , { id: $(this).data("id") }
                    , function(data){
                        $("input[name^='permit[']").each(function(){
                            $(this).prop("checked",false);
                        });
                        $("input[name=permit_id]").val(data.id);
                        $("input[name=permit_name]").val(data.info.permit_name);
                        $("select[name=permit_type]").val(data.info.code_user_type);
                        for(var i=0; i<data.permit.length; i++){
                            if(data.permit[i].list=="Y")   $("#permit_"+data.permit[i].code_admin+"_list").prop("checked",true);
                            if(data.permit[i].write=="Y")  $("#permit_"+data.permit[i].code_admin+"_save").prop("checked",true);
                            if(data.permit[i].view=="Y")   $("#permit_"+data.permit[i].code_admin+"_view").prop("checked",true);
                            if(data.permit[i].delete=="Y") $("#permit_"+data.permit[i].code_admin+"_del").prop("checked",true);
                        }
                    }
                    , "json"
                )
            });
            $("input.add_new").click(function(){
                $("input[name=permit_id]").val("");
                $("input[name=permit_name]").val("");
                $("select[name=permit_type]").val("");
                $("input[name^='permit[']").each(function(){
                    $(this).prop("checked",false);
                });
            });
        });
    </script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection("styles"); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection("contents"); ?>
    <div style="float:left; width:200px; margin-right:10px; ">
        <input type="radio" name="list_user_type" id="list_all" class="small" value="all" onclick="onclickRadio(this)" checked />
        <label for="list_all">전체</label>

        <input type="radio" name="list_user_type" id="list_staff" class="small" value="user_staff" onclick="onclickRadio(this)" />
        <label for="list_staff">관리자</label>

        <input type="radio" name="list_user_type" id="list_agency" class="small" value="user_agency" onclick="onclickRadio(this)" />
        <label for="list_agency">대행사</label>

        <input type="radio" name="list_user_type" id="list_client" class="small" value="user_client" onclick="onclickRadio(this)" />
        <label for="list_client">숙박업체</label>

        <table class="default user_permit_list" cellpadding="0" cellspacing="0">
            <thead>
            <tr>
                <td>사용자</td>
            </tr>
            </thead>
            <tbody>
            <?php $__currentLoopData = $list_permit; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td data-permit="<?php echo e($lp->code_user_type); ?>"><a href="javascript://" data-id="<?php echo e($lp->id); ?>"><?php echo e($lp->permit_name); ?></a></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>

        <button type="button" class="btn_gray_00 add_new">신규추가</button>
    </div>
    <div style="float:left; width:450px; margin-right:10px; ">
    <form method="post" name="frmPermitInfo" action="<?php echo e(url()->current()); ?>">
        <?php echo e(csrf_field()); ?>

        <input type="hidden" name="permit_id" />
        권한명칭: <input type="text" name="permit_name" class="default" />
        <select name="permit_type" class="default">
            <option value="">::선택::</option>
            <option value="user_staff">관리자</option>
            <option value="user_agency">대행사</option>
            <option value="user_client">숙박업체</option>
        </select>
        <button type="submit" class="btn_gray_00">저장</button>
        <table class="default user_permit_list" cellpadding="0" cellspacing="0">
            <thead>
            <tr>
                <td>메뉴명</td>
                <td>목록</td>
                <td>보기</td>
                <td>저장</td>
                <td>삭제</td>
            </tr>
            </thead>
            <tbody>
            <?php $__currentLoopData = $menu_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ml): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($ml['name']); ?></td>
                <td>
                    <input type="checkbox" name="permit[<?php echo e($ml['code']); ?>][list]" id="permit_<?php echo e($ml['code']); ?>_list" value="Y" class="small" />
                    <label for="permit_<?php echo e($ml['code']); ?>_list">목록</label>
                </td>
                <td>
                    <input type="checkbox" name="permit[<?php echo e($ml['code']); ?>][view]" id="permit_<?php echo e($ml['code']); ?>_view" value="Y" class="small" />
                    <label for="permit_<?php echo e($ml['code']); ?>_view">보기</label>
                </td>
                <td>
                    <input type="checkbox" name="permit[<?php echo e($ml['code']); ?>][save]" id="permit_<?php echo e($ml['code']); ?>_save" value="Y" class="small" />
                    <label for="permit_<?php echo e($ml['code']); ?>_save">저장</label>
                </td>
                <td>
                    <input type="checkbox" name="permit[<?php echo e($ml['code']); ?>][del]" id="permit_<?php echo e($ml['code']); ?>_del" value="Y" class="small" />
                    <label for="permit_<?php echo e($ml['code']); ?>_del">삭제</label>
                </td>
            </tr>
            <?php if(isset($ml['sub'])): ?>
                <?php $__currentLoopData = $ml['sub']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mls): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td>-<?php echo e($mls['name']); ?></td>
                        <td>
                            <input type="checkbox" name="permit[<?php echo e($mls['code']); ?>][list]" id="permit_<?php echo e($mls['code']); ?>_list" value="Y" class="small" />
                            <label for="permit_<?php echo e($mls['code']); ?>_list">목록</label>
                        </td>
                        <td>
                            <input type="checkbox" name="permit[<?php echo e($mls['code']); ?>][view]" id="permit_<?php echo e($mls['code']); ?>_view" value="Y" class="small" />
                            <label for="permit_<?php echo e($mls['code']); ?>_view">보기</label>
                        </td>
                        <td>
                            <input type="checkbox" name="permit[<?php echo e($mls['code']); ?>][save]" id="permit_<?php echo e($mls['code']); ?>_save" value="Y" class="small" />
                            <label for="permit_<?php echo e($mls['code']); ?>_save">저장</label>
                        </td>
                        <td>
                            <input type="checkbox" name="permit[<?php echo e($mls['code']); ?>][del]" id="permit_<?php echo e($mls['code']); ?>_del" value="Y" class="small" />
                            <label for="permit_<?php echo e($mls['code']); ?>_del">삭제</label>
                        </td>
                    </tr>
                    <?php if(isset($mls['sub'])): ?>
                        <?php $__currentLoopData = $mls['sub']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mlss): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td>--<?php echo e($mlss['name']); ?></td>
                                <td>
                                    <input type="checkbox" name="permit[<?php echo e($mlss['code']); ?>][list]" id="permit_<?php echo e($mlss['code']); ?>_list" value="Y" class="small" />
                                    <label for="permit_<?php echo e($mlss['code']); ?>_list">목록</label>
                                </td>
                                <td>
                                    <input type="checkbox" name="permit[<?php echo e($mlss['code']); ?>][view]" id="permit_<?php echo e($mlss['code']); ?>_view" value="Y" class="small" />
                                    <label for="permit_<?php echo e($mlss['code']); ?>_view">보기</label>
                                </td>
                                <td>
                                    <input type="checkbox" name="permit[<?php echo e($mlss['code']); ?>][save]" id="permit_<?php echo e($mlss['code']); ?>_save" value="Y" class="small" />
                                    <label for="permit_<?php echo e($mlss['code']); ?>_save">저장</label>
                                </td>
                                <td>
                                    <input type="checkbox" name="permit[<?php echo e($mlss['code']); ?>][del]" id="permit_<?php echo e($mlss['code']); ?>_del" value="Y" class="small" />
                                    <label for="permit_<?php echo e($mlss['code']); ?>_del">삭제</label>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </form>
    </div>
    <div style="float:left; width:350px; ">
    <form method="post" name="frmPermitUser" action="<?php echo e(route('config.permit.user')); ?>">
        <?php echo e(csrf_field()); ?>

        <table class="default user_permit_list" cellpadding="0" cellspacing="0">
            <thead>
            <tr>
                <td>회원구분</td>
                <td>업체명</td>
                <td>권한</td>
            </tr>
            </thead>
            <tbody>
            <?php $__currentLoopData = $user_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ui): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr style="list-style:none; ">
                <td><?php echo e($ui->type=="staff"?"관리자":($ui->type=="agency"?"대행사":($ui->type=="client"?"숙박업체":""))); ?></td>
                <td><?php echo e($ui->user_name); ?></td>
                <td>
                    <select name="user_permit[<?php echo e($ui->type); ?>][<?php echo e($ui->id); ?>]" class="default">
                        <option value="0">::권한없음::</option>
                        <?php $__currentLoopData = $list_permit; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if($lp->code_user_type=="user_".$ui->type): ?>
                            <option value="<?php echo e($lp->id); ?>" <?php echo e($lp->id==$ui->permit_id?"selected":""); ?>><?php echo e($lp->permit_name); ?></option>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
        <button type="submit" class="btn_gray_00">저장</button>
    </form>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make("admin.pc.layout.basic", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/www/real_resarvation/resources/views/admin/pc/config/permit_list.blade.php ENDPATH**/ ?>