<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = 'customer';
    public $timestamps = false;
    private $thisYear;
    public $thisYearSum, $lastYearSum;
    protected $fillable = [
        'user_id',
        'name',
        'address',
        'phone',
        'amt_bought_last_year',
        'amt_bought_year_to_date'
    ];

    protected $attributes = [
        'amt_bought_last_year' => 0,
        'amt_bought_year_to_date' => 0
    ];
    public function user()
    {
        return $this->hasOne('App\User','id', 'user_id');
    }

    public function allBoughtTrade(){
        $relation = $this->hasManyThrough('App\Trade', 'App\EnquiryPair', 'customer_id', 'enquiry_pair_id','user_id')
        ->where('artist_confirmed', 1)->with(['enquiry_pair.work.artist', 'enquiry_pair.saler']);
        // $this->totalSum = $relation->sum('price');
        return $relation;
    }
    public function boughtReport(){
        $this->thisYear = date("Y");
        $lastYear = $this->thisYear - 1;
        $relation = $this->allBoughtTrade();
        $this->thisYearSum = $relation->whereBetween('artist_confirmed_at', [
            $this->thisYear."-1-1 00:00:00", $this->thisYear."-12-31 23:59:59"
            ])->sum('price');
        $this->lastYearSum = $relation->whereBetween('artist_confirmed_at', [
            $lastYear."-1-1 00:00:00", $lastYear."-12-31 23:59:59"
            ])->sum('price');
        return $relation;
    }
}
