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
        'name', 'email', 'password',
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
        return $this->hasOne('App\Artist', 'artist_email', 'email');
    }
    public function customer()
    {
        return $this->hasOne('App\Customer', 'customer_email', 'email');
    }

    public function saler()
    {
        return $this->hasOne('App\Saler', 'saler_email', 'email');
    }

    public function admin()
    {
        return $this->hasOne('App\Admin', 'admin_email', 'email');
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

    // public function role()
    // {
    //     return $this->belongsTo('Role', 'role_id', 'id');
    // }

    // public function roles()
    // {
    //     return $this->belongsToMany(Role::class);
    // }

    // /**
    // * @param string|array $roles
    // */
    // public function authorizeRoles($roles)
    // {
    //     if (is_array($roles)) {
    //         return $this->hasAnyRole($roles) || 
    //                 abort(401, 'This action is unauthorized.');
    //     }
    //     return $this->hasRole($roles) || 
    //             abort(401, 'This action is unauthorized.');
    //     }
    // /**
    // * Check multiple roles
    // * @param array $roles
    // */
    // public function hasAnyRole($roles)
    // {
    //     return null !== $this->roles()->whereIn('name', $roles)->first();
    // }
    // /**
    // * Check one role
    // * @param string $role
    // */
    // public function hasRole($role)
    // {
    //     return null !== $this->roles()->where('name', $role)->first();
    // }

    // /**
    // * Check permission
    // * @param string $per
    // */
    // public function can($perm = null)
    // {
    //     if(is_null($perm)) return false;
    //     $perms = $this->role->permissions->fetch('name');
    //     return in_array($perm, $perms->toArray());
    // }
}
