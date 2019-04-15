<?php

namespace App\Admin\Controllers;

use App\Models\Income;
use App\Models\Customer;
use App\Models\Work;
use App\Models\Balance;
use App\Models\Area;
use App\Models\Company;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use Encore\Admin\Widgets\Table;
use App\Admin\Extensions\Tools\OrderDelete;

class IncomeController extends Controller
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

            $content->header('工作收入');
            $content->description('列表');

            $content->body($this->grid());
        });
    }

    public function show($id)
    {
        return Admin::content(function (Content $content) use($id) {
            if (Admin::user()->inRoles(['administrator','kfcenter'])) {
                if ($customer=Customer::where('id',$id)->first()) {
                    $totalsr=Income::where('customer_id',$id)->pluck('total')->sum();
                    $content->header($customer->name.'--收入详情');
                    $content->description('共计：'.$totalsr.' 元');
                    $content->body($this->grid());
                }else{
                    abort(404);
                }
                
            }else{
                $area=Area::where('area',Admin::user()->roles->pluck('name')[0])->first();
                if($customer=Customer::where('hospital_code',$hospital_code)->first()){
                    if ($area->id==$customer->area_id) {
                        $totalsr=Income::where('hospital_code',$hospital_code)->pluck('total')->sum();
                        $content->header($customer->name.'--收入详情');
                        $content->description('共计：'.$totalsr.' 元');
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
     * Edit interface.
     *
     * @param $id
     * @return Content
     */
    public function edit($id)
    {
        return Admin::content(function (Content $content) use ($id) {

            $content->header('工作收入');
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

            $content->header('工作收入');
            $content->description('新增');

            $content->body($this->form());
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
        $model=Income::where('id',$id)->first();

        try {

            \DB::transaction(function () use($model,$id) {
                $model->balance()->decrement('balance', $model->total);
                $total=0;
                foreach ($model->works as $item) {
                    $work=Work::withTrashed()->find($item->work_id);
                    $thisTotal=$item->num*($work->price);
                    $total+=$thisTotal;
                    $company=Company::find($work->company_id);
                    $company->yz_total=$company->yz_total-$thisTotal;
                    $company->wj_total=$company->yj_total-$company->yz_total;
                    $company->save();
                }
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
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Admin::grid(Income::class, function (Grid $grid) {

            $id=request()->route()->parameter('income');

            $grid->id('ID')->sortable();
            $grid->name('姓名');
            $grid->customer()->hospital_code('医保卡号');
            $grid->area()->area('院区');
            $grid->column('工作详细')->display(function () {
                $items = $this->works->toArray();
               $str='<table width=300 class="table table-bordered table-condensed table-striped" ><tr><th>工种</th><th>单价</th><th>每单元数量</th><th>完成数量</th><th>总计</th></tr>';
                foreach ($items as $key=>$item) {
                    $work=Work::withTrashed()->find($item['work_id']);
					//dd($item['work_id']);
                    $total_unit=number_format($work->price*$item['num']/$work->work_unit,2);
                    $str.="<tr><td>{$work->name}</td><td>{$work->price}</td><td>{$work->work_unit}</td><td>{$item['num']}</td><td  style='color:#000'>{$total_unit}</td></tr>";
                }
                return $str."<tr><td>合计：</td><td colspan=4><b style='color:red'>{$this->total}</b> 元</td></tr></table>";
            });

            $grid->total('本次收入')->label('success');

            $grid->workdate('工作时间');
            $grid->created_at('录入时间');

            if (!Admin::user()->isRole('kfcenter')&& !Admin::user()->isAdministrator()) {
                 $grid->disableCreateButton();
                 $grid->disableActions();
            }
             $grid->disableActions();
             $grid->actions(function ($actions) {
                $actions->disableDelete();
                $actions->disableEdit();
                $actions->disableView();
                //$actions->append(new OrderDelete($actions->row->id,'/admin/income/','删除'));
            });
             $grid->disableExport();
            if ($id) {
                $grid->model()->where('customer_id',$id);
                //$grid->disableRowSelector();
                $grid->disableExport();
                //$grid->disableFilter();
                //$grid->disableCreateButton();

                $grid->setResource('/admin/income');
            }
            $grid->disableRowSelector();
            if (!Admin::user()->isAdministrator() && !Admin::user()->isRole('kfcenter')) {
                $grid->disableRowSelector();
                $area=Area::where('area',Admin::user()->roles->pluck('name')[0])->first();
                $grid->model()->where('area_id',$area->id);
            }

            $grid->model()->orderBy('id','desc');
            $grid->filter(function($filter){
                $filter->disableIdFilter();
                $filter->like('customer.hospital_code', '社保卡号');
                $filter->between('workdate', '工作时间')->date();
                if (Admin::user()->isRole('kfcenter')) {
                     $filter->equal('area_id','院区')->select(Area::pluck('area','id'));
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
        return Admin::form(Income::class, function (Form $form) {
            $form->display('id', 'ID');
            //$area=Area::where('area',Admin::user()->roles->pluck('name')[0])->first();
            $form->select('customer_id','身份证号')->options(customer::pluck('sf_code','id'))->loadOne('name','/api/customer')->rules('required');
            $form->select('name','患者姓名')->rules('required');
            $form->date('workdate','工作时间')->rules('required');
            $form->hasMany('works', '工作详细', function (Form\NestedForm $form) {  
                    $form->setWidth(2,2);
                    $works=Work::all();
                    $works=$works->filter(function($item, $key){
                        if (Company::find($item->company_id)) {
                            return true;
                        }else{
                            return false;
                        }
                    });
                    $form->select('work_id','工种')->options($works->pluck('name','id'));
                    $form->number('num','数量')->default(1);
                });
            $form->display('created_at', '录入时间');
            $form->display('updated_at', '更新时间');

            $form->tools(function (Form\Tools $tools) {
                $tools->disableDelete();
                $tools->disableView();
            });


            // before saved
            $form->saving(function (Form $form) {
                $form->model()->area_id=1;
          
            });

            // after saved
            $form->saved(function (Form $form) {

                //开启事务
                \DB::transaction(function () use ($form) {

                    $works=$form->model()->works;
                    $total=0;
                    foreach ($works as $item) {
                        $work=Work::find($item->work_id);
                        $thisTotal=number_format($item->num*($work->price)/($work->work_unit),2);
                        $total+=$thisTotal;
                        $company=Company::find($work->company_id);
                        $company->yz_total=$thisTotal+$company->yz_total;
                        $company->wj_total=$company->yj_total-$company->yz_total;
                        $company->save();
                    }

                    //更新院区
                    $customer=Customer::where('id',$form->model()->customer_id)->first();
                    $form->model()->total=$total;
                    $form->model()->area_id=$customer->area_id;
                    $form->model()->save();

                    //更新余额
                    if ($balance_model=Balance::where(['customer_id'=>$form->model()->customer_id])->lockForUpdate()->first()) {
                        $balance_model->increment('balance', $total);
                    }else{
                        $balance_model=Balance::create(['customer_id'=>$form->model()->customer_id,'balance'=>0.00]);
                        $balance_model->increment('balance', $total);
                    }
                });
                
                
                
            });

        });
    }
}
