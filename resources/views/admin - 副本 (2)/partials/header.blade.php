  <div class="top">
        <div class="blank5"></div>
        <div class="page-content text-right"><p>{{ Admin::user()->name }}，欢迎你！上次登录 {{ Admin::user()->updated_at }}  <a href="{{ admin_base_path('auth/logout') }}" class="btn btn-default btn-flat">{{ trans('admin.logout') }}</a></p></div>
        <div class="blank5"></div>
    </div>
<div class="bg-white">
    <div class="page-content head">
        <div class="blank15"></div>
        <a href="/"><img src="/images/b_03.jpg" alt=""></a>
        <div class="blank15"></div>
    </div>
</div>