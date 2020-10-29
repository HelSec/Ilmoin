<?php

namespace App\Policies\Users;

use App\Users\GlobalBlock;
use App\Users\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class GlobalBlockPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param User $user
     * @param GlobalBlock $globalBlock
     * @return mixed
     */
    public function viewPrivateReason(User $user, GlobalBlock $globalBlock)
    {
        return false; // global admins only, handled by gate
    }
}
