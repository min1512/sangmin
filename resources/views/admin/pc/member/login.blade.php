@extends("admin.pc.layout.blank")

@section("title")실시간 예약시스템@endsection

@section("scripts")
    <script>
        function ck() {
            if($("#saveId").prop("checked")===true) setCookie("user_staff_id", $("input[name=email]").val(), 1);
            else deleteCookie("user_staff_id");
            return true;
        }

        $(document).ready(function(){
            var tmp_login_id = getCookie("user_staff_id");
            if(tmp_login_id) {
                $("input[name='email']").val(tmp_login_id);
                $("#saveId").prop("checked",true);
            }
        });
    </script>
@endsection

@section("styles")
<link rel="stylesheet" href="http://staff.einet.co.kr/asset/css/common-b.css?v=<?=time()?>">
<link rel="stylesheet" href="http://staff.einet.co.kr/asset/css/blade.css?v=<?=time() ?>">
@endsection

@section("contents")
   <div class="login-wrap">
       <div class="login noto">
        <form method="post" name="frmLogin" onsubmit="return ck()" action="{{ url()->current() }}">
        {{ csrf_field() }}
        <div class="login-header">
           <a href="" class="login-header__logo"><img src="http://staff.einet.co.kr/asset/images/form_2/logo.png" class="login-header__img" alt=""></a>
            <p class="login-header__txt">실시간 예약 시스템</p>
        </div>
        <div class="login-middle clb">
            <div class="fl">
                <input id="email" type="text" name="email" placeholder="이메일" class="form-control login-middle__input type-email dp-b input-login" value="" />
                <input id="password" type="password" name="password" placeholder="비밀번호" class="form-control login-middle__input type-pw dp-b input-login">
            </div>
            <div class="fr">
                <button id="login" class="login-middle__btn">로그인</button>
            </div>

        </div>
        <div class="login-bottom clb">


            <ul class="login-bottom__list clb">
                <li class="login-bottom__item fl">
                    <input type="checkbox" name="saveId" id="saveId" class="checkbox-v1 login-bottom__chk"><label for="saveId">아이디 저장</label>
                </li>
                <li class="login-bottom__item fl">
                    <a href="" class="login-bottom__link">이메일 · 비밀번호찾기</a>
                </li>
            </ul>
        </div>
    </form>
   </div>
  </div>




<!-- 기존

    <form method="post" name="frmLogin" action="{{ url()->current() }}">
        {{ csrf_field() }}
        <div class="login-header">이아이넷 실시간 예약 시스템</div>
        <div class="content card">
            <div class="form-group">
                <label>이메일 </label>
                <input id="email" type="text" name="email" placeholder="Enter email" class="form-control">
            </div>
            <div class="form-group">
                <label>비밀번호</label>
                <input id="password" type="password" name="password" placeholder="Password" class="form-control">
            </div>
            <div class=" text-center">
                <button id="login" class="btn login-btn  ">로그인 </button></a><br>
            </div>
            <ul class="login_fing">
                <li>
                    <input id=" " type="checkbox" checked="checked" class="form-control_r ">
                    <label class="p-l-5">	<a href="#"	>아이디 저장 </a></label>
                </li>
            </ul>
        </div>
    </form>
-->
@endsection
