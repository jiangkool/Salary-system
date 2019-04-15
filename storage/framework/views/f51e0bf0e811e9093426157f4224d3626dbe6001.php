<!--startprint-->
<div id="need-print-area">
<table class="table table-bordered table-condensed" cellpadding="10">
  <tr>
    <td colspan="2" align="center"><h4 class="text-center" style="padding:12px 0;font-weight: 700">【 NO.<?php echo e($order->id, false); ?> 】 订单信息</h4> </td>
  </tr>
  <tr>
    <td align="center">订单编号：</td>
    <td><b class="text-uppercase"><?php echo e($order->order_code, false); ?></b></td>
  </tr>
  <tr>
    <td align="center">下单时间：</td>
    <td><b class="text-uppercase"><?php echo e($order->created_at, false); ?></b></td>
  </tr>
  <tr>
    <td align="center">客户信息：</td>
    <td><table class="table  table-bordered table-condensed table-striped">
		<tr>
			<th>姓名</th>
			<th>性别</th>
			<th>院区</th>
			<th>社保卡号</th>
		</tr>
		<tr>
			<td><?php echo e($order->name, false); ?></td>
			<td><?php echo e($customer->sex?'男':'女', false); ?></td>
			<td><?php echo e($customer->area->area, false); ?></td>
			<td><?php echo e($order->customer->hospital_code, false); ?></td>
		</tr>
	</table></td>
  </tr>
  <tr>
    <td align="center">订单内容：</td>
    <td><table class="table table-bordered  table-condensed table-striped">
		<tr>
			<th>商品名称</th>
			<th>单价(元)</th>
			<th>数量</th>
			<th>合计(元)</th>
		</tr>
		<?php 
			$total=0;
		?>
		<?php $__currentLoopData = $orderItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $orderItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
		<?php
		 	$total+=$orderItem->product_num * $orderItem->product->price
		?>
		<tr>
			<td><?php echo e($orderItem->product->product_name, false); ?></td>
			<td><?php echo e($orderItem->product->price, false); ?></td>
			<td><?php echo e($orderItem->product_num, false); ?></td>
			<td><?php echo e($orderItem->product_num * $orderItem->product->price, false); ?></td>
		</tr>
		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		<tr><td>总计：</td><td colspan="3"> <b style="font-size: 18px"><?php echo e($total, false); ?></b> 元</td></tr>
	</table></td>
  </tr>
  <tr>
    <td align="center">订单总计：</td>
    <td><b style="font-size: 18px"><?php echo e($total, false); ?></b> 元</td>
  </tr>
</table>
<div class="text-center" style="padding-bottom: 15px"><p>&copy; <?php echo e(date('Y'), false); ?> 福州神康医院 版权所有 </p></div>
</div>
<!--endprint-->
<hr>
<div class="print-btns text-center"><button type="button" class="btn btn-primary" onclick="javascript:window.history.go(-1);">返回</button> <button type="button" class="btn btn-success" onclick="javascript:print()">打印</button></div>
<script>
function print()
	{
		 $("#need-print-area").printArea();
	}
</script>