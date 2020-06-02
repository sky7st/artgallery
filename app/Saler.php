<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Saler extends Model
{
    protected $table = 'saler';
    public $timestamps = false;

    protected $fillable = [
        'name',
        'phone',
        'total_sale'
    ];

    protected $attributes = [
        'total_sale' => 0
    ];
    public function user()
    {
        return $this->hasOne('App\User','id', 'user_id');
    }

    public function enquiryPair()
    {
        return $this->hasMany('App\EnquiryPair', 'saler_id', 'user_id');
    }
    public function roles()
    {
        return $this->belongsToMany('App\Role', 'role_user_table', 'user_id', 'role_id');
    }
}
