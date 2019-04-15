<?php

use Illuminate\Http\Request;

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', [
		'namespace' => 'App\Api\Controllers'
	],function ($api) {

		$api->get('customer','CustomerController@username');
		$api->get('getWorkPrice','CustomerController@getWorkPrice');
		$api->post('wage','CustomerController@wage');
});