<?php

namespace App\Activity;

use App\Users\User;
use Illuminate\Database\Eloquent\Model;

class ActivityLogEntry extends Model
{
    protected $guarded = [];

    protected $casts = [
        'data' => 'object',
    ];

    public function model()
    {
        return $this->morphTo('model');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
