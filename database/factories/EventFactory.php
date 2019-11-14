<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Organizations\Events\Event;
use App\Organizations\Organization;
use Faker\Generator as Faker;

$factory->define(Event::class, function (Faker $faker) {
    return [
        'organization_id' => $faker->numberBetween(1, Organization::count()),
        'name' => ucfirst($faker->words(2, true)),
        'description' => $faker->sentences(5, true),
    ];
});
