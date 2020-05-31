<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Work extends Model
{
    protected $table = 'work';
    public $timestamps = true;

    protected $fillable = [
        'title',
        'artist_id',
        'type',
        'medium',
        'style',
        'size',
        'discript',
        'image_thumb',
        'image_path',
        'asking_price',
        'enquiry_pair_id',
        'date_of_show',
        'date_sold',
        'state'
    ];

    protected $attributes = [
        'asking_price' => 0,
        'state' => 1
    ];
    public function artist()
    {
        return $this->hasOne('App\Artist','id', 'artist_id');
    }

    public function enquirys()
    {
        return $this->hasMany('App\Enquiry', 'work_id', 'id');
    }
    public function enquiryPair()
    {
        return $this->hasMany('App\EnquiryPair', 'work_id', 'id');
    }

    public function soldTrade()
    {
        return $this->hasOne('App\Trade', 'id', 'trade_id');
    }
    public function trades()
    {
        return $this->hasMany('App\Trade', 'work_id', 'id');
    }
}
