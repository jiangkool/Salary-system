<?php

namespace App\Admin\Controllers;

use App\Models\Area;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class AreaController extends Controller
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

            $content->header('院区');
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

           $content->header('院区');
            $content->description('列表');

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

           $content->header('院区');
            $content->description('列表');

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
        return Admin::grid(Area::class, function (Grid $grid) {

            $grid->id('ID')->sortable();
            $grid->area('区名');
            $grid->created_at('添加时间');
            $grid->disableRowSelector();
            $grid->actions(function($actions){
                $actions->disableView();

            });
           $grid->disableExport();
           $grid->disableFilter();
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(Area::class, function (Form $form) {

            $form->display('id', 'ID');
            $form->text('area', '院区')->rules(function($form){
                if (!$id=$form->model()->id) {
                    return 'required|unique:areas';
                }else{
                    return 'required|unique:areas,area,'.$id.',id';
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
