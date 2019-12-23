<?php

namespace App\Organizations\Events;

use App\Organizations\OrganizationGroup;
use Illuminate\Database\Eloquent\Model;

class EventRegistrationOption extends Model
{
    protected $guarded = [];
    protected $with = ['groupRequirements'];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function groupRequirements()
    {
        return $this->belongsToMany(OrganizationGroup::class, EventRegistrationOptionRequiredGroup::class);
    }
}
