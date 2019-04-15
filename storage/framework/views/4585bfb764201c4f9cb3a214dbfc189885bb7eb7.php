<?php $__env->startSection('content'); ?>
<style>
	.kful li{margin: 0 80px}
</style>
<div class="banner3">
	</div>
	<div class="blank30"></div>
	<div class="box-center kfcenter">
		<ul class="kful">
			<li>
				<div class="blank30"></div>
				<a href="<?php echo e(route('order.index',['status'=>0]), false); ?>">
					<img src="/images/c_05.jpg" alt="">
					<br>
					<p>
						<b>收单</b>
						<br>
						<small>打印明细一键出货</small>
					</p>
				</a>
			</li>
			
			<li>
				<div class="blank30"></div>
				<a href="<?php echo e(route('order.index'), false); ?>">
					<img src="/images/c_07.jpg" alt="">
					<br>
					<p>
						<b>查询</b>
						<br>
						<small>查询历史明细</small>
					</p>
				</a>
			</li>
			<li>
				<div class="blank30"></div>
				<a href="<?php echo e(route('product.index'), false); ?>">
					<img src="/images/c_09.jpg" alt="">
					<br>
					<p>
						<b>商品管理</b>
						<br>
						<small>分类管理和上架</small>
					</p>
				</a>
			</li>
						
		</ul>
	</div>
	<div class="blank30"></div>
	<div class="blank15"></div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin::main', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>