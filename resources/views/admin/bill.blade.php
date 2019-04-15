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
  <div class="col-lg-3  col-lg-offset-4">
      <div class="input-group">
            <span class="input-group-addon">社保卡号</span>
            <input type="text" name="hospital_code" id="hospital_code" value="{{request()->get('hospital_code')}}" class="form-control " style="width: 100%"  />
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
            <p style="padding: 10px;font-size: 15px">已出订单消费明细打印</p>
         </div>   
         <hr>
        <table class="table table-hover table-striped table-bordered">
            <thead>
                <tr>
                    <th>订单号</th><th>姓名</th><th>社保卡号</th><th>院区</th><th>消费金额</th><th>下单时间</th>
                </tr>
            </thead>
            <tbody>
              @php
               $total=0;
              @endphp
             @foreach($bill as $item)

              @php
               $total+=$item->total;
              @endphp
               <tr>
                   <td>{{ $item->order_code }}</td>
                   <td>{{ $item->name }}</td>
                   <td>{{ $item->customer->hospital_code }}</td>
                   <td>{{ $item->area->area }}</td>
                   <td>{{ $item->total }}</td>
                   <td>{{ $item->created_at }}</td>
               </tr>
              @endforeach
               <tr>
                   <td><b>@if(request()->get('btwdate')) 该时间段合计  @else 本页合计 @endif</b></td>
                   <td colspan="5"><b>{{ $total }}</b> 元</td>
               </tr>
            </tbody>
        </table>
    </div>
    <div class="text-center" style="padding: 15px 0"><p>&copy; {{ date('Y') }} 福州神康医院 版权所有 </p></div>
    </section>
</div>
<!--endprint-->
 <div class="text-center">{{ $bill->links() }}</div>
<hr>
<div class="print-btns text-center"><button type="button" class="btn btn-primary" onclick="javascript:window.history.go(-1);">返回</button> <button type="button" class="btn btn-success" onclick="javascript:print()">打印</button></div>
<script>
function print(){$("#need-print-area").printArea();}
laydate.render({elem: '#btwdate',range: '_'});

$(function(){
    $('.search').click(function(){
        $.pjax({container:'#pjax-container', url: "/admin/bill"+'?btwdate='+$('#btwdate').val()+'&hospital_code='+$('#hospital_code').val()  });
    })
})



</script>