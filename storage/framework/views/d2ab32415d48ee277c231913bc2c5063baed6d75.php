
<?php if(Admin::user()->isRole('shopadmin')): ?>

<div class="leftbar fl">
        <div class="blank30"></div>
            <ul class="menu">
                <li <?php if(request()->get('status')=='0'): ?> class="on" <?php endif; ?>><a href="<?php echo e(route('order.index',['status'=>0]), false); ?>">收单</a></li>
                <li <?php if(request()->route()->getName()=='order.index' && request()->get('status')!='0'): ?> class="on" <?php endif; ?>><a href="<?php echo e(route('order.index'), false); ?>">查询明细</a></li>
                <li <?php if(request()->route()->getName()=='product.index'): ?> class="on" <?php endif; ?>><a href="<?php echo e(route('product.index'), false); ?>">商品管理</a></li>
                <li <?php if(request()->route()->getName()=='product_type.index'): ?> class="on" <?php endif; ?>><a href="<?php echo e(route('product_type.index'), false); ?>">商品类型</a></li>
                <li <?php if(request()->route()->getName()=='bill.index'): ?> class="on" <?php endif; ?>><a href="<?php echo e(route('bill.index'), false); ?>">对账明细</a></li>
            </ul>
        <div class="blank30"></div>
</div>

<?php elseif(Admin::user()->isRole('kfcenter')): ?>
<div class="leftbar fl">
        <div class="blank30"></div>
            <ul class="menu">
                <li <?php if(request()->route()->getName()=='customer.index'): ?> class="on" <?php endif; ?>><a href="<?php echo e(route('customer.index'), false); ?>">患者管理</a></li>
				<li <?php if(request()->route()->getName()=='income.index'): ?> class="on" <?php endif; ?>><a href="<?php echo e(route('income.index'), false); ?>">工作管理</a></li>
				<li <?php if(request()->route()->getName()=='cashout.index'): ?> class="on" <?php endif; ?>><a href="<?php echo e(route('cashout.index'), false); ?>">提现管理</a></li>
				<li <?php if(request()->route()->getName()=='wage.index'): ?> class="on" <?php endif; ?>><a href="<?php echo e(route('wage.index'), false); ?>">工资管理</a></li>
				<li <?php if(request()->route()->getName()=='company.index'): ?> class="on" <?php endif; ?>><a href="<?php echo e(route('company.index'), false); ?>">工厂管理</a></li>
                <li <?php if(request()->route()->getName()=='work.index'): ?> class="on" <?php endif; ?>><a href="<?php echo e(route('work.index'), false); ?>">工种管理</a></li>
                <li <?php if(request()->route()->getName()=='jslog.index'): ?> class="on" <?php endif; ?>><a href="<?php echo e(route('jslog.index'), false); ?>">工厂结算</a></li>
                <li <?php if(request()->route()->getName()=='order.index'): ?> class="on" <?php endif; ?>><a href="<?php echo e(route('order.index'), false); ?>">消费查询</a></li>
				<li <?php if(request()->route()->getName()=='users.index'): ?> class="on" <?php endif; ?>><a href="<?php echo e(route('users.index'), false); ?>">账号管理</a></li>
				 <li <?php if(request()->route()->getName()=='order.index'): ?> class="on" <?php endif; ?>><a href="<?php echo e(route('order.index'), false); ?>">订单管理</a></li>
            </ul>
        <div class="blank30"></div>
</div>

<?php else: ?>
<div class="leftbar fl">
        <div class="blank30"></div>
            <ul class="menu">
                <li <?php if(request()->route()->getName()=='customer.index'): ?> class="on" <?php endif; ?>><a href="<?php echo e(route('customer.index'), false); ?>">患者管理</a></li>
                <li <?php if(request()->route()->getName()=='order.index'): ?> class="on" <?php endif; ?>><a href="<?php echo e(route('order.index'), false); ?>">订单管理</a></li>
                <li <?php if(request()->route()->getName()=='income.index'): ?> class="on" <?php endif; ?>><a href="<?php echo e(route('income.index'), false); ?>">工作管理</a></li>
                <li <?php if(request()->route()->getName()=='order.index'): ?> class="on" <?php endif; ?>><a href="<?php echo e(route('order.index'), false); ?>">消费查询</a></li>
            </ul>
        <div class="blank30"></div>
</div>
<?php endif; ?>