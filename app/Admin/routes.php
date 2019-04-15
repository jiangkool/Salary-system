<?php

use Illuminate\Routing\Router;

Admin::registerAuthRoutes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index');

    $router->resource('customer','CustomerController');
    $router->resource('work','WorkController');
    $router->resource('area','AreaController');
    $router->resource('product','ProductController');
    $router->resource('product_type','ProductTypeController');

    $router->get('balance','BalanceController@index');

    $router->resource('income','IncomeController');
    $router->resource('order','OrderController');
    $router->get('order/{id}/del','OrderController@del');
    $router->get('bill','OrderController@bill')->name('bill.index');

    $router->resource('company','CompanyController');
    $router->resource('cashout','CashoutController');

    $router->get('cashout/{id}/del','CashoutController@del');
    $router->get('cashout/print/{cashout}','CashoutController@print');

    $router->resource('wage','WageController');
    $router->get('income/{id}/del','IncomeController@del');
	$router->resource('jslog','JslogController');

    //出单
    $router->get('order/billing/{order}','OrderController@billing');
    //打印
    $router->get('order/print/{order}','OrderController@print');

    //列出工厂工作列表
    $router->get('company/{company}','CompanyController@show');
    $router->get('company/{id}/del','CompanyController@del');

});
