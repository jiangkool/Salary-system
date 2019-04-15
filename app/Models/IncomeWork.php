<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IncomeWork extends Model
{
    protected $fillable = [
        'income_id',
        'work_id',
        'num',
    ];

   public function income()
    {
      return $this->belongsTo(Income::class, 'income_id');
    }


}
