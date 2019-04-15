<?php

namespace App\Admin\Controllers;

use App\Models\Wage;
use App\Models\Area;
use App\Models\Customer;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class WageController extends Controller
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
        $model=Wage::query();
        if(request()->get('btwdate') && $darr=explode('_', request()->get('btwdate'))){
            $model->whereDate('created_at','>=',$darr[0])->whereDate('created_at','<=',$darr[1]);
        }
        if (request()->get('id')) {
            $model->where('customer_id',request()->get('id'));
        }
        $wages=$model->orderBy('id','desc')->paginate(20);
        //dd($wages);
        return $content
            ->header('工资管理')
            ->description('列表')
            ->body(view('admin.wages',compact('wages'))->render());
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
            ->header('工资管理')
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
            ->header('工资管理')
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
            ->header('工资管理')
            ->description('新增')
            ->body(view('admin.createWage',['areas'=>Area::all()])->render());
    }


    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Wage);

        $grid->id('Id');
        $grid->customer()->hospital_code('社保卡号');
        $grid->customer()->name('姓名');
        // $grid->column('姓名')->display(function(){
        //     return Customer::where('customer_id',$this->customer_id)->first()->name;
        // });
        $grid->money('工资金额');
        $grid->created_at('录入时间');

        $grid->actions(function ($actions) {
            // $actions->disableDelete();
            $actions->disableEdit();
            $actions->disableView();
        });
        $grid->disableRowSelector();
        $grid->disableExport();
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
        $show = new Show(Wage::findOrFail($id));

        $show->id('Id');
        $show->hospital_code('Hospital code');
        $show->money('Money');
        $show->name('Name');
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
        $form = new Form(new Wage);

        $form->text('hospital_code', '住院号');
        $form->decimal('money', '工资金额')->default(0.00);
        $form->text('name', 'Name');

        return $form;
    }
}
