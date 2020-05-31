<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Trade extends Model
{
    protected $table = 'trade';

    protected $fillable = [
        'price',
        'enquiry_pair_id',
        'cust_confirmed',
        'cust_confirmed_at',
        'artist_confirmed',
        'artist_confirmed_at'
    ];


    public function enquiry_pair()
    {
        return $this->hasOne('App\EnquiryPair', 'id', 'enquiry_pair_id');
    }
}
