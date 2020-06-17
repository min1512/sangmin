<?php $__env->startSection("title"); ?>할인 판매 추가/수정<?php $__env->stopSection(); ?>

<?php $__env->startSection("scripts"); ?>

    <script>


        function check_all(){
            var tcnt = 0;
            var tcnt1 = 0;
            var tcnt3 = 0;
            if($("input[name^='what_date']:checked").val()=="Y"){
                        var checked = $("input:checkbox[name^=no_right_now_id]:checked").length;
                        if(checked == ""){
                            alert("기간참조에 시즌 선택 해주세요");
                            tcnt++;
                        }else if($("input[name='discount_name']").val()==""){
                            alert("할인명을 입력하세요");
                            tcnt++;
                        }else if($("input:checkbox[name='day[]']:checked").length<1) {
                            alert("요일을 선택해주세요");
                            tcnt++;
                        }
                        else if($("input:checkbox[id^=room_id_]:checked").length<1) {
                            alert("1개 이상의 객실을 선택해주세요");
                            tcnt++;
                        }
                        else if($("input[name='start_season']").val()==""){
                            alert("기간 시작일을 입력해주세요");
                            tcnt++;
                        }
                        else if($("input[name='end_season']").val()==""){
                            alert("기간 끝나는 날을 입력해주세요");
                            tcnt++;
                        }else if($("input[name='start_season']").val() > $("input[name='end_season']").val()){
                            alert("기간 입력이 잘못 되었습니다");
                            tcnt++;
                        }
                        else {
                            var tcnt = 0;
                            $("input:checkbox[id^=room_id_]:checked").each(function(){
                                if($("#discount_check_"+$(this).data("idx")).val()=="" && tcnt==0) {
                                    alert("객실 할인 또는 판매금액을 입력하세요");
                                    $("#discount_check_"+$(this).data("idx")).focus();
                                    tcnt++;
                                }
                            });
                        }
                        <?php
                            $path = $_SERVER["HTTP_HOST"];
                            $path = explode(".",$path);
                        ?>

                        var client = "client";
                        var staff = "staff";
                        var path = <?php echo e($path[0]); ?>

                        if(client == "<?php echo e($path[0]); ?>") {
                            if (tcnt < 1) {
                                $("form[name=discount_list]").attr("action", '/info/discount/save/<?php echo e(isset($did)?$did:""); ?>');
                                return true;
                            } else {
                                return false;
                            }
                        }else if(staff == "<?php echo e($path[0]); ?>"){
                            if (tcnt < 1) {
                                $("form[name=discount_list]").attr("action", '<?php echo e(url()->current()); ?>');
                                return true;
                            } else {
                                return false;
                            }
                        }
            }else if($("input[name^='what_date']:checked").val()=="N"){
                        var data_season_start = new Array();
                        var data_season_end = new Array();

                        <?php $__currentLoopData = $ClientDiscountTerm; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            data_season_start.push('<?php echo e($v->season_start); ?>');
                            data_season_end.push('<?php echo e($v->season_end); ?>');
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        var tcnt = 0;
                        var tcnt1 = 0;
                        var tcnt3 = 0;

                        $("input[name^='start_season']").each(function (index) {

                                if (
                                    ($("input[name^='start_season']").eq(index).val() > $("input[name^='end_season']").eq(index).val())
                                ) {
                                    if (tcnt3 < 1) {
                                        alert("기간 입력이 잘못 되었습니다.");
                                        tcnt3++;
                                        tcnt++;
                                        return false;
                                    }
                                } else if (
                                    ($("input[name^='start_season']").eq(index).val() == "" || $("input[name^='end_season']").eq(index).val() == "")
                                ) {
                                    if (tcnt3 < 1) {
                                        alert("기간을 입력해 주세요");
                                        tcnt3++;
                                        tcnt++;
                                        return false;
                                    }
                                } else if (
                                    ($("input[name^='date_ban']").eq(index).val() == "")
                                ) {
                                    if (tcnt3 < 1) {
                                        alert("제외 날짜를 입력해주세요");
                                        tcnt3++;
                                        tcnt++;
                                        return false;
                                    }
                                }

                                for(var i in data_season_end){
                                    console.log($(this).val()+" :: "+data_season_start[i]+" :: "+tcnt1);
                                    if(
                                        ($(this).val() <= data_season_end[i] && $(this).val() >= data_season_start[i])
                                        ||
                                        ($("input[name^='end_season']").eq(index).val() >= data_season_start[i] && $("input[name^='end_season']").eq(index).val() <= data_season_end[i])
                                    ){
                                        if(tcnt3!=1) {
                                            if (tcnt1 < 1){
                                                alert('입력한 기간은 중복됩니다.');
                                                tcnt1++;
                                                tcnt++;
                                                return false;
                                            }
                                        }
                                    }
                                }
                        });

                        if($("input[name='discount_name']").val()==""){
                            alert("할인명을 입력하세요");
                            tcnt++;
                        }else if($("input:checkbox[name='day[]']:checked").length<1) {
                            alert("요일을 선택해주세요");
                            tcnt++;
                        }
                        else if($("input:checkbox[id^=room_id_]:checked").length<1) {
                            alert("1개 이상의 객실을 선택해주세요");
                            tcnt++;
                        }
                        else if($("input[name='start_season']").val()==""){
                            alert("기간 시작일을 입력해주세요");
                            tcnt++;
                        }
                        else if($("input[name='end_season']").val()==""){
                            alert("기간 끝나는 날을 입력해주세요");
                            tcnt++;
                        }else if($("input[name='start_season']").val() > $("input[name='end_season']").val()){
                            alert("기간 입력이 잘못 되었습니다");
                            tcnt++;
                        }
                        else {
                            $("input:checkbox[id^=room_id_]:checked").each(function(){
                                if($("#discount_check_"+$(this).data("idx")).val()=="" && tcnt==0) {
                                    alert("객실 할인 또는 판매금액을 입력하세요");
                                    $("#discount_check_"+$(this).data("idx")).focus();
                                    tcnt++;
                                }
                            });
                        }
                <?php
                    $path = $_SERVER["HTTP_HOST"];
                    $path = explode(".",$path);
                ?>

                var client = "client";
                var staff = "staff";
                var path = <?php echo e($path[0]); ?>

                if(client == "<?php echo e($path[0]); ?>") {
                    if (tcnt < 1 && tcnt1 <1 && tcnt3 <1) {
                        $("form[name=discount_list]").attr("action", '/info/discount/save/<?php echo e(isset($did)?$did:""); ?>');
                        return true;
                    } else {
                        return false;
                    }
                }else if(staff == "<?php echo e($path[0]); ?>"){
                    if (tcnt < 1 && tcnt1 <1 && tcnt3 <1) {
                        $("form[name=discount_list]").attr("action", '<?php echo e(url()->current()); ?>');
                        return true;
                    } else {
                        return false;
                    }
                }
            }
        }

        $(function () {
            var db_ban_date = <?php echo e(isset($ClientSeason_date)&&$ClientSeason_date>0?sizeof($ClientSeason_date):""); ?>

            if(db_ban_date == 7){
                $("#day_all").prop("checked",true);
            }
            $("input[name^='day']").click(function () {
                $("input[name^='day']").each(function () {
                    oneCheck($(this));
                })
            })
        });

        function oneCheck(a){
            if($(a).prop("checked")){
                var checkBoxLength = $("input[name^='day']").length;
                var checkedLength = $("input[name^='day']:checked").length;
                if(checkBoxLength==checkedLength){
                    $("#day_all").prop("checked", true);
                }else{
                    $("#day_all").prop("checked", false);
                }
            }else{
                $("#day_all").prop("checked", false);
            }
        }

        function day(){
            if($("input:checkbox[name='day[]']:checked").length<1) {
                alert("요일을 선택해주세요");
                return false;
            }
            else if($("input:checkbox[id^=room_id_]:checked").length<1) {
                alert("1개 이상의 객실을 선택해주세요");
                return false;
            }
            else {
                var tcnt = 0;
                $("input:checkbox[id^=room_id_]:checked").each(function(){
                    if($("#discount_check_"+$(this).data("idx")).val()=="" && tcnt==0) {
                        alert("객실 할인 또는 판매금액을 입력하세요");
                        $("#discount_check_"+$(this).data("idx")).focus();
                        tcnt++;
                    }
                });
                console.log(tcnt);
                if(tcnt>0) return false;
                else return true;
            }
        }

        $(function () {
            $('#room_id_all').change(function () {
                if($(this).is(":checked")){
                    console.log("YES"+":::");
                    $("input[name^='room_id']").each(function () {
                        $(this).prop("checked",true);
                    });
                }else{
                    console.log("NO"+"::");
                    $("input[name^='room_id']").each(function () {
                        $(this).prop("checked",false);
                    });
                }
            });
            $('#day_all').change(function () {
                if($(this).is(":checked")){
                    console.log("YES"+":::");
                    $("input[name^='day']").each(function () {
                        $(this).prop("checked",true);
                    });
                }else{
                    console.log("NO"+"::");
                    $("input[name^='day']").each(function () {
                        $(this).prop("checked",false);
                    });
                }
            });
        });

        $(function () {
            $('#no_right_now_adds').hide();
            $("input[name='what_date']:radio").change(function () {
                var wha_date = $(this).val();
                if(wha_date=='N'){
                    console.log('No');
                    $("table.db_no_right_now_adds").hide();
                    $("div.db_right_now_add").show();
                }else if (wha_date=='Y') {
                    console.log('Yes');
                    $("div.db_right_now_add").hide();
                    $("table.db_no_right_now_adds").show();
                }
            });
        });
        $(function () {
            $(".season_delete").click(function () {
                $(this).parent("div").remove();
            });
            $('#date_ban_add_list').show();
            $('#date_ban_add').click(function () {
                $('#date_ban_add_list').append(
                    "<div>" +
                    "<input type='date' class='day' name='date_ban[]'>&nbsp;&nbsp;<a class='mt-1 btn btn-primary season_delete' style='color: black;'>X</a>" +
                    "</div>"
                );
                $(function () {
                    $(".season_delete").click(function () {
                        $(this).parent("div").remove();
                    });
                });
            });
            $(".db_right_now_delete").click(function () {
                $(this).parent("div").remove();
            });
            $('#right_now_add').click(function () {
                $('#db_right_now_add').append(
                    "<div>" +
                    "<input type='hidden' id='db_right_now_add_check' value='Y' />" +
                    "<input type='date' name='start_season[]'/>" +
                    "~" +
                    "<input type='date' name='end_season[]'/>&nbsp;&nbsp;<a class='mt-1 btn btn-primary db_right_now_delete' style='color: black;'>X</a>" +
                    "</div>"
                );
            });
            $(function () {
                $('#char').change(function () {
                    change_char();
                });
            });

            function change_char() {
                var abc = $("select[name=char]").val().split('|');
                console.log(abc);
                var tmp_unit = abc[0];
                var tmp_type = "할인";
                // if(abc[1]=="discount") var tmp_type = "할인"; else var tmp_type = "판매";
                $("[id^='change_char']").text(tmp_unit+" "+tmp_type);
            }
        });

    </script>
    <script>
        $(function(){
            <?php $__currentLoopData = $ClientDiscountTerm; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if($v->season_check=="N"): ?>
                    console.log(1);
                    $(":input:radio[name=what_date][value=N]").prop("checked",true);
                    $("table.db_no_right_now_adds").hide();
                    $("div.db_right_now_add").show();
                <?php elseif($v->season_check=="Y"): ?>
                    console.log(2);
                    console.log(<?php echo e($v->season_id); ?>);
                    $(":input:radio[name=what_date][value=Y]").prop("checked",true);
                    $("div.db_right_now_add").hide();
                    $("table.db_no_right_now_adds").show();
                    $("input[name^='no_right_now_id']").each(function(index,value){
                            console.log(999);
                            console.log($(this).attr("value"));
                        if($(this).attr("value") == <?php echo e(isset($v->season_id)?$v->season_id:0); ?>) {
                            console.log(":::");
                            $(this).prop("checked",true);
                        }
                    });
                <?php else: ?>
                    console.log(3);
                    $(":input:radio[name=what_date][value=Y]").prop("checked",true);
                    $("div.db_right_now_add").show();
                    $("table.db_no_right_now_adds").hide();
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            if(<?php echo e(sizeof($ClientDiscountTerm)); ?><1) {
                $("div.db_right_now_add").show();
                $("table.db_no_right_now_adds").hide();
            }
        });
    </script>
    <script>
        $(document).ready(function(e){
            genRowspan("gubun");
        });
        function genRowspan(className){
            $("." + className).each(function() {
                var rows = $("." + className + ":contains('" + $(this).text() + "')");
                if (rows.length > 1) {
                    rows.eq(0).attr("rowspan", rows.length);
                    rows.not(":eq(0)").remove();
                }
            });
        }
    </script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection("styles"); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection("contents"); ?>
    <div class="row">
        <div class="main-card mb-3 card" style="width:100%; ">
            <div class="card-body"><h5 class="card-title">Discount List</h5>
                <?php
                    $path = $_SERVER["HTTP_HOST"];
                    $path = str_replace(".einet.co.kr","",$path);
                ?>
                    <form method='post' name='discount_list' class='client_form' onSubmit="return check_all()" >
                            <?php echo e(csrf_field()); ?>

                            <div class="position-relative form-group">
                                <label for="clientName" class="" style="color: blue">할인명</label>
                                <input type="text" name="discount_name" id="discount_name" placeholder="할인명을 입력하세요" class="form-control" value="<?php echo e(isset($ClientDiscount)?$ClientDiscount->discount_name:""); ?>"/>
                            </div>
                            <div class="position-relative form-group">
                                <label for="clientName" class="" style="color: blue">할인명 달력에 노출</label>
                                <input type="radio" name="discount_check" id="discount_check" checked="checked" value="Y" <?php if(isset($ClientDiscount) && ($ClientDiscount->flag_use)=="Y"): ?> checked <?php endif; ?>/>
                                <label for="clientName" class="" style="color: blue">할인명 달력에 노출 안함</label>
                                <input type="radio" name="discount_check" id="discount_check" value="N" <?php if(isset($ClientDiscount) && ($ClientDiscount->flag_use)=="N"): ?> checked <?php endif; ?>/>
                            </div>

                            <div class="position-relative form-group">
                                <label for="clientName" class="" style="color: blue">기간</label>
                                <?php if($isset !=""): ?>
                                    <input type="radio" name="what_date" value="N" <?php if(isset($ClientDiscount) && $ClientDiscount->season_check): ?>=='N') checked <?php endif; ?>  />직접 입력
                                    <input type="radio" name="what_date" value="Y" <?php if(isset($ClientDiscount) && $ClientDiscount->season_check): ?>=='Y') checked  <?php endif; ?> />기간 참조
                                <?php else: ?>
                                    <input type="radio" name="what_date" value="N" checked  />직접 입력
                                    <input type="radio" name="what_date" value="Y" />기간 참조
                                <?php endif; ?>
                            </div>

                            <div class="db_right_now_add" id="db_right_now_add" >
                                <label for="clientName" class="" style="color: blue">직접 입력</label><a id="right_now_add">추가</a>
                                <?php $tt = 0; ?>
                                <?php $__currentLoopData = $ClientDiscountTerm; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if($v->season_id==null): ?>
                                        <?php $tt++; ?>
                                    <div>
                                        <input type='hidden' id='client_discount_term_id[]' value='<?php echo e(isset($v->id)?$v->id:""); ?>' />
                                        <input type='date' name='start_season[]' value='<?php echo e(isset($v->discount_start)?$v->discount_start:""); ?>'/>
                                        ~
                                        <input type='date' name='end_season[]' value='<?php echo e(isset($v->discount_end)?$v->discount_end:""); ?>'/>&nbsp;&nbsp;<a class='mt-1 btn btn-primary db_right_now_delete' style='color: black;'>X</a>
                                    </div>
                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php if($tt==0): ?>
                                    <div>
                                        <input type='hidden' name="client_discount_term_id[]" value='' />
                                        <input type='date' name='start_season[]'/>
                                        ~
                                        <input type='date' name='end_season[]'/>&nbsp;&nbsp;<a class='mt-1 btn btn-primary db_right_now' style='color: black;'>X</a>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <label for="clientName" class="" style="color: blue">기간 참조</label>
                            <div id="db_no_right_now_adds">
                                <table class="db_no_right_now_adds">
                                <?php $__currentLoopData = $ClientSeason; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td>
                                                <input type="checkbox"  name="no_right_now_id[<?php echo e($k); ?>]" value="<?php echo e($v->season_id); ?>" /> <label for="clientName" style="color: blue"><?php echo e($v->season_name); ?></label>
                                            </td>
                                            <td>
                                                <input type='date' name="no_right_now_date_start[<?php echo e($k); ?>]" value="<?php echo e($v->season_start); ?>">&nbsp; ~ &nbsp;<input type='date' name="no_right_now_date_end[<?php echo e($k); ?>]" value="<?php echo e($v->season_end); ?>">
                                            </td>
                                        </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </table>
                            </div>

                            <?php if($isset != ""): ?>
                                <div class="position-relative form-group">
                                    <div id="date_ban_add_list">
                                        <label for="clientName" class="" style="color: blue">제외 날짜</label><a id="date_ban_add">추가</a>
                                        <?php $__currentLoopData = $ClientDiscountBanDate; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div>
                                            <input type='date' name='date_ban[]' value="<?php echo e(isset($v->date_ban)?date($v->date_ban, time()):""); ?>">&nbsp;&nbsp;<a class="mt-1 btn btn-primary season_delete" style='color: black;'>X</a>
                                        </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                </div>
                            <?php else: ?>
                                <div class="position-relative form-group">
                                    <div id="date_ban_add_list">
                                        <label for="clientName" class="" style="color: blue">제외 날짜</label>
                                        <input type='date' name='date_ban[]'><a id="date_ban_add">추가</a>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <?php if($isset != ""): ?>
                                <?php
                                    $date_array = explode(',',$ClientDiscount->date);
                                    $size_of = sizeof($date_array);
                                ?>
                                <div class="position-relative form-group">
                                    <label for="clientName" class="" style="color: blue">할인 요일</label>
                                        <input type="checkbox" id="day_all">요일 전체 선택
                                        <input type='checkbox' class="day" name='day[]' value="0" <?php for($i=0; $i<$size_of; $i++): ?> <?php if(isset($date_array) && $date_array[$i]==0): ?> checked <?php endif; ?> <?php endfor; ?>>일
                                        <input type='checkbox' class="day" name='day[]' value="1" <?php for($i=0; $i<$size_of; $i++): ?> <?php if(isset($date_array) && $date_array[$i]==1): ?> checked <?php endif; ?> <?php endfor; ?>>월
                                        <input type='checkbox' class="day" name='day[]' value="2" <?php for($i=0; $i<$size_of; $i++): ?> <?php if(isset($date_array) && $date_array[$i]==2): ?> checked <?php endif; ?> <?php endfor; ?>>화
                                        <input type='checkbox' class="day" name='day[]' value="3" <?php for($i=0; $i<$size_of; $i++): ?> <?php if(isset($date_array) && $date_array[$i]==3): ?> checked <?php endif; ?> <?php endfor; ?>>수
                                        <input type='checkbox' class="day" name='day[]' value="4" <?php for($i=0; $i<$size_of; $i++): ?> <?php if(isset($date_array) && $date_array[$i]==4): ?> checked <?php endif; ?> <?php endfor; ?>>목
                                        <input type='checkbox' class="day" name='day[]' value="5" <?php for($i=0; $i<$size_of; $i++): ?> <?php if(isset($date_array) && $date_array[$i]==5): ?> checked <?php endif; ?> <?php endfor; ?>>금
                                        <input type='checkbox' class="day" name='day[]' value="6" <?php for($i=0; $i<$size_of; $i++): ?><?php if(isset($date_array) && $date_array[$i]==6): ?> checked <?php endif; ?> <?php endfor; ?>>토
                                </div>
                            <?php else: ?>
                                <div class="position-relative form-group">
                                    <label for="clientName" class="" style="color: blue">할인 요일</label>
                                    <input type="checkbox" id="day_all">요일 전체 선택
                                    <input type='checkbox' class="day" name='day[]' value="0">일
                                    <input type='checkbox' class="day" name='day[]' value="1">월
                                    <input type='checkbox' class="day" name='day[]' value="2">화
                                    <input type='checkbox' class="day" name='day[]' value="3">수
                                    <input type='checkbox' class="day" name='day[]' value="4">목
                                    <input type='checkbox' class="day" name='day[]' value="5">금
                                    <input type='checkbox' class="day" name='day[]' value="6">토
                                </div>
                            <?php endif; ?>

                            <div class="position-relative form-group">
                                <label for="clientName" class="" style="color: blue">객실 선택</label>
                                <select id="char" name="char">
                                    <option value="%|discount" selected="selected">정률 할인(%)</option>
                                    <option value="원|fixed">고정가 판매(원)</option>
                                    <option value="원|discount">할인 판매(원)</option>
                                </select>
                            </div>
                            <div class="position-relative form-group">
                                <input type="checkbox" id="room_id_all" value="Y">룸 전체 선택
                            </div>
                            <?php
                                $t_type = "";
                                $t_unit = "";
                            ?>
                            <?php if($isset!=""): ?>
                                <?php $__currentLoopData = $ClientTypeRoom; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                        if($t_type=="") $t_type = $v->type;
                                        if($t_unit=="") $t_unit = $v->unit;
                                    ?>
                                    <div class="position-relative form-group">
                                        <input type='checkbox' id="room_id_<?php echo e($k); ?>" data-idx="<?php echo e($k); ?>" name='room_id[<?php echo e($k); ?>]' value="<?php echo e($v->id); ?>" <?php echo e(isset($v->discount_value)&& $v->discount_value != null ? "checked" : ""); ?>><?php echo e($v->room_name); ?>&nbsp;&nbsp;<input type="text" name="discount[<?php echo e($k); ?>]" id="discount_check_<?php echo e($k); ?>" value="<?php echo e(isset($v->discount_value)?$v->discount_value:""); ?>"><a class="change_char" id="change_char[<?php echo e($k); ?>]"><?php echo e($v->unit); ?> 할인</a>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php else: ?>
                                <div class="position-relative form-group">
                                    <input type='checkbox' id="room_id_<?php echo e($k); ?>" data-idx="<?php echo e($k); ?>" name='room_id[<?php echo e($k); ?>]' value="<?php echo e($v->id); ?>" <?php echo e(isset($v->discount_value)&& $v->discount_value != null ? "checked" : ""); ?>><?php echo e($v->room_name); ?>&nbsp;&nbsp;<input type="text" name="discount[<?php echo e($k); ?>]" id="discount_check_<?php echo e($k); ?>" value="<?php echo e(isset($v->discount_value)?$v->discount_value:""); ?>"><a class="change_char" id="change_char[<?php echo e($k); ?>]"></a>
                                </div>
                                <script>

                                    $(function () {
                                        $("#char").val("%|discount").prop("selected",true);
                                        var tmp_unit = "%";
                                        var tmp_type = "할인";
                                        $("[id^='change_char']").text(tmp_unit+" "+tmp_type);
                                    });
                                </script>
                            <?php endif; ?>

                            <div><button type="submit" class="mr-2 btn btn-focus" id="submit">저장</button></div>
                            <script>
                                var t_type = '<?php echo e($t_type); ?>';
                                var t_unit = '<?php echo e($t_unit); ?>';
                                $("select[name=char]").val(t_unit+"|"+t_type);
                            </script>
                </form>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>



<?php echo $__env->make("admin.pc.layout.basic", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/www/real_resarvation/resources/views/admin/pc/price/discount_insert.blade.php ENDPATH**/ ?>