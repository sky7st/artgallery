<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Role;
class Permission extends Model
{
    protected $table = 'permissions';

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }    
}
