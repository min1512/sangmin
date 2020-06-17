<script>
    function test1() {
        var data_season_start = new Array();
        var data_season_end = new Array();
        <?php $__currentLoopData = $season_term_all; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        data_season_start.push('<?php echo e($v->season_start); ?>');
        data_season_end.push('<?php echo e($v->season_end); ?>');
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        console.log(data_season_start);
        console.log(data_season_end);
        console.log('test');
        var tcnt1 = 0;
        var tcnt3 = 0;
        $("input[name^='season_start']").each(function (index) {
            if(
                ($("input[name^='season_start']").eq(index).val() >= $("input[name^='season_end']").eq(index).val())
            ){
                if (tcnt3 < 1) alert("날짜 입력이 잘못 되었습니다.");
                tcnt3++;
            }else if(
                ($("input[name^='season_start']").eq(index).val()=="" || $("input[name^='season_end']").eq(index).val()=="")
            ){
                if (tcnt3 < 1) alert("날짜를 입력해주세요");
                tcnt3++;
            }

            for(var i in data_season_end){
                console.log($(this).val()+" :: "+data_season_start[i]+" :: "+tcnt1);
                if(
                    ($(this).val() <= data_season_end[i] && $(this).val() >= data_season_start[i])
                    ||
                    ($("input[name^='season_end']").eq(index).val() >= data_season_start[i] && $("input[name^='season_end']").eq(index).val() <= data_season_end[i])
                ){
                    if(tcnt3!=1) {
                        if (tcnt1 < 1) alert('입력한 시즌이 중복됩니다.');
                        tcnt1++;
                    }
                }
            }
            console.log(tcnt1);
            console.log(tcnt3);
        });
        <?php
            $path = $_SERVER["HTTP_HOST"];
            $path = explode(".",$path);
        ?>

        var client = "client";
        var staff = "staff";
        var path = <?php echo e($path[0]); ?>;
        if(client == <?php echo e($path[0]); ?>) {
            if (tcnt1 < 1 && tcnt3 < 1) {
                $("form[name=add_seasons]").attr("action", '/info/season_add').submit();
                return true;
            } else {
                return false;
            }
        }else if(staff == <?php echo e($path[0]); ?>){
            if (tcnt1 < 1 && tcnt3 < 1) {
                $("form[name=add_seasons]").attr("action", '/price/season/save').submit();
                return true;
            } else {
                return false;
            }
        }
    };
    $(function () {
        $("#season_add").click(function () {
            $(this).parent().parent().parent().append("<tr>" +
                "<td>시작 시간</td>" +
                "<td><input type='date' name='season_start[]'></td>" +
                "</tr>"+
                "<tr>"+
                "<td>끝 시간</td>" +
                "<td><input type='date' name='season_end[]'></td>" +
                "</tr>"
            );
        })
    })
</script>
<div class="row">
    <div class="main-card mb-3 card" style="width:100%; ">
        <div class="card-body"><h5 class="card-title">Season List</h5>
            <table class="mb-0 table table-hover" style="width: 1000px;" >
                <?php
                    $path = $_SERVER["HTTP_HOST"];
                    $path = explode(".",$path);
                    if($path[0]=="staff"){
                        $PATH= $curPathstaff."/".$user_id;
                        $SubmitPath= '/price/season/del';
                    }else{
                        $PATH = $curPath;
                        $SubmitPath = '/info/season_delete';
                    }
                ?>
                <form name="season_table" method="post" action="<?php echo e($SubmitPath); ?>">
                    <input type="hidden" name="user_id" value="<?php echo e(isset($user_id)?$user_id:""); ?>" />
                    <?php echo e(csrf_field()); ?>

                    <tr>
                        <th><a id="all_season" href="<?php echo e($PATH); ?>">전체 요금표</a></th>
                        <th><a id="no_season" href="<?php echo e($PATH); ?>/0">비수기</a></th>
                        <?php $__currentLoopData = $seasonList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <th>
                                <input type="checkbox" name="season_id[]" id="season_id" value="<?php echo e($s->id); ?>">
                                <a id="season_show" href="<?php echo e($PATH); ?>/<?php echo e($s->id); ?>"><?php echo e($s->season_name); ?></a>
                            </th>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <th><a id="add_season" name="add_season" class="mr-2 btn btn-info" style="color: black;">시즌 추가</a></th>
                        <th><button class="mr-2 btn btn-info">시즌 삭제</button></th>
                    </tr>
                </form>

                <tr>
                    <th id="add_season_list">
                        <form method='post' name='add_seasons' class='client_form' >
                            <?php echo e(csrf_field()); ?>

                            <input type='hidden' name='user_id' value="<?php echo e(isset($user_id)?$user_id:""); ?>">
                            <table>
                                <?php $__currentLoopData = $season_term; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $st): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td>시즌명</td>
                                    <?php
                                        $season_name = \App\Models\ClientSeason::where('id',$st->season_id)->value('season_name');
                                    ?>
                                    <td><input type="hidden" name="season_name" value="<?php echo e(isset($season_term)?$season_name:""); ?>"></td>
                                    <td><?php echo e(isset($season_term)?$season_name:""); ?></td>
                                </tr>
                                <tr>
                                    <td>시작 기간</td>
                                    <td><input type='date' id='season_start' name='season_start[]' value="<?php echo e(isset($season_term)?$st->season_start:""); ?>" /></td>
                                </tr>
                                <tr>
                                    <td>끝 기간</td>
                                    <td><input type='date' id='season_end' name='season_end[]' value="<?php echo e(isset($season_term)?$st->season_end:""); ?>" /></td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><button type='button' onclick='test1()' class="mt-1 btn season_save" >저장</button></td>
                                    <td><a id="season_add">시즌 기간 추가</a></td>
                                </tr>
                            </table>
                        </form>
                    </th>
                </tr>

            </table>
        </div>
    </div>
</div>
<?php /**PATH /home/www/real_resarvation/resources/views/admin/pc/include/price/season_list.blade.php ENDPATH**/ ?>