<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
	use SoftDeletes;
    protected $dates = ['deleted_at'];
	
    protected $fillable = [
		'name',
		'sex',
		'area_id',
		'cs_date',
		'hospital_code',
		'sf_code',
        'province',
        'city',
        'district',
		'status',
    ];

    public function area()
    {
    	return $this->belongsTo(Area::class,'area_id','id');
    }

    public function orders()
    {
    	return $this->hasMany(order::class);
    }

    public function incomes()
    {
    	return $this->hasMany(Income::class);
    }

    public function balance()
    {
    	return $this->hasOne(Balance::class);
    }

    public function getFullAddressAttribute()
    {
        return "{$this->province}{$this->city}{$this->district}";
    }


}
