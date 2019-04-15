<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Income extends Model
{
    protected $fillable = [
		'name',
		'total',
		'workdate',
		'customer_id',
		'area_id',
    ];

    public function customer()
    {
    	return $this->belongsTo(Customer::class);	
    }
    public function area()
    {
    	return $this->hasOne(Area::class,'id','area_id');
    }

    public function works()
    {
        return $this->hasMany(IncomeWork::class,'income_id');
    }

    public function balance()
    {
        return $this->hasOne(Balance::class,'customer_id','customer_id');
    }


}
