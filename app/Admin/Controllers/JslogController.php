<?php

namespace App\Admin\Controllers;

use App\Models\Jslog;
use App\Models\Company;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class JslogController extends Controller
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
        $model=Jslog::query();
         if(request()->get('btwdate') && $darr=explode('_', request()->get('btwdate'))){
            $model->whereDate('created_at','>=',$darr[0])->whereDate('created_at','<=',$darr[1]);
        }
        if (request()->get('company_id')) {
            $model->where('company_id',request()->get('company_id'));
        }
        $jslogs=$model->orderBy('id','desc')->paginate(20);
        $companies=Company::all();

        return $content
            ->header('结算记录')
            ->description('列表')
            ->body(view('admin.jslog',compact('jslogs','companies'))->render());
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
            ->header('Detail')
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
            ->header('结算记录')
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
            ->header('结算记录')
            ->description('新增')
            ->body($this->form());
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Jslog);
        $grid->column('company.company_name','工厂名称');
        $grid->money('金额');

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
        $show = new Show(Jslog::findOrFail($id));



        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Jslog);

        $form->select('company_id','工厂名称')->options(Company::pluck('company_name','id'))->setWidth(4,2)->rules('required');
        $form->text('money', '结算金额')->default(0.00)->setWidth(4,2)->rules('required');

        $form->saved(function (Form $form) {
            \DB::transaction(function () use ($form) {
                $form->model()->company->yj_total=$form->model()->company->yj_total+$form->model()->money;
                $form->model()->company->wj_total=$form->model()->company->yj_total-$form->model()->company->yz_total;
                $form->model()->company->save();
            });
            
        });

        $form->tools(function (Form\Tools $tools) {
                $tools->disableDelete();
                $tools->disableView();
            });

        return $form;
    }
}
