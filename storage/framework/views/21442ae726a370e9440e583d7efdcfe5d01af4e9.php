<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<title><?php echo e(Admin::title(), false); ?></title>
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="<?php echo e(admin_asset("/vendor/laravel-admin/AdminLTE/bootstrap/css/bootstrap.min.css"), false); ?>">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo e(admin_asset("/vendor/laravel-admin/font-awesome/css/font-awesome.min.css"), false); ?>">

    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo e(admin_asset("/vendor/laravel-admin/AdminLTE/dist/css/skins/" . config('admin.skin') .".min.css"), false); ?>">

    <?php echo Admin::css(); ?>

    <link rel="stylesheet" href="<?php echo e(admin_asset("/vendor/laravel-admin/laravel-admin/laravel-admin.css"), false); ?>">
    <link rel="stylesheet" href="<?php echo e(admin_asset("/vendor/laravel-admin/nprogress/nprogress.css"), false); ?>">
    <link rel="stylesheet" href="<?php echo e(admin_asset("/vendor/laravel-admin/sweetalert/dist/sweetalert.css"), false); ?>">
    <link rel="stylesheet" href="<?php echo e(admin_asset("/vendor/laravel-admin/nestable/nestable.css"), false); ?>">
    <link rel="stylesheet" href="<?php echo e(admin_asset("/vendor/laravel-admin/toastr/build/toastr.min.css"), false); ?>">
    <link rel="stylesheet" href="<?php echo e(admin_asset("/vendor/laravel-admin/bootstrap3-editable/css/bootstrap-editable.css"), false); ?>">
    <link rel="stylesheet" href="<?php echo e(admin_asset("/vendor/laravel-admin/google-fonts/fonts.css"), false); ?>">
    <link rel="stylesheet" href="<?php echo e(admin_asset("/vendor/laravel-admin/AdminLTE/dist/css/AdminLTE.min.css"), false); ?>">
<link rel="stylesheet" href="/ui/css/layui.css">
<link rel="stylesheet" href="/css/style.css">
</head>
<body>
	<?php echo $__env->make('admin::partials.header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
	<?php echo $__env->yieldContent('content'); ?>
	<div class="blank15"></div>
	<footer>
		<p>&copy;2018 福州神康医院版权所有</p>
	</footer>
</body>
</html>