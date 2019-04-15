@extends('admin::main')

@section('content')
 <style>
    .kful li{margin: 0 35px}
</style>

<div class="banner2">
        <div class="box-center">
            <h3>患者工薪管理系统({{ Encore\Admin\Facades\Admin::user()->roles->pluck('name')[0] }})</h3>
        </div>
    </div>
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
                <a href="{{ route('order.index') }}">
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
                <a href="{{ route('income.index') }}">
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
                <a href="{{ route('order.index') }}">
                    <img src="/images/b_13.jpg" alt="">
                    <br>
                    <p>
                        <b>消费查询</b>
                        <br>
                        <small>查询患者消费明细</small>
                    </p>
                </a>
            </li>           
        </ul>
    </div>
    <div class="blank30"></div>
    <div class="blank15"></div>
@endsection