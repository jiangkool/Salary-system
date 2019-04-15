<?php

namespace App\Admin\Controllers;

use App\Models\Cashout;
use App\Models\Customer;
use App\Models\Balance;

use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use Illuminate\Support\MessageBag;
use App\Admin\Extensions\Tools\OrderDelete;
use App\Admin\Extensions\Tools\MakePrintTool;

class CashoutController extends Controller
{
    use HasResourceActions;

    /**
     * Index interface.
     *
     * @param Content $content
     * @return Content
     */
    public function index(Content $content)
    {
        return $content
            ->header('提现管理')
            ->description('列表')
            ->body($this->grid());
    }

    /**
     * Show interface.
     *
     * @param mixed   $id
     * @param Content $content
     * @return Content
     */
    public function show($id, Content $content)
    {
        return $content
            ->header('提现管理')
            ->description('description')
            ->body($this->detail($id));
    }

    /**
     * Edit interface.
     *
     * @param mixed   $id
     * @param Content $content
     * @return Content
     */
    public function edit($id, Content $content)
    {
        return $content
            ->header('提现管理')
            ->description('编辑')
            ->body($this->form()->edit($id));
    }

    /**
     * Create interface.
     *
     * @param Content $content
     * @return Content
     */
    public function create(Content $content)
    {
        return $content
            ->header('提现管理')
            ->description('新增')
            ->body($this->form());
    }

    /**
     * Delete cashout by orderId.
     * 
     * @param   $id cashout id.
     * @return Content
     */
    public function del($id)
    {
        $model=Cashout::find($id);

        try {

            \DB::transaction(function () use($model,$id) {
                Balance::where('customer_id',$model->customer_id)->increment('balance', $model->money);
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
     * Print an order.
     * 
     * @param  Order  $order
     * @return Content
     */
    public function print(Cashout $cashout,Content $content)
    {
        return $content
            ->header('提现打印')
            ->description('预览')
            ->body(view('admin.cprint',compact('cashout'))->render());
    }


    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Cashout);

        $grid->id('Id');
        $grid->column('姓名')->display(function(){
            return Customer::withTrashed()->where('id',$this->customer_id)->first()->name;
        });
        //$grid->hospital_code('医保卡号');
        $grid->column('院区')->display(function(){
            return Customer::withTrashed()->where('id',$this->customer_id)->first()->area->area;
        });
        $grid->money('提现金额');
        $grid->created_at('提现时间');
        $grid->updated_at('更新时间');
        $grid->disableExport();
		$grid->disableRowSelector();
        $grid->actions(function ($actions) {
            $actions->disableView();
            $actions->disableEdit();
            $actions->disableDelete();
            //$actions->append(new OrderDelete($actions->row->id,'/admin/cashout/','取消提现'));
            $actions->append(new MakePrintTool($actions->row->id,'/admin/cashout/print','打印','print')); 

        });
        $grid->filter(function($filter){
            $filter->disableIdFilter();
            $filter->like('customer.hospital_code', '医保卡号');
			$filter->like('customer.name', '姓名');
			$filter->between('created_at', '提现时间')->date();
        });
        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed   $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Cashout::findOrFail($id));

        $show->id('Id');
        $show->hospital_code('Hospital code');
        $show->money('Money');
        $show->created_at('Created at');
        $show->updated_at('Updated at');

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Cashout);
 
        $form->select('customer_id', '身份证号')->options(Customer::pluck('sf_code','id'))->loadOne('name','/api/customer');
        $form->select('name','患者姓名')->rules('required');
        $form->text('money', '提现金额')->rules('required');

        $form->tools(function (Form\Tools $tools) {
                $tools->disableDelete();
                $tools->disableView();
            });
        
        $form->saving(function (Form $form) {

            $balance=Balance::where('customer_id',$form->customer_id)->first();
            if ($form->money>$balance->balance) {
                $error = new MessageBag([
                    'title'   => '温馨提示',
                    'message' => '该客户余额不足！【客户可提现金额：'.$balance->balance.' 元】',
                ]);
                return back()->with(compact('error'));
            }

        });
        
        $form->saved(function(Form $form){
            Balance::where('customer_id',$form->model()->customer_id)->decrement('balance',$form->model()->money);
        });

        return $form;
    }


}
