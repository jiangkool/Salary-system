<?php

namespace App\Admin\Extensions\Tools;

use Encore\Admin\Admin;
use Encore\Admin\Grid\Tools\AbstractTool;
use Illuminate\Support\Facades\Request;

class DeleteButton extends AbstractTool
{
    protected $id,$url,$text,$icon,$style;

    public function __construct($id,$url,$text,$icon,$style)
    {
        $this->id=$id;
        $this->url=$url;
        $this->text=$text;
        $this->icon=$icon;
        $this->style=$style;
    }

    protected function script()
    {

        return <<<EOT
            $('.applyaction').click(function () {
            var id = $(this).data('id');
            var url = $(this).data('url');
                 swal({
                  title: "确认删除?",
                  type: "warning",
                  showCancelButton: true,
                  confirmButtonColor: "#DD6B55",
                  confirmButtonText: "确认",
                  closeOnConfirm: true,
                  cancelButtonText: "取消"
                },function(){
                 $.pjax({container:'#pjax-container', url: url+id+'/del' });
            });
                
           

            });

EOT;
    }

    public function render()
    {
        Admin::script($this->script());

        return '<button type="button" class="btn '.$this->style.' btn-xs applyaction" data-id="'. $this->id .'" data-url="'.$this->url.'" ><i class="fa '.$this->icon.'"></i>&nbsp;'.$this->text.'</button>&nbsp;&nbsp;';

    }

     public function __toString()
    {
        return $this->render();
    }
}