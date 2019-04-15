<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id',
        'product_id',
        'product_num',
    ];

   public function order()
    {
      return $this->belongsTo(Order::class, 'order_id');
    }

   public function product()
   {
   		return $this->hasOne(Product::class,'id','product_id');
   }

}
