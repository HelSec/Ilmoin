<?php

namespace App\Organizations;

use App\Users\User;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use App\Activity\SavesActivityAsLogEntries;

class OrganizationGroup extends Model
{
    use SavesActivityAsLogEntries;

    public $fieldToModelTypes = [
        'organization_id' => [Organization::class, 'id'],
        'members' => [User::class, 'id'],
    ];

    public function getFieldNameTranslationPrefix()
    {
        return 'groups.fields.';
    }

    protected $guarded = [];
    protected $appends = ['view_url'];

    protected $casts = [
        'is_public' => 'boolean',
        'is_member_list_public' => 'boolean',
        'is_member_list_shown_to_other_members' => 'boolean',
    ];

    use HasSlug;

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function organization()
    {
        return $this->belongsTo(Organization::class, 'organization_id', 'id');
    }

    public function members()
    {
        return $this->belongsToMany(User::class, OrganizationGroupMember::class);
    }

    public function hasMember(User $user)
    {
        return $this->members->contains('id', $user->id);
    }

    public function invites()
    {
        return $this->hasMany(OrganizationGroupInvite::class, 'organization_group_id');
    }

    public function getViewUrlAttribute()
    {
        return route('groups.show', $this);
    }
}
