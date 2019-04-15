<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Balance extends Model
{
    protected $fillable = [
		'customer_id',
		'balance',
    ];

    public function customer()
    {
    	return $this->belongsTo(Customer::class,'customer_id','id');	
    }

    public function orders()
    {
    	return $this->hasMany(Order::class,'customer_id','customer_id');
    }
}
