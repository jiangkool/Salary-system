<?php
namespace App\Admin\Extensions;

use Encore\Admin\Facades\Admin;
use Encore\Admin\Form\Field;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Str;

class AddressColumn extends Field
{
    /**
     * @var array
     */
    protected static $js = [
    	'/resources/assets/js/distpicker.data.js',
        '/resources/assets/js/distpicker.js',
    ];

    public function render()
    {	
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
		<script>
			$("#distpicker").distpicker({
				 province: "{{ old('province', $province) }}",
		  		 city: "{{ old('city', $city) }}",
		  		 district: "{{ old('district', $district)}}"
			});

		</script>
EOT;

    	return parent::render();
    }
}
