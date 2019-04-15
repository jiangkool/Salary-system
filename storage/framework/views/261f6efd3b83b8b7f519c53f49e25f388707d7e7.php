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
    <div class="col-lg-3 col-lg-offset-7">
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
            <p style="padding: 10px;font-size: 15px">工厂名称：<b><?php echo e($company->company_name, false); ?></b> &nbsp;&nbsp;&nbsp;&nbsp;<span>已做金额：<b><?php echo e($company->yz_total, false); ?></b></span> 元  &nbsp;&nbsp;&nbsp;&nbsp;<span>已结金额：<b><?php echo e($company->yj_total, false); ?></b></span> 元  <?php if($company->wj_total<0): ?> &nbsp;&nbsp;&nbsp;&nbsp;未结金额：<b><?php echo e(abs($company->wj_total), false); ?></b>  元<?php endif; ?></p>
         </div>   
         <hr>
        <table class="table table-hover table-striped table-bordered">
            <thead>
                <tr>
                    <th>工种名称</th><th>数量</th><th>单价(元)</th><th>合计(元)</th>
                </tr>
            </thead>
            <tbody>
                <?php
                  $total=0;
                ?>

               <?php $__currentLoopData = $works; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
               <?php
                $total+=$arr[$item->id]['total'];
               ?>
               <tr>
                   <td><?php echo e($gzs[$item->id], false); ?></td>
                   <td><?php echo e($arr[$item->id]['num'], false); ?></td>
                   <td><?php echo e($gzprice[$item->id], false); ?></td>
                   <td><b><?php echo e($arr[$item->id]['total'], false); ?></b></td>
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
 <div class="text-center"><?php echo e($works->links(), false); ?></div>
<hr>
<div class="print-btns text-center"><button type="button" class="btn btn-primary" onclick="javascript:window.history.go(-1);">返回</button> <button type="button" class="btn btn-success" onclick="javascript:print()">打印</button></div>
<script>
function print(){$("#need-print-area").printArea();}
laydate.render({elem: '#btwdate',range: '_'});

$(function(){
    $('.search').click(function(){
        $.pjax({container:'#pjax-container', url: "/admin/company/<?php echo e($company->id, false); ?>"+'?btwdate='+$('#btwdate').val() });
    })
})



</script>