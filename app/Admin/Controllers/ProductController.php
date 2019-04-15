<?php

namespace App\Admin\Controllers;

use App\Models\Product;
use App\Models\ProductType;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class ProductController extends Controller
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

            $content->header('商品管理');
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

            $content->header('商品管理');
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

            $content->header('商品管理');
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
        return Admin::grid(Product::class, function (Grid $grid) {

            $grid->id('ID')->sortable();
            $grid->productType('类型')->type();
            $grid->product_name('名称');
            $grid->price('单价')->badge('info');
            //$grid->num('库存')->badge('danger');

            $grid->created_at('添加时间');
            $grid->updated_at('更新时间');
             $grid->disableRowSelector();
            $grid->disableExport();
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
        return Admin::form(Product::class, function (Form $form) {

            $form->display('id', 'ID');

            $form->select('type_id','类型')->options(ProductType::pluck('type','id'));
            $form->text('product_name','名称')->rules(function($form){
                if(!$form->model()->id){
                    return 'required|unique:products';
                }else{
                    return 'required';
                }
            });
            $form->currency('price','单价')->symbol('￥');
            //$form->number('num','库存')->min(0);

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
