<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use App\Artist;
use App\Customer;
use App\Saler;
use App\Admin;
class User extends Authenticatable
{
    use Notifiable;
    use HasRoles;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'ssn'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function artist()
    {
        return $this->hasMany('App\Artist');
    }
    public function customer()
    {
        return $this->hasMany('App\Customer');
    }

    public function saler()
    {
        return $this->hasMany('App\Saler');
    }

    public function admin()
    {
        return $this->hasMany('App\Admin');
    }

    public function enquirys()
    {
        return $this->hasMany('App\Enquiry', 'user_id', 'id');
    }

    public static function existSSn($ssn){
        $result = Artist::where('artist_ssn', $ssn);
        if($result->exists())
            return true;
        $result = Customer::where('customer_ssn', $ssn);
        if($result->exists())
            return true;
        $result = Saler::where('saler_ssn', $ssn);
        if($result->exists())
            return true;
        $result = Admin::where('admin_ssn', $ssn);
        if($result->exists())
            return true;
        return false;
    }
}
