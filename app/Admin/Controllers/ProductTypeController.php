<?php

namespace App\Admin\Controllers;

use App\Models\ProductType;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class ProductTypeController extends Controller
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

            $content->header('商品类型');
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

            $content->header('商品类型');
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

            $content->header('商品类型');
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
        return Admin::grid(ProductType::class, function (Grid $grid) {

            $grid->id('ID')->sortable();
            $grid->type('类型名称');
            $grid->created_at('添加时间');
            $grid->updated_at('更新时间');

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
                $filter->like('type', '类型名称');
            });

            $grid->actions(function ($actions) {
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
        return Admin::form(ProductType::class, function (Form $form) {

            $form->display('id', 'ID');
            $form->text('type','类型名称')->rules(function($form){
                if (!$form->model()->id) {
                    return 'required|unique:product_types';
                }else{
                    return 'required';
                }
            });
            $form->display('created_at', 'Created At');
            $form->display('updated_at', 'Updated At');

              $form->tools(function (Form\Tools $tools) {
                // 去掉`删除`按钮
                $tools->disableDelete();
                // 去掉`查看`按钮
                $tools->disableView();

            });

        });
    }
}
