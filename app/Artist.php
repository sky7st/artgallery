<?php

namespace App;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Artist extends Model
{
    protected $table = 'artist';
    public $timestamps = false;
    private $thisYear;
    public $thisYearSum, $lastYearSum;
    protected $fillable = [
        'user_id',
        'name',
        'address',
        'phone',
        'usual_type',
        'usual_medium',
        'usual_style',
        'sales_last_year',
        'sales_year_to_date'
    ];

    protected $attributes = [
        'sales_last_year' => 0,
        'sales_year_to_date' => 0
    ];
    public function user()
    {
        return $this->hasOne('App\User','id', 'user_id');
    }
    public function work()
    {
        return $this->hasMany('App\Work', 'artist_id', 'id');
    }

    public function soldWork(){
        $relation = $this->hasManyThrough('App\Trade', 'App\Work', 'artist_id', 'enquiry_pair_id','user_id')
        ->where('artist_confirmed', 1);
        // $this->totalSum = $relation->sum('price');
        return $relation;
    }
    public function soldReport(){
        $this->thisYear = date("Y");
        $lastYear = $this->thisYear - 1;
        $relation = $this->soldWork();
        $this->thisYearSum = $relation->whereBetween('artist_confirmed_at', [
            $this->thisYear."-1-1 00:00:00", $this->thisYear."-12-31 23:59:59"
            ])->sum('price');
        $this->lastYearSum = $relation->whereBetween('artist_confirmed_at', [
            $lastYear."-1-1 00:00:00", $lastYear."-12-31 23:59:59"
            ])->sum('price');
        return $relation;
    }
}
