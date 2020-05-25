<?php

namespace App\Policies;

use App\User;
use Auth;
use Illuminate\Auth\Access\HandlesAuthorization;
use Response;
class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function isHimSelf(User $user1, User $user2){

        return $user1->id === $user2->id;
                    // ? true
                    // : abort(403);
    }
}
