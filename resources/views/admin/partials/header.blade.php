  <div class="top">
        <div class="blank5"></div>
        <div class="page-content text-right"><p><span class="glyphicon glyphicon-user"></span> {{ Admin::user()->name }}，欢迎您！ <span class="fa fa-clock-o"></span> 您上次登录时间 @php @$lastLog=Admin::user()->logs()->where('path','admin/auth/logout')->pluck('created_at')->last(); @endphp   {{ $lastLog??'--' }}  &nbsp;&nbsp;&nbsp;<a href="{{ admin_base_path('auth/logout') }}" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-log-out"></span> {{ trans('admin.logout') }}</a></p></div>
        <div class="blank5"></div>
    </div>
{{-- <div class="bg-white">
    <div class="page-content head">
        <div class="blank15"></div>
        <a href="/"><img src="/images/b_03.jpg" alt=""></a>
        <div class="blank15"></div>
    </div>
</div> --}}