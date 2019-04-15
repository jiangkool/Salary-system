<?php

namespace App\Admin\Controllers;

use App\Models\Customer;
use App\Models\Area;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use App\Admin\Extensions\Tools\BalanceButton;
use App\Admin\Extensions\CustomersExpoter;

class CustomerController extends Controller
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

            $content->header('患者管理');
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

            $content->header('患者管理');
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

            $content->header('患者管理');
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
        return Admin::grid(Customer::class, function (Grid $grid) {

            $grid->id('ID')->sortable();
            //$grid->hospital_code('社保卡号');
            $grid->name('姓名');
            $grid->sex('性别')->display(function($status){
                return $status==0?'女':'男';
            })->label('info');
			$grid->sf_code('身份证');
            $grid->area()->area('院区');
            $grid->cs_date('年龄')->display(function($csDate){
				return date('Y')-date('Y',strtotime($csDate))+1;
			});
            // $grid->status('状态')->display(function($status){
            //     return $status==0?'在院':'已出院';
            // })->label('success');
            $grid->column('所在区域')->display(function(){
                return "{$this->province}{$this->city}{$this->district}";
            });
            $grid->column('balance.balance','可用余额')->label('success');
			$grid->disableRowSelector();
            $grid->filter(function($filter){

                 $filter->disableIdFilter();
                 $filter->like('name', '姓名');
                 $filter->like('hospital_code', '社保卡号');
                 //$filter->between('created_at', '入院时间')->datetime();
				 $filter->like('sf_code', '身份证');
                 if (Admin::user()->isAdministrator()||Admin::user()->isRole('kfcenter')) {
                     $options=Area::pluck('area','id');
                     $filter->equal('area_id','院区')->select($options);
                 }
                 

            });

            if (!Admin::user()->isAdministrator() && !Admin::user()->isRole('kfcenter')) {
                $area=\App\Models\Area::where('area',Admin::user()->roles->pluck('name')[0])->first();
                $grid->model()->where('area_id', '=',$area->id );
            }
            $grid->actions(function($actions){
                $actions->disableView();
                $actions->append(new BalanceButton($actions->row->id,'/admin/income','收入'));
                $actions->append(new BalanceButton($actions->row->id,'/admin/order','消费'));


            });
            
            $grid->created_at('录入时间');
            
            $grid->exporter(new CustomersExpoter());
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(Customer::class, function (Form $form) {
            $c_id=request()->route()->parameter('customer');
            $form->display('id', 'ID');
            $form->text('name','姓名')->rules('required');
            // $form->text('hospital_code','社保卡号')->rules(function($form) use($c_id){
            //     if (!$c_id) {
            //         return 'unique:customers';
            //     }else{
            //         return '';
            //     }
            // });
            $form->radio('sex', '性别')->options(['0' => '女', '1'=> '男'])->default(1);

            $form->address('province','地址');

            if(Admin::user()->isAdministrator()||Admin::user()->isRole('kfcenter')){
                $form->select('area_id', '院区')->options(Area::pluck('area','id'));
            }else{
                $form->display('area_id','院区')->with(function($val){
                    return Admin::user()->roles->pluck('name')[0];
                });
            }
            $form->date('cs_date','出生日期')->rules('required');
			$form->text('sf_code','身份证')->rules(function(Form $form){
				if(!$id=$form->model()->id){
					return 'required|unique:customers';
				}else{
					return 'required|unique:customers,sf_code,'.$id.',id';
				}
			});

            $form->display('created_at', '添加时间');
            $form->display('updated_at', '更新时间');

            $form->saving(function (Form $form) {

                if (!Admin::user()->isAdministrator() && !Admin::user()->isRole('kfcenter')) {
                    $area=\App\Models\Area::where('area',Admin::user()->roles->pluck('name')[0])->first();
                    $form->area_id=$area->id;
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
