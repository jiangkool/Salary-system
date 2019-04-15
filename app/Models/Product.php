<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
		'type_id',
		'product_name',
		'price',
		'num',
    ];

    public function productType()
    {
    	return $this->hasOne(ProductType::class,'id','type_id');
    }

    
}
