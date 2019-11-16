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

    protected static $imageFields = [
        'avatar' => [
            'width' => '64',
            'height' => '64',
            'path' => 'avatars/organizations',
            'placeholder' => '/storage/placeholders/64.png',
        ]
    ];
}
