    @if(!empty($header))
    <section class="content-header">
        <h1>
            {{ $header or trans('admin.title') }}
            <small>{{ $description or trans('admin.description') }}</small>
        </h1>

        <!-- breadcrumb start -->
        @if ($breadcrumb)
        <ol class="breadcrumb" style="margin-right: 30px;">
            <li><a href="{{ admin_url('/') }}"><i class="fa fa-dashboard"></i> Home</a></li>
            @foreach($breadcrumb as $item)
                @if($loop->last)
                    <li class="active">
                        @if (array_has($item, 'icon'))
                            <i class="fa fa-{{ $item['icon'] }}"></i>
                        @endif
                        {{ $item['text'] }}
                    </li>
                @else
                <li>
                    <a href="{{ admin_url(array_get($item, 'url')) }}">
                        @if (array_has($item, 'icon'))
                            <i class="fa fa-{{ $item['icon'] }}"></i>
                        @endif
                        {{ $item['text'] }}
                    </a>
                </li>
                @endif
            @endforeach
        </ol>
        @endif
        <!-- breadcrumb end -->

    </section>
    @endif

 <div class="row">
    <div class="col-lg-3 col-lg-offset-7">
        <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
            <input type="text" name="btwdate" id="btwdate" value="{{request()->get('btwdate')}}" class="form-control " style="width: 100%"  />
        </div>
    </div>
    <div class="col-lg-2">
        <button type="submit" class="btn btn-primary search">搜索</button>
    </div>
</div>
<hr>
<!--startprint-->
<div id="need-print-area">
    <section class="content">
        @include('admin::partials.alerts')
        @include('admin::partials.exception')
        @include('admin::partials.toastr')
        
        <div class="box-body table-responsive no-padding">
         <div style="border-left: 5px solid #eee">
            <p style="padding: 10px;font-size: 15px">工厂名称：<b>{{ $company->company_name }}</b> &nbsp;&nbsp;&nbsp;&nbsp;<span>已做金额：<b>{{ $company->yz_total }}</b></span> 元  &nbsp;&nbsp;&nbsp;&nbsp;<span>已结金额：<b>{{ $company->yj_total }}</b></span> 元  @if($company->wj_total<0) &nbsp;&nbsp;&nbsp;&nbsp;未结金额：<b>{{ abs($company->wj_total) }}</b>  元@endif</p>
         </div>   
         <hr>
        <table class="table table-hover table-striped table-bordered">
            <thead>
                <tr>
                    <th>工种名称</th><th>数量</th><th>单价(元)</th><th>合计(元)</th>
                </tr>
            </thead>
            <tbody>
                @php
                  $total=0;
                @endphp

               @foreach($works as $item)
               @php
                $total+=$arr[$item->id]['total'];
               @endphp
               <tr>
                   <td>{{$gzs[$item->id]}}</td>
                   <td>{{$arr[$item->id]['num']}}</td>
                   <td>{{$gzprice[$item->id]}}</td>
                   <td><b>{{$arr[$item->id]['total']}}</b></td>
               </tr>
               @endforeach
               <tr>
                   <td><b>@if(request()->get('btwdate')) 该时间段合计  @else 本页合计 @endif</b></td>
                   <td colspan="3"><b>{{$total}}</b> 元</td>
               </tr>
            </tbody>
        </table>
    </div>
    <div class="text-center" style="padding: 15px 0"><p>&copy; {{ date('Y') }} 福州神康医院 版权所有 </p></div>
    </section>
</div>
<!--endprint-->
 <div class="text-center">{{ $works->links() }}</div>
<hr>
<div class="print-btns text-center"><button type="button" class="btn btn-primary" onclick="javascript:window.history.go(-1);">返回</button> <button type="button" class="btn btn-success" onclick="javascript:print()">打印</button></div>
<script>
function print(){$("#need-print-area").printArea();}
laydate.render({elem: '#btwdate',range: '_'});

$(function(){
    $('.search').click(function(){
        $.pjax({container:'#pjax-container', url: "/admin/company/{{ $company->id }}"+'?btwdate='+$('#btwdate').val() });
    })
})



</script>