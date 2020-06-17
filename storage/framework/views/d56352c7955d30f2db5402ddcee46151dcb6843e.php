<?php $__env->startSection("title"); ?>대행사관리<?php $__env->stopSection(); ?>

<?php $__env->startSection("scripts"); ?>
    <script>
        $(function () {
            $('#email').keyup(function () {
                $.ajax({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    type: 'POST',
                    url: '/user/staff/staff_email_check',
                    data: {
                        _token: '<?php echo e(csrf_token()); ?>',
                        email: $('#email').val()
                    },
                    success: function (data) {
                        if(data==1){
                            $('#check').text("사용가능한 아이디 입니다");
                        }else{
                            $('#check').text("사용불가능한 아이디 입니다");
                        }
                    },
                    error: function (data) {
                        console.log(data);
                        alert(data);
                    }
                });
            })
        });
        $(function () {
            $('#submit').click(function () {
                var check = $('#check').text();
                console.log(check);
                if(check=="사용불가능한 아이디 입니다"){
                    alert('사용불가능한 아이디 입니다');
                    return false;
                }else if(check=="중복 체크") {
                    alert('아이디 입력 하세요');
                    return false;
                }else if($('#email').val()==""){
                    alert('아이디 입력 하세요');
                    return false;
                }else{
                    return true;
                }
            })
        })
    </script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection("styles"); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection("contents"); ?>
    <form method="post" name="frmAgencySave" action="<?php echo e(route('user.agency.save')); ?>">
        <?php echo e(csrf_field()); ?>

        <input type="hidden" name="id" value="<?php echo e(isset($agency->id)&&$agency->id!=""?$agency->id:""); ?>" />
        <div>대행사명 <input type="text" name="agency_name" value="<?php echo e(isset($agency)?$agency->agency_name:""); ?>" /></div>
        <div>변경비밀번호: <input type="password" name="password" /></div>
        <div>변경비밀번호확인: <input type="password" name="password2" /></div>
        <div>이메일: <input type="text" name="email" id="email" value="<?php echo e(isset($agency)?$agency->email:""); ?>" /><a style="color: red" id="check">중복 체크</a></div>
        <div>개인/법인:
            <input type="radio" name="agency_type" value="I" <?php echo e(!isset($agency)||$agency->agency_type=="I"?"checked":""); ?> />개인
            <input type="radio" name="agency_type" value="C" <?php echo e(isset($agency)&&$agency->agency_type=="C"?"checked":""); ?> />법인
        </div>
        <div>사업자번호: <input type="text" name="agency_number" value="<?php echo e(isset($agency)?$agency->agency_number:""); ?>" /></div>
        <div>법인번호: <input type="text" name="agency_number2" value="<?php echo e(isset($agency)?$agency->agency_number2:""); ?>" /></div>
        <div>주소:
            <input type="text" name="agency_post" />
            <input type="button" value="검색" />
            <input type="text" name="agency_addr_basic" value="<?php echo e(isset($agency)?$agency->agency_addr_basic:""); ?>" />
            <input type="text" name="agency_addr_detail" value="<?php echo e(isset($agency)?$agency->agency_addr_detail:""); ?>" />
        </div>
        <div>업태/종목:
            <input type="text" name="agency_item1" value="<?php echo e(isset($agency)?$agency->agency_item1:""); ?>" />
            /
            <input type="text" name="agency_item2" value="<?php echo e(isset($agency)?$agency->agency_item2:""); ?>" />
        </div>
        <div>과세여부:
            <input type="radio" name="agency_tax" value="Y" <?php echo e(!isset($agency)||$agency->agency_tax=="Y"?"checked":""); ?> />과세
            <input type="radio" name="agency_tax" value="C" <?php echo e(isset($agency)&&$agency->agency_tax=="N"?"checked":""); ?> />비과세(면세)
        </div>
        <div>대표자: <input type="text" name="agency_owner" value="<?php echo e(isset($agency)?$agency->agency_owner:""); ?>" /></div>
        <div>대표자연락처: <input type="text" name="agency_tel" value="<?php echo e(isset($agency)?$agency->agency_tel:""); ?>" /></div>
        <div>대표자휴대폰: <input type="text" name="agency_hp" value="<?php echo e(isset($agency)?$agency->agency_hp:""); ?>" /></div>
        <input type="submit" id="submit" value="저장" />
    </form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make("admin.pc.layout.basic", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/www/real_resarvation/resources/views/admin/pc/user/agency_save.blade.php ENDPATH**/ ?>