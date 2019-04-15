<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jslog extends Model
{
    protected $fillable = [
			'company_id',
			'money',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

}
