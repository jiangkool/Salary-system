<?php 
namespace App\Admin\Extensions;

use Encore\Admin\Grid\Displayers\AbstractDisplayer;
use Encore\Admin\Admin;

class AddressDisplayer extends AbstractDisplayer
{
	public function display($province,$city,$district)
	{
		$key = $this->row->{$this->grid->getKeyName()};
		$str=<<<EOT
		<div id="distpicker"  class="form-group row" data-key="$key">
		    <label class="col-form-label col-sm-2 text-md-right">省市区</label>
		    <div class="col-sm-3">
		    	<select name="province" class="form-control"></select>
		    </div>
		    <div class="col-sm-3">
		    	<select name="city" class="form-control"></select>
		    </div>
		    <div class="col-sm-3">
		    	<select name="district" class="form-control"></select>
		    </div>
	</div>
EOT;

	$script=<<<EOT
		<script>
			$("#distpicker").distpicker({
				 province: "{{ old('province', $province) }}",
		  		 city: "{{ old('city', $city) }}",
		  		 district: "{{ old('district', $district)}}"
			});

		</script>
EOT;
		Admin::script($script);

		return $str;
	}

}

