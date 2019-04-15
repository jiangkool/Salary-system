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
<!--  <div class="row">
    <div class="col-lg-3 col-lg-offset-7">
        <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
            <input type="text" name="btwdate" id="btwdate" value="{{request()->get('btwdate')}}" class="form-control " style="width: 100%"  />
        </div>
    </div>
    <div class="col-lg-2">
        <button type="submit" class="btn btn-primary search">搜索</button>
    </div>
</div> -->
<hr>
<!--startprint-->
<div id="need-print-area">
    <section class="content">
        @include('admin::partials.alerts')
        @include('admin::partials.exception')
        @include('admin::partials.toastr')
        <div class="box-body table-responsive no-padding">
         <div style="border-left: 5px solid #eee">
            <p style="padding: 10px;font-size: 15px">请输入住院号后 仔细核对姓名 确认无误后 再进行下一步操作</p>
         </div>   
         <hr>

<div class="">
<div id="content">
    
    <div class="item"><div class="hz form-inline">身份证号：<input type="text" class="form-control hospital_code" name="hospital_code" id="code0" onBlur="checkUser(0)">&nbsp;&nbsp;姓名：<input type="text" class="form-control" name="name" id="name" disabled>&nbsp;&nbsp;金额：<input type="text" class="form-control" name="money" id="money0">&nbsp;&nbsp;备注：<textarea class="form-control" name="bark" id="bark0"></textarea>&nbsp;&nbsp;<button type="submit" class="btn btn-danger" value="" onclick="submit(0)" id="sub0">提交</button></div><div class="blank10"></div></div>

  </div>
<div class="text-center"><button class="btn btn-success" id="addNew">新增</button></div>
</div>

        </div>
    </section>
</div>
<!--endprint-->
 <div class="text-center"></div>
<hr>
<script src="/js/axios.min.js"></script>
<script>
function print(){$("#need-print-area").printArea();}
laydate.render({elem: '#btwdate',range: '_'});

$(function(){
    $('.search').click(function(){
        $.pjax({container:'#pjax-container', url: "/admin/wage"+'?btwdate='+$('#btwdate').val() });
    });

$("#addNew").click(function(){
  var i = document.getElementsByClassName('hospital_code').length;
  var str='<div class="item"><div class="hz form-inline">社保卡号：<input type="text" class="form-control hospital_code" name="hospital_code" id="code'+i+'" onBlur="checkUser('+i+')" >&nbsp;&nbsp;姓名：<input type="text" class="form-control" name="name" id="name" disabled>&nbsp;&nbsp;金额：<input type="text" class="form-control" name="money" id="money'+i+'">&nbsp;&nbsp;备注：<textarea class="form-control" name="bark" id="bark'+i+'"><\/textarea> &nbsp;&nbsp;<button type="submit" class="btn btn-danger" value=""  onclick="submit('+i+')" id="sub'+i+'" >提交<\/button><\/div><div class="blank10"><\/div><\/div>';

  $("#content").append(str);
  
})

})



function checkUser(i){
  console.log($('#code'+i).val());
  axios.get('/api/customer?sf_code='+$('#code'+i).val())
  .then(function (response) {
    if (typeof (response.data[0])=='undefined') {
      $('#code'+i).next('input').val('查无此人');
      $('#money'+i).attr('disabled','true');
      $('#sub'+i).attr('disabled','true');
    }else{
      $('#money'+i).removeAttr('disabled');
      $('#sub'+i).removeAttr('disabled');
      $('#code'+i).next('input').val(response.data[0].text);
    }
  })
  .catch(function (error) {
    console.log(error);
  });
}

function submit(i){
   //console.log($('#code'+i).val());
   if ($('#money'+i).val()==''||$('#money'+i).val()==null) {
    swal("金额不能为空！", "","error")
   }else{
   axios.post('/api/wage',{
    'sf_code':$('#code'+i).val(),
    'money':$('#money'+i).val(),
	'bark':$('#bark'+i).val()
   })
  .then(function (response) {
    if (response.data.status==1) {
      $('#sub'+i).removeClass('btn-danger').addClass('btn-success');
      $('#sub'+i).text('成功！');
      $('#sub'+i).attr('disabled','true');
      $('#code'+i).attr('disabled','true');
      $('#money'+i).attr('disabled','true');
	  $('#bark'+i).attr('disabled','true');
    }else{
       $('#sub'+i).text('添加失败！');
    }
  })
  .catch(function (error) {
    console.log(error);
  });

  }
}

</script>