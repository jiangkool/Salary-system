<!--startprint-->
<div id="need-print-area">
<table class="table table-bordered table-condensed" cellpadding="10">
  <tr>
    <td colspan="2" align="center"><h4 class="text-center" style="padding:12px 0;font-weight: 700">【 {{ $cashout->customer->name }} 】 提现明细</h4> </td>
  </tr>
  <tr>
    <td align="center">住院号：</td>
    <td><b class="text-uppercase">{{ $cashout->hospital_code  }}</b></td>
  </tr>
  <tr>
    <td align="center">院区：</td>
    <td><b>{{ $cashout->customer->area->area }}</b></td>
  </tr>
  <tr>
    <td align="center">提现金额：</td>
    <td><b style="font-size: 18px">{{ $cashout->money }}</b> 元</td>
  </tr>
  <tr>
    <td align="center">提现时间：</td>
    <td><b>{{ $cashout->created_at }}</b></td>
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