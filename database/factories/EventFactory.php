<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Organizations\Events\Event;
use App\Organizations\Organization;
use Faker\Generator as Faker;

$factory->define(Event::class, function (Faker $faker) {
    return [
        'organization_id' => $faker->numberBetween(1, Organization::count()),
        'name' => ucfirst($faker->words(2, true)),
        'description' => $faker->sentences(5, true) . "\n\n" . $faker->sentences(5, true) . "\n\n" . $faker->sentences(5, true),
        'date' => $faker->dateTimeBetween('-2 weeks', '+2 months'),
        'location' => ucfirst($faker->words(2, true)),
        'max_slots' => $faker->boolean ? null : ($faker->numberBetween(5, 25) * 10),
    ];
});
