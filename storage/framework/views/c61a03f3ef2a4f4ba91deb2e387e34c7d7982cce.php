<!--startprint-->
<div id="need-print-area">
<table class="table table-bordered table-condensed" cellpadding="10">
  <tr>
    <td colspan="2" align="center"><h4 class="text-center" style="padding:12px 0;font-weight: 700">【 <?php echo e($cashout->customer->name, false); ?> 】 提现明细</h4> </td>
  </tr>
  <tr>
    <td align="center">住院号：</td>
    <td><b class="text-uppercase"><?php echo e($cashout->hospital_code, false); ?></b></td>
  </tr>
  <tr>
    <td align="center">院区：</td>
    <td><b><?php echo e($cashout->customer->area->area, false); ?></b></td>
  </tr>
  <tr>
    <td align="center">提现金额：</td>
    <td><b style="font-size: 18px"><?php echo e($cashout->money, false); ?></b> 元</td>
  </tr>
  <tr>
    <td align="center">提现时间：</td>
    <td><b><?php echo e($cashout->created_at, false); ?></b></td>
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