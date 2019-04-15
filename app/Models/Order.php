<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class Order extends Model
{
    protected $fillable = [
		'order_code',
		'customer_id',
		'name',
		'total',
		'area_id',
		'status',
    ];

    public function customer()
    {
    	return $this->belongsTo(Customer::class,'customer_id','id');	
    }

    public function balance()
    {
        return $this->belongsTo(Balance::class,'customer_id','customer_id');   
    }

    public function items()
    {
    	return $this->hasMany(OrderItem::class);
    }

    public function area()
    {
    	return $this->hasOne(Area::class,'id','area_id');
    }

    public static function getOrderCode()
    {
        do{
            $code = Uuid::uuid4()->getHex();
        }while(self::query()->where('order_code',$code)->exists());

        return $code;
    }
}
