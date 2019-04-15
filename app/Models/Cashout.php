<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cashout extends Model
{
     protected $fillable = [
			'customer_id',
			'name',
			'money'
    ];

    public function customer()
    {
    	return $this->belongsTo(Customer::class);
    }
}
