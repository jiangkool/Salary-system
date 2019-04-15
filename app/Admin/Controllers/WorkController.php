<?php

namespace App\Admin\Controllers;

use App\Models\Work;
use App\Models\Company;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class WorkController extends Controller
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

            $content->header('工种管理');
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

            $content->header('工种管理');
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

            $content->header('工种管理');
            $content->description('新增');

            $content->body($this->form());
        });
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Admin::grid(Work::class, function (Grid $grid) {

            $grid->id('ID')->sortable();
            $grid->name('名称')->sortable();
            $grid->company_id('所属单位')->display(function($id){
                $company=Company::withTrashed()->find($id);
                return $company->deleted_at==null?$company->company_name:$company->company_name.'(该工厂已删除)';

            });
            $grid->work_unit('每单位数量');
            $grid->price('每单位工薪')->sortable();

            //禁用导出
            $grid->disableExport();

            //禁止批量删除
            $grid->tools(function ($tools) {
                $tools->batch(function ($batch) {
                    $batch->disableDelete();
                });
            });

            $grid->filter(function($filter){
                $filter->disableIdFilter();
				$filter->like('name', '工种名称');
                $filter->equal('company_id','公司名称')->select(Company::pluck('company_name','id'));
            });
            $grid->created_at('录入时间');

           $grid->actions(function($actions){
                $actions->disableView();
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
        return Admin::form(Work::class, function (Form $form) {

            $form->display('id', 'ID');

            $form->text('name','名称')->rules(function ($form) {
                // 如果不是编辑状态，则添加字段唯一验证
                if (!$id = $form->model()->id) {
                    return 'required|unique:works';
                }else{
                    return 'required';
                }
            });
            $form->select('company_id','所属单位')->options(Company::pluck('company_name','id'));
            $form->number('work_unit','每单位数量')->min(1);
            $form->currency('price','每单位工薪')->symbol('￥')->rules('required');

            $form->display('created_at', 'Created At');
            $form->display('updated_at', 'Updated At');
            $form->tools(function (Form\Tools $tools) {
                $tools->disableDelete();
                $tools->disableView();
            });
        });
    }
}
