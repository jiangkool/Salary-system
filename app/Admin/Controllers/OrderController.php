<?php

namespace App\Admin\Controllers;

use App\Models\Order;
use App\Models\Customer;
use App\Models\Product;
use App\Models\OrderItem;
use App\Models\Area;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use Illuminate\Support\MessageBag;
use App\Admin\Extensions\Tools\OrderDelete;
use App\Admin\Extensions\Tools\MakePrintTool;

class OrderController extends Controller
{
    use ModelForm;

    /**
     * Index interface.
     *
     * @return Content
     */
    public function index()
    {
        return Admin::content(function (Content $content) {

            $content->header('订单管理');
            $content->description('列表');

            $content->body($this->grid());
        });
    }

    /**
     * Edit interface.
     *
     * @param $id
     * @return Content
     */
    public function edit($id)
    {
        return Admin::content(function (Content $content) use ($id) {

            $content->header('订单管理');
            $content->description('编辑');

            $content->body($this->form()->edit($id));
        });
    }

    /**
     * Create interface.
     *
     * @return Content
     */
    public function create()
    {
        return Admin::content(function (Content $content) {

            $content->header('订单管理');
            $content->description('下单');

            $content->body($this->form());
        });
    }

    /**
     * bill interface.
     *
     * @return Content
     */
    public function bill()
    {
        return Admin::content(function (Content $content) {

            $content->header('账单管理');
            $content->description('列表');
            $billModel=Order::query();
            if (request()->get('btwdate') && $darr=explode('_', request()->get('btwdate'))) {
                $billModel->whereDate('created_at','>=',$darr[0])->whereDate('created_at','<=',$darr[1]);
            }

            if ($hoscode=request()->get('hospital_code')) {
               if($customer_ids=Customer::where('hospital_code','like','%'.$hoscode.'%')->pluck('id')){
                  $billModel->whereIn('customer_id',$customer_ids);
               }
            }
            $billModel->where('status',1);
            $content->body(view('admin.bill',['bill'=>$billModel->with('customer')->paginate(20)])->render());
        });
    }

    /**
     * Delete order by orderId.
     * 
     * @param   $id order id.
     * @return Content
     */
    public function del($id)
    {
        $model=Order::where('id',$id)->first();

        try {

            \DB::transaction(function () use($model,$id) {
                $model->balance()->increment('balance', $model->total);
                $model->destroy($id);
            });

            $data = [
                'status'  => true,
                'message' => trans('admin.delete_succeeded'),
            ];

        } catch (Exception $e) {

             $data = [
                'status'  => false,
                'message' => trans('admin.delete_failed'),
            ];
        }

        $data['status']?admin_toastr($data['message'], 'error'):admin_toastr($data['message'], 'success');
        return back();
    }

    /**
     * Billing an order.
     * 
     * @param  Order  $order 
     * @return Json
     */
    public function billing(Order $order)
    {
        try {

            $order->status=1;
            $order->save();
            return response()->json(['message'=>'出单成功！','status'=>1],200);

        } catch (Exception $e) {

            return response()->json(['message'=>'出单失败！','status'=>0],200);
        }
        
    }

    /**
     * Print an order.
     * 
     * @param  Order  $order
     * @return Content
     */
    public function print(Order $order)
    {
         return Admin::content(function (Content $content) use($order) {

            $content->header('订单打印');
            $content->description('预览');
            $orderItems=$order->load('items')->items;
            $customer=$order->load('customer');
            $printView=view('admin.print',compact('order','customer','orderItems'))->render();
            $content->body($printView);
        });
    }

    /**
     * Show customer's orders.
     *  
     * @param  int $id
     * @return Content
     */
    public function show($id)
    {
        return Admin::content(function (Content $content) use($id) {
            if (Admin::user()->inRoles(['administrator','kfcenter'])) {
                 if($customer=Customer::where('id',$id)->first()){
                   
                    $totalxf=Order::where('customer_id',$id)->pluck('total')->sum();
                    $content->header($customer->name.'--消费详情');
                    $content->description('合计：'.$totalxf.' 元');
                    $content->body($this->grid());
                
                }else{
                    abort(404);
                }

            }else{
                $area=Area::where('area',Admin::user()->roles->pluck('name')[0])->first();
                if($customer=Customer::where('id',$id)->first()){
                    if ($area->id==$customer->area_id) {
                        $totalxf=Order::where('customer_id',$id)->pluck('total')->sum();
                        $content->header($customer->name.'--消费详情');
                        $content->description('合计：'.$totalxf.' 元');
                        $content->body($this->grid());
                      }else{
                        abort(404);
                    }
                
                }else{
                    abort(404);
                }
          }
        });
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Admin::grid(Order::class, function (Grid $grid) {
            $id=request()->route()->parameter('order');

            $grid->id('ID')->sortable();

            $grid->order_code('订单号')->limit(10);
            $grid->name('姓名');
            $grid->customer()->sf_code('身份证号');
            $grid->area()->area('院区');
            $grid->total('消费金额')->label('success');
            $grid->column('订单内容')->display(function(){
                $items = $this->items->toArray();
                $str='<table width=300 class="table table-bordered table-condensed table-striped" ><tr><th>商品</th><th>单价</th><th>数量</th><th>总计</th></tr>';
                foreach ($items as $key=>$item) {
                    $product=Product::withTrashed()->find($item['product_id']);
                    $total_unit=$product->price*$item['product_num'];
                    $str.="<tr><td>{$product->product_name}</td><td>{$product->price}</td><td>{$item['product_num']}</td><td  style='color:#000'>{$total_unit}</td></tr>";
                }
                return $str."<tr><td>合计：</td><td colspan=3><b style='color:red'>{$this->total}</b> 元</td></tr></table>";
            });
            $grid->status('订单状态')->display(function($status){
                return $status==0?'<span class="label label-warning">已下单</span>':'<span class="label label-success">已出单</span>';
            });

            $grid->created_at('下单时间');

            if (!Admin::user()->isAdministrator() && !Admin::user()->isRole('shopadmin') && !Admin::user()->isRole('kfcenter')) {
                 $area=\App\Models\Area::where('area',Admin::user()->roles->pluck('name')[0])->first();
                 $grid->model()->where('area_id',$area->id)->orderBy('id','desc');
            }

            $grid->disableExport();
            $grid->filter(function($filter){
            $filter->disableIdFilter();
            $filter->like('name', '姓名');
            //$filter->like('order_code', '订单号');
			$filter->between('created_at', '下单时间')->date();
            $filter->like('customer.sf_code', '身份证号');
                if(Admin::user()->inRoles(['shopadmin','kfcenter'])){
                    $filter->equal('area_id','院区')->select(Area::pluck('area','id'));
                }
            });
            $grid->model()->orderBy('id','desc');

            if ($id) {
                $grid->model()->where('customer_id',$id);
                $grid->setResource('/admin/order');
            }

            // 如果是在未出单界面 权属商店管理 检索限制为【未出单】
            if (request()->routeIs('order.index') && request()->get('status')=='0' && Admin::user()->isRole('shopadmin')) {
                 $grid->model()->where('status',0);
            }

            if (Admin::user()->inRoles(['shopadmin'])) {
                $grid->disableCreateButton();
                $grid->disableRowSelector();
            }

           
            
            if (!Admin::user()->isAdministrator()) {
                $grid->disableRowSelector();
            }

            $grid->actions(function ($actions) {
                $actions->disableEdit();
                $actions->disableDelete();
                $actions->disableView();
                if ($actions->row->status==0 && !Admin::user()->inRoles(['shopadmin'])) {
                   $actions->append(new OrderDelete($actions->row->id,'/admin/order/','取消订单')); 
                }else{
                    $actions->append(new MakePrintTool($actions->row->id,'/admin/order/print','打印','print')); 
                }

                if (Admin::user()->isRole('shopadmin') && $actions->row->status!==1) {
                    $actions->append(new MakePrintTool($actions->row->id,'/admin/order/billing','出单','billing')); 
                  
                }
                
            });
           
         
        });

       
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(Order::class, function (Form $form) {
            //$order_id=request()->route()->parameter('order');
            //$area=\App\Models\Area::where('area',Admin::user()->roles->pluck('name')[0])->first();
            if (!$order_id=$form->model()->id) {
                $form->select('customer_id','医保卡号')->options(Customer::pluck('sf_code','id'))->loadOne('name','/api/customer')->rules('required');
                $form->select('name','患者姓名')->rules('required');
				//$form->select('area_id','院区')->options(Area::pluck('area','id'))->rules('required');
            }else{
                $form->display('hospital_code','医保卡号');
                $form->display('name','患者姓名');
            }

            $form->hasMany('items', '订单内容', function (Form\NestedForm $form) {  
                    $form->select('product_id','商品')->options(Product::pluck('product_name','id'));
                    $form->number('product_num','数量')->default(1)->help('请输入整数！');
            });

            //$aid=$area->id;
            $form->display('created_at', '下单时间');
            $form->display('updated_at', '出单时间');

             // before saved
            $form->saving(function (Form $form){
                $customer=Customer::where('id',$form->customer_id)->first();
                $form->model()->area_id=$customer->area_id;
                if (!$form->model()->id) {
                    $form->model()->order_code=Order::getOrderCode();
                }
          
            });

            // after saved
            $form->saved(function (Form $form) use($order_id){

                $items=$form->model()->items;
                $total=0;
                if(!$form->model()->balance && $form->model()->delete()){

                     $error = new MessageBag([
                        'title'   => '温馨提示',
                        'message' => '下单失败，余额不足！',
                        ]);

                        return back()->with(compact('error'));
                }
                $yue=$form->model()->balance->balance;
                foreach ($items as $item) {
                    $total+=$item->product_num*(Product::find($item->product_id)->price);
                }
                // 新增订单时
                if(!$order_id){
                    if ($total>$yue) {

                        //删除商品
                        OrderItem::where('order_id',$form->model()->id)->delete();
                        $form->model()->delete();

                        $error = new MessageBag([
                        'title'   => '温馨提示',
                        'message' => '下单失败，余额不足！',
                        ]);

                        return back()->with(compact('error'));

                    }else{
                        $form->model()->total=$total;
                        $form->model()->save();
                        $form->model()->balance()->decrement('balance', $total);
                    }
                

                }else{ //编辑订单时

                    $lgtotal=0;
                    $lgitems=OrderItem::where('order_id',$order_id)->get();
                    foreach ($lgitems as $item) {
                        $lgtotal+=$item->product_num*(Product::find($item->product_id)->price);
                    }

                   // dd($lgtotal.'//'.$yue.'//'.$form->model()->total);
                    // 如果新建商品费用大于余额
                    if ($total>$yue+$form->model()->total) {

                            // 恢复到余额 
                            $form->model()->balance()->increment('balance', $form->model()->total);
                            //$form->model()->update('total',0);
                            //删除商品
                            OrderItem::where('order_id',$order_id)->delete();

                            $error = new MessageBag([
                            'title'   => '温馨提示',
                            'message' => '下单失败，余额不足！',
                            ]);

                            return back()->with(compact('error'));

                        }else{

                            // 恢复到余额 
                            $form->model()->balance()->increment('balance', $form->model()->total);

                            $new_total=0;
                            $new_items=OrderItem::where('order_id',$form->model()->id)->lockForUpdate()->get();
                            foreach ($new_items as $item) {
                                $new_total+=$item->product_num*(Product::find($item->product_id)->price);
                            }

                            $form->model()->total=$new_total;
                            $form->model()->save();
                            $form->model()->balance()->decrement('balance', $new_total);

                    }


                }
           
               
                
                
            });

            $form->tools(function (Form\Tools $tools) {
                // 去掉`删除`按钮
                $tools->disableDelete();
                // 去掉`查看`按钮
                $tools->disableView();

            });

        });
    }
}
