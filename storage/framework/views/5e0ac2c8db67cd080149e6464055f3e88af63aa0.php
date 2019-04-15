<?php $__env->startSection('content'); ?>
<div class="banner"></div>
	<div class="blank30"></div>
	<div class="box-center kfcenter">
		<ul class="kful">
			<li>
				<div class="blank30"></div>
				<a href="<?php echo e(route('customer.index'), false); ?>">
					<img src="/images/icon6.png" alt="">
					<br>
					<p>
						<b>患者管理</b>
						<br>
						<small>患者信息录入及修改</small>
					</p>
				</a>
			</li>
			<li>
				<div class="blank30"></div>
				<a href="<?php echo e(route('work.index'), false); ?>">
					<img src="/images/icon3.png" alt="">
					<br>
					<p>
						<b>工种管理</b>
						<br>
						<small>工种设置及修改</small>
					</p>
				</a>
			</li>
			<li>
				<div class="blank30"></div>
				<a href="<?php echo e(route('income.index'), false); ?>">
					<img src="/images/icon4.png" alt="">
					<br>
					<p>
						<b>工薪管理</b>
						<br>
						<small>患者工作价值核算</small>
					</p>
				</a>
			</li><li>
				<div class="blank30"></div>
				<a href="<?php echo e(route('income.index'), false); ?>">
					<img src="/images/icon5.png" alt="">
					<br>
					<p>
						<b>工作查询</b>
						<br>
						<small>查询患者工作情况</small>
					</p>
				</a>
			</li>
			<li>
                <div class="blank30"></div>
                <a href="<?php echo e(route('order.index'), false); ?>">
                    <img src="/images/b_17.jpg" alt="">
                    <br>
                    <p>
                        <b>消费下单</b>
                        <br>
                        <small>一键快速下单</small>
                    </p>
                </a>
            </li>
			<li>
				<div class="blank30"></div>
				<a href="<?php echo e(route('order.index'), false); ?>">
					<img src="/images/icon8.png" alt="">
					<br>
					<p>
						<b>消费查询</b>
						<br>
						<small>查询患者消费情况</small>
					</p>
				</a>
			</li>
			<li>
				<div class="blank30"></div>
				<a href="<?php echo e(route('cashout.index'), false); ?>">
					<img src="/images/icon7.png" alt="">
					<br>
					<p>
						<b>提现管理</b>
						<br>
						<small>提现管理</small>
					</p>
				</a>
			</li>
			<li>
				<div class="blank30"></div>
				<a href="<?php echo e(route('company.index'), false); ?>">
					<img src="/images/icon1.png" alt="">
					<br>
					<p>
						<b>工厂管理</b>
						<br>
						<small>工厂管理</small>
					</p>
				</a>
			</li>
			<li>
				<div class="blank30"></div>
				<a href="<?php echo e(route('jslog.index'), false); ?>">
					<img src="/images/icon2.png" alt="">
					<br>
					<p>
						<b>工厂结算</b>
						<br>
						<small>工厂结算</small>
					</p>
				</a>
			</li>
			<li>
				<div class="blank30"></div>
				<a href="<?php echo e(route('users.index'), false); ?>">
					<img src="/images/icon9.png" alt="">
					<br>
					<p>
						<b>账号管理</b>
						<br>
						<small>病区账号设立及管理</small>
					</p>
				</a>
			</li>
		</ul>
	</div>
	<div class="blank15"></div>
	<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin::main', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>