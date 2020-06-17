<?php $__env->startSection("title"); ?>성수기/시즌 추가<?php $__env->stopSection(); ?>

<?php $__env->startSection("scripts"); ?>
    <script>
        function test() {
            var data_season_start = new Array();
            var data_season_end = new Array();
            <?php $__currentLoopData = $season_term_all; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            data_season_start.push('<?php echo e($v->season_start); ?>');
            data_season_end.push('<?php echo e($v->season_end); ?>');
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            var tcnt1 = 0;
            var tcnt3 = 0;
            $("input[name^='start_season']").each(function (index) {
                if(index>0){
                        if(
                            ($(this).val() <= $("input[name^='end_season']").eq(index+1).val() && $(this).val() >= $("input[name^='start_season']").eq(index+1).val())
                            ||
                            ($("input[name^='end_season']").eq(index-1).val() >= $(this).val()  && $("input[name^='start_season']").eq(index-1).val() <= $(this).val())
                        ){
                            console.log(index);
                            if (tcnt3 < 1) alert("날짜 입력이 잘못 되었습니다.");
                            tcnt3++;
                        }else if(
                            ($("input[name^='start_season']").eq(index).val() >= $("input[name^='end_season']").eq(index).val())
                        ){
                            if (tcnt3 < 1) alert("날짜 입력이 잘못 되었습니다.");
                            tcnt3++;
                        }else if(
                            ($("input[name^='start_season']").eq(index).val()=="" || $("input[name^='end_season']").eq(index).val()=="")
                        ){
                            if (tcnt3 < 1) alert("날짜를 입력해주세요");
                            tcnt3++;
                        }
                }

                for(var i in data_season_end){
                    console.log($(this).val()+" :: "+data_season_start[i]+" :: "+tcnt1);
                    if(
                        ($(this).val() <= data_season_end[i] && $(this).val() >= data_season_start[i])
                        ||
                        ($("input[name^='end_season']").eq(index).val() >= data_season_start[i] && $("input[name^='end_season']").eq(index).val() <= data_season_end[i])
                    ){
                        if(tcnt3!=1){
                            if(tcnt1<1) alert('입력한 시즌은 중복됩니다.');
                            tcnt1++;
                        }
                    }
                }
            });
            if(tcnt1<1 && tcnt3<1) {
                $("form[name=season_term_form]").attr("action", '/info/season_term/<?php echo e(isset($id)?$id:""); ?>');
                return true;
            }else {
                return false;
            }

        };

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
                $path = str_replace(".einet.co.kr","",$path);
            ?>
            var client = "client";
            var staff = "staff";
            if(client == "<?php echo e($path); ?>") {
                if (tcnt1 < 1 && tcnt3 < 1) {
                    $("form[name=add_seasons]").attr("action", '/info/season_add').submit();
                    return true;
                } else {
                    return false;
                }
            }else if(staff == "<?php echo e($path); ?>"){
                if (tcnt1 < 1 && tcnt3 < 1) {
                    $("form[name=add_seasons]").attr("action", '/price/season/save').submit();
                    return true;
                } else {
                    return false;
                }
            }
        };

        $(function () {
            $(".season_delete").click(function () {
                $(this).parents("tr").remove();
            });

            $(".season_delete").click(function () {
                $(this).parents("tr").remove();
            });

            $('#delete_season').click(function () {
                season_table.submit();
                season_table.action = '/price/season_delete';
                return true;
            });
        });

        var ord = <?php echo e(sizeof($season_term)>0?sizeof($season_term):0); ?>;
        $(function () {
            $('#time_add').click(function () {
                $('#season_term_table > tbody').append(
                    "<tr>"+
                        "<td>"+
                            "기간"+
                        "</td>"+
                        "<td>"+
                            "<input type='hidden' name='season_term_id["+ord+"]' value='' />"+
                            "<input type='date' name='start_season["+ord+"]'>"+
                            "~"+
                            "<input type='date' name='end_season["+ord+"]'>&nbsp;&nbsp;<a class='mr-2 btn btn-info season_delete' style='color: white;'>X</a>"+
                        "</td>"+
                        "<td>"+
                            "<input type='radio' name='check_season["+ord+"]' value='Y' checked='checked'/>기간노출 함<input type='radio' name='check_season["+ord+"]'  value='N'>기간노출 안함"+
                        "</td>"+
                    "</tr>"
                );
                ord++;
                $(function () {
                    $(".season_delete").click(function () {
                        $(this).parents("tr").remove();
                    });
                });
            });
        });



        $(function () {
            $('#add_season').click(function () {
                var user_id = <?php echo e(isset($user_id)?$user_id:""); ?>

                $('#add_season_list').html(
                    "<form method='post' name='add_seasons' class='client_form' >"+
                        "<input type='hidden' name='user_id' value="+user_id+">"+
                        "<table>" +
                            "<input type=hidden name=_token />" +
                            "<tr>" +
                                "<td>시즌명</td>"+
                                "<td><input type='text' id='season_name' name='season_name'></td>" +
                            "</tr>"+
                            "<tr>" +
                                "<td>시작 기간</td>"+
                                "<td><input type='date' id='season_start' name='season_start'></td>" +
                            "</tr>"+
                            "<tr>" +
                                "<td>끝 기간</td>"+
                                "<td><input type='date' id='season_end' name='season_end'></td>" +
                            "</tr>"+
                            "<tr>" +
                                "<td><button type='button' onclick='test1()' class=\"mt-1 btn season_save\" >저장</button></td>"+
                            "</tr>"+
                        "</table>" +
                    "</form>"
                );
                $("input[name=_token]").val('<?php echo e(csrf_token()); ?>');
            })
        })
    </script>
    <script>
        $(function () {
            $(".number").keyup(function () {
                var number = $(this).val();
                number = number.replace(/,/gi,"");
                $(this).val(numberFormat(number));
            });
        });
        function numberFormat(inputNumber) {
            return inputNumber.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        };
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
    <script>
        $(function(){
            $("input[id^='all_price_']").click(function(){
                seasonCheck();
            });
        });
        function seasonCheck() {
            $("input[id^='all_price_']").each(function () {
                if ($(this).prop("checked") == true) {
                    $(".many_price_insert").show();
                    $('.many_price_insert').html(
                        "<div class='main-card mb-3'>"+
                            "<div class='card-body'>"+
                                "<h5 class='card-title'> INSERT PRICE ALL</h5>"+
                                    "<form name='one_click_price_insert_all_form'>"+
                                        "<table id='one_click_price_insert_all_table' >"+
                                            "<input type=hidden name=_token />" +
                                                "<tr>"+
                                                    "<th colspan=\"4\" style=\"text-align: center\">객실 기본요금</th>"+
                                                    "<th colspan=\"3\" style=\"text-align: center\">추가 인원 요금</th>"+
                                                "</tr>"+
                                                "<tr>"+
                                                    "<td>일요일</td>"+
                                                    "<td>주중</td>"+
                                                    "<td>금요일</td>"+
                                                    "<td>토요일(공휴일 전날)</td>"+
                                                    "<td>성인</td>"+
                                                    "<td>아동</td>"+
                                                    "<td>유아</td>"+
                                                "</tr>"+
                                                "<tr>"+
                                                    "<td>"+
                                                        "<input type='text' name='insert_all_sunday' id='insert_all_sunday' class='number'>"+
                                                    "</td>"+
                                                    "<td>"+
                                                        "<input type='text'  name='insert_all_weekday' id='insert_all_weekday' class='number'>"+
                                                    "</td>"+
                                                    "<td>"+
                                                        "<input type='text' name='insert_all_friday' id='insert_all_friday' class='number'>"+
                                                    "</td>"+
                                                    "<td>"+
                                                        "<input type='text' name='insert_all_saturday' id='insert_all_saturday' class='number'>"+
                                                    "</td>"+
                                                    "<td>"+
                                                        "<input type='text' name='insert_all_add_adult' id='insert_all_add_adult' class='number'>"+
                                                    "</td>"+
                                                    "<td>"+
                                                        "<input type='text' name='insert_all_add_child' id='insert_all_add_child' class='number'>"+
                                                    "</td>"+
                                                    "<td>"+
                                                        "<input type='text' name='insert_all_add_baby' id='insert_all_add_baby' class='number'>"+
                                                    "</td>"+
                                                "</tr>"+
                                                "<tr>"+
                                                    "<th><button type='button' onclick='type_season();'>일괄 입력</button></th>"+
                                                "</tr>"+
                                        "</table>"+
                                    "</form>"+
                            "</div>"+
                        "</div>"
                    );
                    $("input[name=_token]").val('<?php echo e(csrf_token()); ?>');
                    $(".number").keyup(function () {
                        var number = $(this).val();
                        number = number.replace(/,/gi,"");
                        $(this).val(numberFormat(number));
                    });
                    return false;
                }else{
                    $(".many_price_insert").hide();
                }
            });
        }
        function type_season(){
            $("input[id^='all_price_']").each(function () {
                if ($(this).prop("checked") == true){
                    var all_price_value = $(this).val();
                    var all_price_value = all_price_value.split(/_/gi);
                    temp_price(all_price_value);
                }
            })
            $('.many_price_insert').hide();
            $("input:checkbox[id^='all_price_']").prop('checked',false);
            $('#insert_all_sunday').val(0);
            $('#insert_all_weekday').val(0);
            $('#insert_all_friday').val(0);
            $('#insert_all_saturday').val(0);
            $('#insert_all_add_adult').val(0);
            $('#insert_all_add_child').val(0);
            $('#insert_all_add_baby').val(0);
            $("#season_all").prop("checked", false);
        }

        function temp_price(all_price_value) {
            var z = all_price_value[2]+"_"+all_price_value[3];
            var insert_all_sunday = $('#insert_all_sunday').val();
            var insert_all_weekday = $('#insert_all_weekday').val();
            var insert_all_friday = $('#insert_all_friday').val();
            var insert_all_saturday = $('#insert_all_saturday').val();
            var insert_all_add_adult = $('#insert_all_add_adult').val();
            var insert_all_add_child = $('#insert_all_add_child').val();
            var insert_all_add_baby = $('#insert_all_add_baby').val();

            if(insert_all_sunday=="")insert_all_sunday =0;
            if(insert_all_weekday=="")insert_all_weekday=0;
            if(insert_all_friday=="")insert_all_friday=0;
            if(insert_all_saturday=="")insert_all_saturday=0;
            if(insert_all_add_adult=="")insert_all_add_adult=0;
            if(insert_all_add_child=="")insert_all_add_child=0;
            if(insert_all_add_baby=="")insert_all_add_baby=0;

            $("#price_0_"+z).val(insert_all_sunday);
            $("#price_1_"+z).val(insert_all_weekday);
            $("#price_5_"+z).val(insert_all_friday);
            $("#price_6_"+z).val(insert_all_saturday);
            $("#price_11_"+z).val(insert_all_add_adult);
            $("#price_12_"+z).val(insert_all_add_child);
            $("#price_13_"+z).val(insert_all_add_baby);
        }

        $(function () {
            $("#season_all").click(function () {
                if($(this).is(":checked")==true){
                    $("input[name^='all_price']").each(function () {
                        $(this).prop("checked", true);
                    });
                }else if($(this).is(":checked")==false){
                    $("input[name^='all_price']").each(function () {
                        $(this).prop("checked", false);
                    });
                }
                seasonCheck();
            });

            $("input[name^='all_price']").click(function () {
                $("input[name^='all_price']").each(function () {
                    oneCheck($(this));
                })
            })

            function oneCheck(a){
                if($(a).prop("checked")){
                    var checkBoxLength = $("input[name^='all_price']").length;
                    var checkedLength = $("input[name^='all_price']:checked").length;
                    if(checkBoxLength==checkedLength){
                        $("#season_all").prop("checked", true);
                    }else{
                        $("#season_all").prop("checked", false);
                    }
                }else{
                    $("#season_all").prop("checked", false);
                }
            }

        });

    </script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection("styles"); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection("contents"); ?>
    <?php echo $__env->make("admin.pc.include.price.season_search",['search'=>isset($search)?$search:[]], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <?php echo $__env->make("admin.pc.include.price.season_list",['curPath'=>$curPath, 'curPath_staff'=>$curPathstaff, 'seasonList'=>$seasonList, 'user_id'=>isset($user_id)?$user_id:""], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <?php echo $__env->make("admin.pc.include.price.season_list_2",['curPath'=>$curPath, 'curPath_staff'=>$curPathstaff, 'season'=>$season, 'id'=>isset($id)?$id:""], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <?php echo $__env->make("admin.pc.include.price.season_price",['curPath'=>$curPath, 'curPath_staff'=>$curPathstaff, 'room'=>$room, 'season'=>$season, 'roomSeasonPrice'=>isset($roomSeasonPrice)?$roomSeasonPrice:[]], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php echo $__env->make("admin.pc.layout.basic", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/www/real_resarvation/resources/views/admin/pc/price/season.blade.php ENDPATH**/ ?>