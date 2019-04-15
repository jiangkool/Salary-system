<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wage extends Model
{
     protected $fillable = [
			'customer_id',
			'name',
			'money',
			'bark'
    ];

    public function customer()
    {
    	return $this->belongsTo(Customer::class);
    }
}
