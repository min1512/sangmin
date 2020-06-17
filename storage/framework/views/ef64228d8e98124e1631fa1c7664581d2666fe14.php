

<?php $__env->startSection("title"); ?>숙박업체<?php $__env->stopSection(); ?>

<?php $__env->startSection("scripts"); ?>
    <script>
        $(function () {
            var search1 = $('#search1').val();
            if(search1 == "client_list"){
                $('#default').show();
                $('#client_list_search_menu1').show();
                $('#client_list_search_menu2').show();
                $('#client_list_search_menu3').show();
                $('#client_list_search_menu4').show();
                $('#room_list_search_menu1').hide();
                $('#room_list_search_menu2').hide();
                $('#room_list_search_menu3').hide();
            }else if(search1 == "room_list"){
                $('#client_list_search_menu1').hide();
                $('#client_list_search_menu2').hide();
                $('#client_list_search_menu3').hide();
                $('#client_list_search_menu4').hide();
                $('#default').show();
                $('#room_list_search_menu1').show();
                $('#room_list_search_menu2').show();
                $('#room_list_search_menu3').show();
            }
            $('#search1').change(function () {
                var search1 = $('#search1').val();
                console.log(search1);
                if(search1 == "client_list"){
                    $('#default').show();
                    $('#default').val("").prop("selected",true);
                    $('#client_list_search_menu1').show();
                    $('#client_list_search_menu2').show();
                    $('#client_list_search_menu3').show();
                    $('#client_list_search_menu4').show();
                    $('#room_list_search_menu1').hide();
                    $('#room_list_search_menu2').hide();
                    $('#room_list_search_menu3').hide();
                }else if(search1 == "room_list"){
                    $('#client_list_search_menu1').hide();
                    $('#client_list_search_menu2').hide();
                    $('#client_list_search_menu3').hide();
                    $('#client_list_search_menu4').hide();
                    $('#default').show();
                    $('#default').val("").prop("selected",true);
                    $('#room_list_search_menu1').show();
                    $('#room_list_search_menu2').show();
                    $('#room_list_search_menu3').show();
                }
            })
        })
    </script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection("styles"); ?>
<link rel="stylesheet" href="http://staff.einet.co.kr/asset/css/common-b.css?v=<?=time()?>">
<link rel="stylesheet" href="http://staff.einet.co.kr/asset/css/blade.css?v=<?=time() ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection("contents"); ?>
    <?php echo $__env->make("admin.pc.include.price.etc_search",['search'=>isset($search)?$search:[]], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <?php echo $__env->make("admin.pc.include.price.etc_list",['clientList'=>$clientList, 'uid'=>$id], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <?php echo $__env->make("admin.pc.include.price.etc_list2",['ClientTypeRoom'=>$ClientTypeRoom, 'uid'=>$id], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make("admin.pc.layout.basic", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/www/real_resarvation/resources/views/admin/pc/price/etc.blade.php ENDPATH**/ ?>