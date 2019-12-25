<?php

namespace App\Organizations\Events;

use Illuminate\Database\Eloquent\Model;

class EventRegistration extends Model
{
    protected $guarded = [];

    protected $casts = [
        'confirmed' => 'boolean',
        'count_to_slots' => 'boolean',
    ];

    public $dates = [
        'waitlist_confirmation_required_by',
    ];
}
