<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    protected $table = 'admin';
    public $timestamps = false;

    protected $fillable = [
        'admin_ssn',
        'admin_email',
        'name',
        'phone'
    ];

    protected $attributes = [
        'total_sale' => 0
    ];
    public function user()
    {
        return $this->hasOne('App\User','email', 'admin_email');
    }
}
