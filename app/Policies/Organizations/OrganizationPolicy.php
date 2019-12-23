<?php

namespace App\Policies\Organizations;

use App\Organizations\Organization;
use App\Users\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrganizationPolicy
{
    use HandlesAuthorization;

    public function create(User $user)
    {
        return false; // global admins only, handled by gate
    }

    public function manage(User $user, Organization $organization)
    {
        $adminGroup = $organization->adminGroup;
        return $adminGroup ? $adminGroup->members()->where('users.id', $user->id)->exists() : false;
    }
}
