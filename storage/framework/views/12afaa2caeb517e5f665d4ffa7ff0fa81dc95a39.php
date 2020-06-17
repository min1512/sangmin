<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Language" content="en">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title><?php echo $__env->yieldContent("title"); ?></title>
    <meta name="viewport"
          content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no"/>
    <meta name="description" content="This is an example dashboard created using build-in elements and components.">
    <meta name="msapplication-tap-highlight" content="no">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <link href="<?php echo e(asset('asset/css/admin_pc_common.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('asset/fontawesomepro/css/all.css')); ?>" rel="stylesheet">
    <script src="<?php echo e(asset('asset/js/common.js')); ?>"></script>
    <?php echo $__env->yieldContent("scripts"); ?>
    <?php echo $__env->yieldContent("styles"); ?>
</head>
<body>
    <div id="wrap">
        <div id="container">
            <div id="sidebar">
                <div class="change_client"><span>계정전환 <i class="fal fa-angle-down"></i></span></div>
                <?php
                    $url = $_SERVER["HTTP_HOST"];
                    $url = str_replace(".einet.co.kr","",$url);

                    $hh = explode(".",$_SERVER["HTTP_HOST"]);
                    if($hh[0]=="staff") $tmp_user = \App\Models\UserStaff::where('user_id',Auth::user()->id)->select('permit_id')->first();
                    elseif($hh[0]=="agency") $tmp_user = \App\Models\UserAgency::where('user_id',Auth::user()->id)->select('permit_id')->first();
                    elseif($hh[0]=="client") $tmp_user = \App\Models\UserClient::where('user_id',Auth::user()->id)->select('permit_id')->first();

                    $permit = \App\Models\ConfigPermitView::where('permit_id',$tmp_user->permit_id)->get();
                    $category = \App\Http\Controllers\Controller::getCategory();
                    $uri = \Illuminate\Support\Facades\Request::route()->uri();
                    $uri = explode("/",$uri);
                ?>
                <div class="gnb">
                    <ul>

                        <?php $__currentLoopData = $category; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $tmpCnt = \App\Models\ConfigPermitView::where('permit_id',$tmp_user->permit_id)->where('code_admin',$v['code'])->count();
                                if($tmpCnt<1) continue;
                                $tmp_code_0 = str_replace("_",".",str_replace("admin_","",$v['code']));
                                $tmp_path_0 = explode(".",$tmp_code_0);
                            ?>
                            <li>
                                <?php if(isset($v['sub'])): ?>
                                    <span class="menu"><i class="fal fa-<?php echo e($v['icon']); ?>"></i><?php echo e($v['name']); ?></span>
                                    <span class="block_arrow"><i class="fal fa-angle-down"></i></span>
                                    <?php $__currentLoopData = $v['sub']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k2 => $v2): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php
                                            $tmpCnt = \App\Models\ConfigPermitView::where('permit_id',$tmp_user->permit_id)->where('code_admin',$v2['code'])->count();
                                            if($tmpCnt<1) continue;
                                            $tmp_code = str_replace("_",".",str_replace("admin_","",$v2['code']));
                                            $tmp_path = explode(".",$tmp_code);
                                        ?>
                                        <p><a href="<?php echo e(route($tmp_code)); ?>"><i class="fal fa-angle-right"></i> <?php echo e($v2['name']); ?></a></p>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php else: ?>
                                    <span class="menu"><a href="<?php echo e(route($tmp_code_0)); ?>"><i class="fal fa-<?php echo e($v['icon']); ?>"></i><?php echo e($v['name']); ?></a></span>
                                <?php endif; ?>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            </div>
            <div id="header">
                <div class="logo">
                    <img src="<?php echo e(asset('asset/images/logo_einet.png')); ?>" />
                    <span>이아이넷 펜션(본점)</span>
                </div>
                <div class="search">
                    <input type="text" name="" class="keyword" placeholder="예약자/연락처/요청/메모" />
                    <button class="btn_reservation"><i class="fal fa-calendar"></i> 직접예약</button>
                    <button class="btn_search"><i class="fal fa-search"></i> 검색</button>
                </div>
            </div>
            <div id="content">
                <div class="quick">
                    <ul>
                        <li>사이트바로가기</li>
                        <li>실시간예약창</li>
                        <li>내정보</li>
                    </ul>
                </div>
                <div class="content_wrap">
                    <?php echo $__env->yieldContent("contents"); ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
<?php /**PATH /home/www/real_resarvation/resources/views/admin/pc/layout/basic.blade.php ENDPATH**/ ?>