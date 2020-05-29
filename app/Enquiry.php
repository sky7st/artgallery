<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Enquiry extends Model
{
    protected $table = 'enquiry';
    protected $timestamp = true;
    protected $fillable = [
        'work_id',
        'user_type',
        'user_id',
        'subject',
        'content'
    ];

    public function user()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }
    
    public function work()
    {
        return $this->hasOne('App\Work', 'id', 'work_id');
    }
}
