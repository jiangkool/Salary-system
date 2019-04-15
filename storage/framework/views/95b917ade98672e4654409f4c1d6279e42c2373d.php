    <?php if(!empty($header)): ?>
    <section class="content-header">
        <h1>
            <?php echo e(isset($header) ? $header : trans('admin.title'), false); ?>

            <small><?php echo e(isset($description) ? $description : trans('admin.description'), false); ?></small>
        </h1>

        <!-- breadcrumb start -->
        <?php if($breadcrumb): ?>
        <ol class="breadcrumb" style="margin-right: 30px;">
            <li><a href="<?php echo e(admin_url('/'), false); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <?php $__currentLoopData = $breadcrumb; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if($loop->last): ?>
                    <li class="active">
                        <?php if(array_has($item, 'icon')): ?>
                            <i class="fa fa-<?php echo e($item['icon'], false); ?>"></i>
                        <?php endif; ?>
                        <?php echo e($item['text'], false); ?>

                    </li>
                <?php else: ?>
                <li>
                    <a href="<?php echo e(admin_url(array_get($item, 'url')), false); ?>">
                        <?php if(array_has($item, 'icon')): ?>
                            <i class="fa fa-<?php echo e($item['icon'], false); ?>"></i>
                        <?php endif; ?>
                        <?php echo e($item['text'], false); ?>

                    </a>
                </li>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ol>
        <?php endif; ?>
        <!-- breadcrumb end -->

    </section>
    <?php endif; ?>

 <div class="row">
   <div class="col-lg-3">
      <a class="btn btn-success" href="<?php echo e(route('jslog.create'), false); ?>" role="button"> <i class="fa fa-plus"></i> 结算录入</a>
    </div>
    <div class="col-lg-3 col-lg-offset-1">
      <div class="input-group">
            <span class="input-group-addon">工厂名称</span>
            <select name="company_id" id="company_id"  class="form-control ">
              <option value=""></option>
              <?php $__currentLoopData = $companies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $company): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <option value="<?php echo e($company->id, false); ?>" <?php if($company->id==request()->get('company_id')): ?> selected="true"  <?php endif; ?>><?php echo e($company->company_name, false); ?></option>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>

        </div>
    </div>
    <div class="col-lg-3">
        <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
            <input type="text" name="btwdate" id="btwdate" value="<?php echo e(request()->get('btwdate'), false); ?>" class="form-control " style="width: 100%"  />
        </div>
    </div>
    <div class="col-lg-2">
        <button type="submit" class="btn btn-primary search">搜索</button>
    </div>
</div>
<hr>
<!--startprint-->
<div id="need-print-area">
    <section class="content">
        <?php echo $__env->make('admin::partials.alerts', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <?php echo $__env->make('admin::partials.exception', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <?php echo $__env->make('admin::partials.toastr', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        
        <div class="box-body table-responsive no-padding">
         <div style="border-left: 5px solid #eee">
            <p style="padding: 10px;font-size: 15px">工厂结算记录</p>
         </div>   
         <hr>
        <table class="table table-hover table-striped table-bordered">
            <thead>
                <tr>
                    <th>工厂名称</th><th>结算金额(元)</th><th>结算时间</th>
                </tr>
            </thead>
            <tbody>
              <?php
               $total=0;
              ?>
              <?php $__currentLoopData = $jslogs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $jslog): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
               <?php
               $total+=$jslog->money;
               ?>
               <tr>
                   <td><?php echo e($jslog->company->company_name, false); ?></td>
                  <td><?php echo e($jslog->money, false); ?></td>
                  <td><?php echo e($jslog->created_at, false); ?></td>
               </tr>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
               <tr>
                   <td><b><?php if(request()->get('btwdate')): ?> 该时间段合计  <?php else: ?> 本页合计 <?php endif; ?></b></td>
                   <td colspan="3"><b><?php echo e($total, false); ?></b> 元</td>
               </tr>
            </tbody>
        </table>
    </div>
    <div class="text-center" style="padding: 15px 0"><p>&copy; <?php echo e(date('Y'), false); ?> 福州神康医院 版权所有 </p></div>
    </section>
</div>
<!--endprint-->
 <div class="text-center"><?php echo e($jslogs->links(), false); ?></div>
<hr>
<div class="print-btns text-center"><button type="button" class="btn btn-primary" onclick="javascript:window.history.go(-1);">返回</button> <button type="button" class="btn btn-success" onclick="javascript:print()">打印</button></div>
<script>
function print(){$("#need-print-area").printArea();}
laydate.render({elem: '#btwdate',range: '_'});

$(function(){
    $('.search').click(function(){
        $.pjax({container:'#pjax-container', url: "/admin/jslog"+'?btwdate='+$('#btwdate').val()+'&company_id='+$('#company_id').val() });
    })
})



</script>