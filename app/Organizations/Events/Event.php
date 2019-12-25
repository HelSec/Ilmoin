<?php

namespace App\Organizations\Events;

use App\Organizations\Organization;
use App\Organizations\OrganizationGroup;
use App\Users\User;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $guarded = [];

    public function organization()
    {
        return $this->belongsTo(Organization::class, 'organization_id', 'id');
    }

    public function registrationOptions()
    {
        return $this->hasMany(EventRegistrationOption::class)
            ->orderByDesc('priority');
    }

    /**
     * @param User $user
     * @return EventRegistrationOption|null
     */
    public function getRegistrationOption(User $user): ?EventRegistrationOption
    {
        $this->loadMissing('organization.groups', 'registrationOptions');
        $now = now();
        foreach ($this->registrationOptions as $option) {
            if ($option->opens_at->isBefore($now)
                && $option->closes_at->isAfter($now)
                && $option->groupRequirements->filter(fn (OrganizationGroup $group) => !$group->hasMember($user))->isEmpty()) {
                return $option;
            }
        }

        return null;
    }
}
