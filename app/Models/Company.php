<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
	use SoftDeletes;
    protected $dates = ['deleted_at'];
	
    protected $fillable = [
			'company_name',
			'company_code',
			'yz_total',
			'yj_total',
			'wj_total',
			'yj_add'
    ];

    public function works()
    {
    	return $this->hasMany(Work::class,'company_id','id');
    }
}
