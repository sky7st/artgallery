<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = 'customer';
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'name',
        'address',
        'phone',
        'amt_bought_last_year',
        'amt_bought_year_to_date'
    ];

    protected $attributes = [
        'amt_bought_last_year' => 0,
        'amt_bought_year_to_date' => 0
    ];
    public function user()
    {
        return $this->hasOne('App\User','id', 'user_id');
    }
}
