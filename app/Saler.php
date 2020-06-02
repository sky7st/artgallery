<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Saler extends Model
{
    protected $table = 'saler';
    public $timestamps = false;

    private $reportStartDate,$reportEndDate;
    public $totalSum,$betweenSum;
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
    public function allSoldTrade(){
        $relation = $this->hasManyThrough('App\Trade', 'App\EnquiryPair', 'saler_id', 'enquiry_pair_id','user_id')
        ->where('artist_confirmed', 1)->with(['enquiry_pair.work.artist', 'enquiry_pair.customer']);
        $this->totalSum = $relation->sum('price');
        return $relation;
    }

    public function setReportDate($start, $end){
        $this->reportStartDate = $start;
        $this->reportEndDate = $end;
    }
    
    public function soldTradeBetween(){
        $relation = $this->hasManyThrough('App\Trade', 'App\EnquiryPair', 'saler_id', 'enquiry_pair_id','user_id')
        ->where('artist_confirmed', 1)->whereBetween('artist_confirmed_at', [$this->reportStartDate, $this->reportEndDate])
        ->with(['enquiry_pair.work.artist', 'enquiry_pair.customer']);
        $this->betweenSum = $relation->sum('price');
        return $relation;
    }
}
