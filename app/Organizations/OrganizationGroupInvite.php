<?php

namespace App\Organizations;

use App\Users\User;
use Illuminate\Database\Eloquent\Model;

class OrganizationGroupInvite extends Model
{
    protected $guarded = [];
    protected $casts = [
        'approved_by_group' => 'boolean',
        'approved_by_user' => 'boolean',
    ];

    public function group()
    {
        return $this->belongsTo(OrganizationGroup::class, 'organization_group_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    protected static function booted()
    {
        static::updated(function (OrganizationGroupInvite $invite) {
            $invite->checkIfApproved();
        });
    }

    public function checkIfApproved()
    {
        if (!$this->approved_by_group || !$this->approved_by_user) {
            return;
        }

        if (!$this->exists) {
            return;
        }

        $group = $this->group;
        $oldMembers = $group->members()
            ->pluck('user_id')
            ->toArray();

        OrganizationGroupMember::create([
            'organization_group_id' => $group->id,
            'user_id' => $this->user_id,
        ]);

        $newMembers = array_merge($oldMembers, ([$this->user_id]));
        $group->addPendingChange('members', $oldMembers, $newMembers);
        $group->savePendingChanges();

        $this->delete();
    }
}
