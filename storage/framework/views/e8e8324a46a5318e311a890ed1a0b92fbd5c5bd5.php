<!doctype html>
<html>

<head>
    <meta charset="utf-8" />
    <link rel="icon" type="image/png" href="../assets/img/favicon2.ico">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

    <title><?php echo $__env->yieldContent("title"); ?></title>

    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />

    <link href="../assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="../assets/css/light-bootstrap-dashboard.css" rel="stylesheet"/>
    <link href="../assets/css/common.css" rel="stylesheet" />

    <link href="../assets/css/style-02.css" rel="stylesheet" />
    <link href="../assets/css/style-01.css" rel="stylesheet" />

    <link href="../assets/css/_nav.css" rel="stylesheet" />
    <link href="../assets/css/_top.css" rel="stylesheet" />
    <link href="../assets/css/rsvStatus.css" rel="stylesheet" />
    <link href="../assets/css/rsvCommon.css" rel="stylesheet" />
    <!--<link href="../assets/css/_default.css" rel="stylesheet" /> -->

    <!-- Fonts and icons -->

    <link href='http://fonts.googleapis.com/css?family=Roboto:400,700,300' rel='stylesheet' type='text/css'>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+KR:wght@100;300;500;700&display=swap" rel="stylesheet">
    <!-- icon -->
    <link href="<?php echo e(asset('assets/css/pe-icon-7-stroke.css')); ?>" rel="stylesheet" />
    <link href="../assets/fontawesome/css/all.css" rel="stylesheet"> <!--load all styles -->


    <script src="../assets/js/jquery.min.js" type="text/javascript"></script>
    <script src="../assets/js/jquery-ui.min.js" type="text/javascript"></script>
    <script src="../assets/js/bootstrap.min.js" type="text/javascript"></script>

    <!-- Light Bootstrap Dashboard Core javascript and methods -->
    <script src="../assets/js/light-bootstrap-dashboard.js"></script>

    <!--  Checkbox, Radio, Switch and Tags Input Plugins -->
    <script src="../assets/js/bootstrap-checkbox-radio-switch-tags.js"></script>

    <!-- Sweet Alert 2 plugin -->
    <script src="../assets/js/sweetalert2.js"></script>

    <!--  Select Picker Plugin -->
    <script src="../assets/js/bootstrap-selectpicker.js"></script>
    <!--  Date Time Picker Plugin is included in this js file -->
    <script src="../assets/js/moment.min.js"></script>
    <script src="../assets/js/bootstrap-datetimepicker.js"></script>
    <?php echo $__env->yieldContent("scripts"); ?>
    <?php echo $__env->yieldContent("styles"); ?>
</head>
<body>
<div id="wrap">
    <div id="container">
        <?php echo $__env->make("admin.pc.include._nav", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php echo $__env->make("admin.pc.include._head", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <div id="content">
            <?php echo $__env->yieldContent("contents"); ?>
        </div>
    </div>
</div>
</body>
<?php /**PATH /home/www/real_resarvation/resources/views/admin/pc/layout/test.blade.php ENDPATH**/ ?>