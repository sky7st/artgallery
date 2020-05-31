<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    protected $table = 'admin';
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'name',
        'phone'
    ];

    protected $attributes = [
        'total_sale' => 0
    ];
    public function user()
    {
        return $this->hasOne('App\User','id', 'user_id');
    }
}
