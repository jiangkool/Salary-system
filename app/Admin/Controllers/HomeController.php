<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\Dashboard;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;
use Encore\Admin\Layout\Row;

class HomeController extends Controller
{
    public function index()
    {

        $role=Admin::user()->roles->pluck('slug')[0];   
        if ($role=='shopadmin') {
            return view('admin::dashboard.shop');
        }elseif ($role=='administrator') {
            return view('admin::dashboard.admin');
        }elseif ($role=='kfcenter') {
            return view('admin::dashboard.kfcenter');
        }else{
            return view('admin::dashboard.main');
        }

    }
}
