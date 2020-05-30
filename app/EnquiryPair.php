<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EnquiryPair extends Model
{
    protected $table = 'enquiry_pair';
    protected $timestamp = true;
    protected $fillable = [
        'work_id',
        'customer_id',
        'saler_id'
    ];
    public function work()
    {
        return $this->hasOne('App\Work','id', 'work_id');
    }
    public function customer()
    {
        return $this->hasOne('App\User', 'id', 'customer_id');
    }
    public function saler()
    {
        return $this->hasOne('App\Saler', 'id', 'saler_id');
    }
    public function enquirys()
    {
        return $this->hasMany('App\Enquiry', 'pair_id', 'id');
    }
}
