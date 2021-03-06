<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo e(config('admin.title'), false); ?> | <?php echo e(trans('admin.login'), false); ?></title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="/css/style.css">
 <style>
  .layui-form-item .layui-inline{margin-top: 305px;margin-left: 30px}
</style>
</head>
<body class="body-with-bg">
  <div class="login-box">
     <?php if($errors->has('username')||$errors->has('password')): ?>
          <script type="text/javascript">alert('用户名或密码错误！')</script>
    <?php endif; ?>
     <form action="<?php echo e(admin_base_path('auth/login'), false); ?>" method="post">
      <?php echo e(csrf_field(), false); ?>

    <div class="layui-form-item">
    <div class="layui-inline">
    <div class="layui-input-inline my-length">
    <input type="text" name="username" placeholder="请输入帐号" autocomplete="off" class="layui-input " value="<?php echo e(old('username'), false); ?>">
    </div>
    <div class="layui-input-inline my-length">
    <input type="password" name="password" lay-verify="pass" placeholder="请输入密码" autocomplete="off" class="layui-input">
    </div>
    <button class="layui-btn my-submit" lay-submit="" lay-filter="*">登录</button>
    </div>
    </div>
  </form>
  </div>
  <div class="clear"></div>
  <div class="footer"><p>Copyright ©2018  福州神康医院版权所有</p></div>
</body>
</html>