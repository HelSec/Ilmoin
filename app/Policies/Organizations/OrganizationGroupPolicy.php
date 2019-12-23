<?php

namespace App\Policies\Organizations;

use App\Organizations\OrganizationGroup;
use App\Users\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrganizationGroupPolicy
{
    use HandlesAuthorization;

    public function create(User $user)
    {
        //
    }

    public function view(?User $user, OrganizationGroup $group)
    {
        return $group->is_public || ($user ? ($group->members()->where('users.id', $user->id)->exists() || $user->can('manage', $group->organization)) : false);
    }

    public function viewMembers(?User $user, OrganizationGroup $group)
    {
        return $group->is_member_list_public || ($user ? ($group->is_member_list_shown_to_other_members && $group->members()->where('users.id', $user->id)->exists()) || $user->can('manage', $group->organization) : false);
    }
}
