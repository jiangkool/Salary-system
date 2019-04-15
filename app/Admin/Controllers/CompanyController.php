<?php

namespace App\Admin\Controllers;

use App\Models\Company;
use App\Models\Income;
use App\Models\IncomeWork;

use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use App\Admin\Extensions\Tools\CompanyWorkInfo;
use App\Admin\Extensions\Tools\DeleteButton;

class CompanyController extends Controller
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
            ->header('工厂管理')
            ->description('列表')
            ->body($this->grid());
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
            ->header('工厂管理')
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
            ->header('工厂管理')
            ->description('添加')
            ->body($this->form());
    }

    public function show(Company $company, Content $content)
    {

        $works=$company->works()->paginate(20);
        $wids=$works->pluck('id')->toArray();
        $gzs=$works->pluck('name','id')->toArray();
        $gzprice=$works->pluck('price','id')->toArray();
        foreach ($wids as $id) {
            //dd(request()->get('btwdate'));
            $darr=[];
            request()->get('btwdate') && $darr=explode('_', request()->get('btwdate'));
            if (count($darr)>0) {
                $inworks=IncomeWork::where('work_id',$id)->whereDate('created_at','>=',$darr[0])->whereDate('created_at','<=',$darr[1])->get();
            }else{
               $inworks=IncomeWork::where('work_id',$id)->get(); 
            }
            
            $stotal=0;
            $arr[$id]['num']=$inworks->sum('num');
            foreach ($inworks as $inwork) {
                $stotal+=$inwork->num*$gzprice[$id];
            }
            $arr[$id]['total']=$stotal;
        }

        //$incomeWork=IncomeWork::whereIn('work_id',$wids)->get();
        
        return $content
            ->header('工厂管理')
            ->description('工种收入详细')
            ->body(view('admin.company',compact('works','gzs','gzprice','company','arr'))->render());
    }
	
	/**
     * Delete company.
     * 
     * @param   $id company id.
     * @return Content
     */
    public function del($id)
    {
        $model=Company::where('id',$id)->first();

        try {

            \DB::transaction(function () use($model,$id) {
                $model->works()->delete();
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
        $grid = new Grid(new Company);

        $grid->id('Id');
        $grid->company_name('工厂名称');
		$grid->company_code('营业执照');
        $grid->yz_total('总计金额');
        $grid->yj_total('已进账');
        $grid->wj_total('结余情况')->display(function($tt){
            if ($tt>=0) {
                return "<label class='label label-success'>{$tt} 元</label>";
            }else{
                return "<label class='label label-danger'>{$tt} 元</label>";
            }
        });
        $grid->created_at('录入时间');
        $grid->updated_at('更新时间');
		$grid->disableRowSelector();
        $grid->actions(function ($actions) {
            $actions->disableView();
			$actions->disableEdit();
			$actions->disableDelete();
            $actions->append(new DeleteButton($actions->row->id,'/admin/company/','删除工厂','fa-trash','btn-warning'));
            $actions->append(new CompanyWorkInfo($actions->row->id,'/admin/company','工种详细','show'));
        });
        $grid->disableExport();
		$grid->filter(function($filter){
            $filter->disableIdFilter();
            $filter->like('company_name', '工厂名称');
        });
        return $grid;
    }


    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Company);
        if ($id=$form->model()->id) {
            $form->text('company_name', '公司名称')->rules('required');
			$form->text('company_code', '营业执照')->rules('required|unique:companies,company_code,'.$id.',id');
            $form->display('yj_total', '已进账')->setWidth(4,2);
            $form->text('yj_add', '本次进账')->setWidth(4,2)->help('单位为 元');
            $form->saved(function (Form $form) {
                $form->model()->yj_total=$form->model()->yj_total+$form->model()->yj_add;
                $form->model()->wj_total=$form->model()->yj_total-$form->model()->yz_total;
                $form->model()->yj_add =0.00;
                $form->model()->save();
            });

        }else{
            $form->text('company_name', '公司名称')->rules('required|unique:companies');
			$form->text('company_code', '营业执照')->rules('required|unique:companies');
        }

         $form->tools(function (Form\Tools $tools) {
                $tools->disableDelete();
                $tools->disableView();
            });

        return $form;
    }
}
