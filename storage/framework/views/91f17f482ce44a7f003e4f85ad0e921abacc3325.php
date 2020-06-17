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
    <?php echo $__env->yieldContent("scripts"); ?>
    <?php echo $__env->yieldContent("styles"); ?>
    <link href="<?php echo e(asset('asset/css/admin_pc_common.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('asset/fontawesomepro/css/all.css')); ?>" rel="stylesheet">
    <script src="<?php echo e(asset('asset/js/common.js')); ?>"></script>
</head>
<body>
<?php echo $__env->yieldContent("contents"); ?>
</body>
</html>
<?php /**PATH /home/www/real_resarvation/resources/views/admin/pc/layout/blank.blade.php ENDPATH**/ ?>