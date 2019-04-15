@extends('admin::main')

@section('content')
<div class="banner"></div>
	<div class="blank30"></div>
	<div class="box-center kfcenter">
		<ul class="kful">
			<li>
				<div class="blank30"></div>
				<a href="{{ route('customer.index') }}">
					<img src="/images/b_09.jpg" alt="">
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
				<a href="{{ route('work.index') }}">
					<img src="/images/b_11.jpg" alt="">
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
				<a href="">
					<img src="/images/b_13.jpg" alt="">
					<br>
					<p>
						<b>工薪管理</b>
						<br>
						<small>患者工作价值核算</small>
					</p>
				</a>
			</li><li>
				<div class="blank30"></div>
				<a href="">
					<img src="/images/b_15.jpg" alt="">
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
				<a href="">
					<img src="/images/b_17.jpg" alt="">
					<br>
					<p>
						<b>消费查询</b>
						<br>
						<small>查询患者消费情况</small>
					</p>
				</a>
			</li><li>
				<div class="blank30"></div>
				<a href="">
					<img src="/images/b_24.jpg" alt="">
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
	@endsection