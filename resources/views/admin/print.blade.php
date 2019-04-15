<!--startprint-->
<div id="need-print-area">
<table class="table table-bordered table-condensed" cellpadding="10">
  <tr>
    <td colspan="2" align="center"><h4 class="text-center" style="padding:12px 0;font-weight: 700">【 NO.{{ $order->id }} 】 订单信息</h4> </td>
  </tr>
  <tr>
    <td align="center">订单编号：</td>
    <td><b class="text-uppercase">{{ $order->order_code }}</b></td>
  </tr>
  <tr>
    <td align="center">下单时间：</td>
    <td><b class="text-uppercase">{{ $order->created_at }}</b></td>
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
			<td>{{ $order->name }}</td>
			<td>{{ $customer->sex?'男':'女' }}</td>
			<td>{{ $customer->area->area }}</td>
			<td>{{ $order->customer->hospital_code }}</td>
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
		@php 
			$total=0;
		@endphp
		@foreach($orderItems as $orderItem)
		@php
		 	$total+=$orderItem->product_num * $orderItem->product->price
		@endphp
		<tr>
			<td>{{ $orderItem->product->product_name }}</td>
			<td>{{ $orderItem->product->price }}</td>
			<td>{{ $orderItem->product_num }}</td>
			<td>{{ $orderItem->product_num * $orderItem->product->price }}</td>
		</tr>
		@endforeach
		<tr><td>总计：</td><td colspan="3"> <b style="font-size: 18px">{{ $total }}</b> 元</td></tr>
	</table></td>
  </tr>
  <tr>
    <td align="center">订单总计：</td>
    <td><b style="font-size: 18px">{{ $total }}</b> 元</td>
  </tr>
</table>
<div class="text-center" style="padding-bottom: 15px"><p>&copy; {{ date('Y') }} 福州神康医院 版权所有 </p></div>
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