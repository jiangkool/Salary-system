<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Area extends Model
{
	use SoftDeletes;
    protected $dates = ['deleted_at'];
	
	
    protected $fillable = [
        'area',
    ];

    public function customers()
    {
    	return $this->hasMany(Customer::class,'area_id','id');
    }
}
