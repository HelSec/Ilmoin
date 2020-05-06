<?php

namespace App\Users;

use App\Organizations\OrganizationGroup;
use App\Organizations\OrganizationGroupMember;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'is_super_admin', 'mattermost_user_id',
    ];

    protected $hidden = [
        'remember_token',
    ];

    protected $casts = [
        'is_super_admin' => 'boolean',
    ];

    protected $appends = [
        'viewUrl',
    ];

    public function groups()
    {
        return $this->belongsToMany(OrganizationGroup::class, OrganizationGroupMember::class);
    }

    public function organizations()
    {
        return $this->groups()->get()->pluck('organization')->flatten();
    }

    public function getViewUrlAttribute()
    {
        return '/';
    }
}
