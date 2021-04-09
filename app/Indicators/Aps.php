<?php

namespace App\Indicators;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aps extends Model
{
    use HasFactory;
    protected $table = 'ind_aps';
    protected $fillable = ['name', 'year', 'slug', 'number'];

    public function indicators()
    {
        return $this->morphMany('App\Indicators\Indicator', 'indicatorable');
    }
}
