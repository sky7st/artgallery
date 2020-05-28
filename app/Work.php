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
        'date_of_show',
        'date_sold'
    ];

    protected $attributes = [
        'asking_price' => 0
    ];
    public function artist()
    {
        return $this->hasOne('App\Artist','id', 'artist_id');
    }
}
