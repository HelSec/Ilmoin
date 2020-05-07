<?php

namespace App\Organizations\Events;

use App\Organizations\OrganizationGroup;
use Illuminate\Database\Eloquent\Model;
use App\Activity\SavesActivityAsLogEntries;

class EventRegistrationOption extends Model
{
    use SavesActivityAsLogEntries;

    public $fieldToModelTypes = [
        'event_id' => [Event::class, 'id'],
        'groups' => [OrganizationGroup::class, 'id'],
    ];

    public function getFieldNameTranslationPrefix()
    {
        return 'events.regopts.fields.';
    }

    protected $guarded = [];
    protected $with = ['groupRequirements'];

    protected $casts = [
        'count_to_slots' => 'boolean',
        'enabled' => 'boolean',
    ];

    protected $dates = [
        'opens_at',
        'closes_at',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function groupRequirements()
    {
        return $this->belongsToMany(OrganizationGroup::class, EventRegistrationOptionRequiredGroup::class)
            ->orderBy('event_registration_option_required_groups.organization_group_id');
    }
}
