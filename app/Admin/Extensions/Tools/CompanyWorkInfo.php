<?php

namespace App\Admin\Extensions\Tools;

use Encore\Admin\Admin;
use Encore\Admin\Grid\Tools\AbstractTool;
use Illuminate\Support\Facades\Request;

class CompanyWorkInfo extends AbstractTool
{
    protected $id;
    protected $url;
    protected $text;
    protected $action;

    public function __construct($id,$url,$text,$action)
    {
        $this->id=$id;
        $this->url=$url;
        $this->text=$text;
        $this->action=$action;
    }

    protected function script()
    {

        return <<<EOT
            $('.apply-show').click(function () {
            var id = $(this).data('id');
            var url = $(this).data('url');

            $.pjax({container:'#pjax-container', url: url+'/'+id });

            });
            $('.apply-billing').unbind('click').click(function() {
                var id = $(this).data('id');
                var url = $(this).data('url');
                swal({
                  title: "确认出单?",
                  type: "warning",
                  showCancelButton: true,
                  confirmButtonColor: "#DD6B55",
                  confirmButtonText: "确认",
                  closeOnConfirm: false,
                  cancelButtonText: "取消"
                },
                function(){
                    $.ajax({
                        method: 'get',
                        url: url +'/'+ id,
                        data: {
                            _method:'get',
                            _token:LA.token,
                        },
                        success: function (data) {
                            $.pjax.reload('#pjax-container');

                            if (typeof data === 'object') {
                                if (data.status) {
                                    swal(data.message, '', 'success');
                                } else {
                                    swal(data.message, '', 'error');
                                }
                            }
                        }
                    });
                });
            });


EOT;
    }

    public function render()
    {
        Admin::script($this->script());
        if ($this->action=='billing') {
            return '<button type="button" class="btn btn-danger btn-xs apply-billing" data-id="'. $this->id .'" data-url="'.$this->url.'" ><i class="fa fa-line-chart"></i>&nbsp;'.$this->text.'</button>&nbsp;&nbsp;';
        }else if($this->action=='show'){
            return '&nbsp;&nbsp;<button type="button" class="btn btn-primary btn-xs apply-show" data-id="'. $this->id .'" data-url="'.$this->url.'" ><i class="fa fa-line-chart"></i>&nbsp;'.$this->text.'</button>';
        }
        

    }

     public function __toString()
    {
        return $this->render();
    }
}