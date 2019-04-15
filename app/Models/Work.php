<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Work extends Model
{
	use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $fillable = [
			'name',
			'work_unit',
			'company_id',
			'price',
    ];

    public function incomes()
    {
    	return $this->belongsToMany(Income::class);
    }

    public function company()
    {
        return $this->belongsToMany(Company::class);
    }

}
