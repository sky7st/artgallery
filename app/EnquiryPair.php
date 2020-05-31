<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EnquiryPair extends Model
{
    protected $table = 'enquiry_pair';
    protected $fillable = [
        'work_id',
        'customer_id',
        'saler_id',
        'trade_id',
        'cust_last_time',
        'saler_last_time'
    ];
    public function work()
    {
        return $this->hasOne('App\Work','id', 'work_id');
    }
    public function customer()
    {
        return $this->hasOne('App\Customer', 'user_id', 'customer_id');
    }
    public function saler()
    {
        return $this->hasOne('App\Saler', 'user_id', 'saler_id');
    }
    public function enquirys()
    {
        return $this->hasMany('App\Enquiry', 'pair_id', 'id');
    }
    public function trade()
    {
        return $this->belongsTo('App\Trade');
    }
}
