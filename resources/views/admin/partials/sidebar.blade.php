
@if(Admin::user()->isRole('shopadmin'))

<div class="leftbar fl">
        <div class="blank30"></div>
            <ul class="menu">
                <li @if(request()->get('status')=='0') class="on" @endif><a href="{{ route('order.index',['status'=>0]) }}">收单</a></li>
                <li @if(request()->route()->getName()=='order.index' && request()->get('status')!='0') class="on" @endif><a href="{{ route('order.index') }}">查询明细</a></li>
                <li @if(request()->route()->getName()=='product.index') class="on" @endif><a href="{{ route('product.index') }}">商品管理</a></li>
                <li @if(request()->route()->getName()=='product_type.index') class="on" @endif><a href="{{ route('product_type.index') }}">商品类型</a></li>
                <li @if(request()->route()->getName()=='bill.index') class="on" @endif><a href="{{ route('bill.index') }}">对账明细</a></li>
            </ul>
        <div class="blank30"></div>
</div>

@elseif(Admin::user()->isRole('kfcenter'))
<div class="leftbar fl">
        <div class="blank30"></div>
            <ul class="menu">
                <li @if(request()->route()->getName()=='customer.index') class="on" @endif><a href="{{ route('customer.index') }}">患者管理</a></li>
				<li @if(request()->route()->getName()=='income.index') class="on" @endif><a href="{{ route('income.index') }}">工作管理</a></li>
				<li @if(request()->route()->getName()=='cashout.index') class="on" @endif><a href="{{ route('cashout.index') }}">提现管理</a></li>
				<li @if(request()->route()->getName()=='wage.index') class="on" @endif><a href="{{ route('wage.index') }}">工资管理</a></li>
				<li @if(request()->route()->getName()=='company.index') class="on" @endif><a href="{{ route('company.index') }}">工厂管理</a></li>
                <li @if(request()->route()->getName()=='work.index') class="on" @endif><a href="{{ route('work.index') }}">工种管理</a></li>
                <li @if(request()->route()->getName()=='jslog.index') class="on" @endif><a href="{{ route('jslog.index') }}">工厂结算</a></li>
                <li @if(request()->route()->getName()=='order.index') class="on" @endif><a href="{{ route('order.index') }}">消费查询</a></li>
				<li @if(request()->route()->getName()=='users.index') class="on" @endif><a href="{{ route('users.index') }}">账号管理</a></li>
				 <li @if(request()->route()->getName()=='order.index') class="on" @endif><a href="{{ route('order.index') }}">订单管理</a></li>
            </ul>
        <div class="blank30"></div>
</div>

@else
<div class="leftbar fl">
        <div class="blank30"></div>
            <ul class="menu">
                <li @if(request()->route()->getName()=='customer.index') class="on" @endif><a href="{{ route('customer.index') }}">患者管理</a></li>
                <li @if(request()->route()->getName()=='order.index') class="on" @endif><a href="{{ route('order.index') }}">订单管理</a></li>
                <li @if(request()->route()->getName()=='income.index') class="on" @endif><a href="{{ route('income.index') }}">工作管理</a></li>
                <li @if(request()->route()->getName()=='order.index') class="on" @endif><a href="{{ route('order.index') }}">消费查询</a></li>
            </ul>
        <div class="blank30"></div>
</div>
@endif