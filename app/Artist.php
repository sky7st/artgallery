<?php

namespace App;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Artist extends Model
{
    protected $table = 'artist';
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'name',
        'address',
        'phone',
        'usual_type',
        'usual_medium',
        'usual_style'
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
}
