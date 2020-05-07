<?php

namespace App\Organizations;

use App\Organizations\Events\Event;
use Illuminate\Database\Eloquent\Model;
use QCod\ImageUp\HasImageUploads;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Organization extends Model
{
    protected $guarded = [];
    protected $appends = ['view_url'];

    use HasSlug;
    use HasImageUploads;

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

    public function events()
    {
        return $this->hasMany(Event::class, 'organization_id', 'id');
    }

    public function upcomingEvents()
    {
        return $this->events()
            ->where('date', '>=', now())
            ->orderBy('date');
    }

    public function pastEvents()
    {
        return $this->events()
            ->where('date', '´<', now())
            ->orderByDesc('date')
            ->limit(3);
    }

    public function groups()
    {
        return $this->hasMany(OrganizationGroup::class, 'organization_id', 'id');
    }

    public function adminGroup()
    {
        return $this->hasOne(OrganizationGroup::class, 'organization_id', 'id')
            ->where('id', $this->admin_group_id);
    }

    protected static $imageFields = [
        'avatar' => [
            'width' => '64',
            'height' => '64',
            'path' => 'avatars/organizations',
            'placeholder' => '/storage/placeholders/64.png',
        ]
    ];

    public function getViewUrlAttribute()
    {
        return route('organizations.show', $this);
    }
}
