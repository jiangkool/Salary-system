@extends('admin::main')
@section('content')
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
				<a href="">
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
				<a href="">
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
				<a href="{{ route('product.index') }}">
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
@endsection