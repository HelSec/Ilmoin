<?php

namespace App\Activity;

use Illuminate\Support\Facades\Auth;

trait HasActivityLogEntries
{
    public function getActorId()
    {
        return Auth::check() ? Auth::user()->id : null;
    }

    public function activityLogEntries()
    {
        return $this->morphMany(ActivityLogEntry::class, 'model');
    }
}
