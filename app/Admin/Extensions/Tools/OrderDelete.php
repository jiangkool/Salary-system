<?php

namespace App\Admin\Extensions\Tools;

use Encore\Admin\Admin;
use Encore\Admin\Grid\Tools\AbstractTool;
use Illuminate\Support\Facades\Request;

class OrderDelete extends AbstractTool
{
    protected $id,$url,$text;

    public function __construct($id,$url,$text)
    {
        $this->id=$id;
        $this->url=$url;
        $this->text=$text;
    }

    protected function script()
    {

        return <<<EOT
            $('.applyaction').click(function () {
            var id = $(this).data('id');
            var url = $(this).data('url');

            $.pjax({container:'#pjax-container', url: url+id+'/del' });

            });

EOT;
    }

    public function render()
    {
        Admin::script($this->script());

        return '<button type="button" class="btn btn-default btn-xs applyaction" data-id="'. $this->id .'" data-url="'.$this->url.'" ><i class="fa fa-trash"></i>&nbsp;'.$this->text.'</button>&nbsp;&nbsp;';

    }

     public function __toString()
    {
        return $this->render();
    }
}