<?php

namespace App\Organizations;

use App\Users\User;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class OrganizationGroup extends Model
{
    protected $guarded = [];

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
}
