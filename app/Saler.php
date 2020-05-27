<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Saler extends Model
{
    protected $table = 'saler';
    public $timestamps = false;

    protected $fillable = [
        'saler_ssn',
        'saler_email',
        'name',
        'phone'
    ];

    protected $attributes = [
        'total_sale' => 0
    ];
    public function user()
    {
        return $this->hasOne('App\User','email', 'saler_email');
    }
}
