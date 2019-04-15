<?php
namespace App\Admin\Extensions;

use Encore\Admin\Grid\Column;
use Encore\Admin\Grid;

class Address extends Grid
{
	public static function registerAddressColumnDisplayer(){

		Column::extend('address', AddressDisplayer::class);

	}


}