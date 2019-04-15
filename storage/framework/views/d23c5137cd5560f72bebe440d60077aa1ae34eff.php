  <div class="top">
        <div class="blank5"></div>
        <div class="page-content text-right"><p><span class="glyphicon glyphicon-user"></span> <?php echo e(Admin::user()->name, false); ?>，欢迎您！ <span class="fa fa-clock-o"></span> 您上次登录时间 <?php @$lastLog=Admin::user()->logs()->where('path','admin/auth/logout')->pluck('created_at')->last(); ?>   <?php echo e($lastLog??'--', false); ?>  &nbsp;&nbsp;&nbsp;<a href="<?php echo e(admin_base_path('auth/logout'), false); ?>" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-log-out"></span> <?php echo e(trans('admin.logout'), false); ?></a></p></div>
        <div class="blank5"></div>
    </div>
