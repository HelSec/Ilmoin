<?php

namespace App\Organizations\Events;

use App\Organizations\Organization;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $guarded = [];

    public function organization()
    {
        return $this->belongsTo(Organization::class, 'organization_id', 'id');
    }
}
