<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Artist extends Model
{
    protected $table = 'artist';
    public $timestamps = false;

    protected $fillable = [
        'name',
        'address',
        'phone',
        'usual_type',
        'usual_medium',
        'usual_style'
    ];

    protected $attributes = [
        'sales_last_year' => 0,
        'sales_year_to_date' => 0
    ];
}
