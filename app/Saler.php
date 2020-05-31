<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Saler extends Model
{
    protected $table = 'saler';
    public $timestamps = false;

    protected $fillable = [
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

    // public function enquiryPair()
    // {
    //     return $this->belongsTo('App\EnquiryPair', 'id');
    // }
}
