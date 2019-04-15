<?php

namespace App\Admin\Extensions\Tools;

use Encore\Admin\Admin;
use Encore\Admin\Grid\Tools\AbstractTool;
use Illuminate\Support\Facades\Request;

class BalanceButton extends AbstractTool
{
    protected $id;
    protected $url;
    protected $btext;

    public function __construct($id,$url, $btext)
    {
        $this->id=$id;
        $this->url=$url;
        $this->btext=$btext;
    }

    protected function script()
    {

        return <<<EOT
            $('.applyaction').click(function () {
            var id = $(this).data('id');
            var url = $(this).data('url');

            $.pjax({container:'#pjax-container', url: url+'/'+id });

            });

EOT;
    }

    public function render()
    {
        Admin::script($this->script());

        return '<button type="button" class="btn btn-warning btn-xs applyaction" data-id="'. $this->id .'" data-url="'.$this->url.'" ><i class="fa fa-btc"></i>&nbsp;'.$this->btext.'</button>&nbsp;&nbsp;';

    }

     public function __toString()
    {
        return $this->render();
    }
}