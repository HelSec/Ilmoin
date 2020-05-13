<?php

namespace App\Users;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Activity\SavesActivityAsLogEntries;

class GlobalBlock extends Model
{
    use SavesActivityAsLogEntries;

    public function getFieldNameTranslationPrefix()
    {
        return '';
    }

    protected $casts = [
        'is_unblocked' => 'boolean',
    ];

    public $timestamps = [
        'expires_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function scopeActive(Builder $query)
    {
        return $query->where('is_unblocked', false)
            ->where('expires_at', '>=', now());
    }
}
