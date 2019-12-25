<?php

namespace App\Organizations\Events;

use App\Users\User;
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

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
