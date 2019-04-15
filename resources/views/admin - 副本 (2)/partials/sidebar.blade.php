
@if(Encore\Admin\Facades\Admin::user()->roles->pluck('slug')[0]=="shopadmin")

<div class="leftbar fl">
        <div class="blank30"></div>
            <ul class="menu">
                <li class="on"><a href="">收单</a></li>
                <li><a href="">查询明细</a></li>
                <li><a href="{{ route('product.index') }}">商品管理</a></li>
                <li><a href="{{ route('product_type.index') }}">商品类型</a></li>
            </ul>
        <div class="blank30"></div>
</div>

@elseif((Encore\Admin\Facades\Admin::user()->roles->pluck('slug')[0]=="kfcenter"))
<div class="leftbar fl">
        <div class="blank30"></div>
            <ul class="menu">
                <li class="on"><a href="{{ route('customer.index') }}">患者管理</a></li>
                <li><a href="{{ route('work.index') }}">工种管理</a></li>
                <li><a href="">工薪管理</a></li>
                <li><a href="">工作管理</a></li>
                <li><a href="">消费查询</a></li>
                <li><a href="">账号管理</a></li>
            </ul>
        <div class="blank30"></div>
</div>


@else
<div class="leftbar fl">
        <div class="blank30"></div>
            <ul class="menu">
                <li class="on"><a href="{{ route('customer.index') }}">患者管理</a></li>
                <li><a href="">消费下单</a></li>
                <li><a href="">工作管理</a></li>
                <li><a href="">消费查询</a></li>
            </ul>
        <div class="blank30"></div>
</div>


@endif