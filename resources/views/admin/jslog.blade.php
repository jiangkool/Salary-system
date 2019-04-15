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
   <div class="col-lg-3">
      <a class="btn btn-success" href="{{ route('jslog.create') }}" role="button"> <i class="fa fa-plus"></i> 结算录入</a>
    </div>
    <div class="col-lg-3 col-lg-offset-1">
      <div class="input-group">
            <span class="input-group-addon">工厂名称</span>
            <select name="company_id" id="company_id"  class="form-control ">
              <option value=""></option>
              @foreach($companies as $company)
              <option value="{{ $company->id }}" @if($company->id==request()->get('company_id')) selected="true"  @endif>{{ $company->company_name }}</option>
              @endforeach
            </select>

        </div>
    </div>
    <div class="col-lg-3">
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
            <p style="padding: 10px;font-size: 15px">工厂结算记录</p>
         </div>   
         <hr>
        <table class="table table-hover table-striped table-bordered">
            <thead>
                <tr>
                    <th>工厂名称</th><th>结算金额(元)</th><th>结算时间</th>
                </tr>
            </thead>
            <tbody>
              @php
               $total=0;
              @endphp
              @foreach($jslogs as $jslog)
               @php
               $total+=$jslog->money;
               @endphp
               <tr>
                   <td>{{ App\Models\Company::withTrashed()->where('id',$jslog->company_id)->first()->company_name }}</td>
                  <td>{{ $jslog->money }}</td>
                  <td>{{ $jslog->created_at }}</td>
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
 <div class="text-center">{{ $jslogs->links() }}</div>
<hr>
<div class="print-btns text-center"><button type="button" class="btn btn-primary" onclick="javascript:window.history.go(-1);">返回</button> <button type="button" class="btn btn-success" onclick="javascript:print()">打印</button></div>
<script>
function print(){$("#need-print-area").printArea();}
laydate.render({elem: '#btwdate',range: '_'});

$(function(){
    $('.search').click(function(){
        $.pjax({container:'#pjax-container', url: "/admin/jslog"+'?btwdate='+$('#btwdate').val()+'&company_id='+$('#company_id').val() });
    })
})



</script>