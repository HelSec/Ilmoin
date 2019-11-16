<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Organizations\Organization;
use Faker\Generator as Faker;

$factory->define(Organization::class, function (Faker $faker) {
    return [
        'name' => ucfirst($faker->words(3, true)),
        'bio' => $faker->sentences(3, true),
        'description' => $faker->sentences(5, true) . "\n\n" . $faker->sentences(5, true) . "\n\n" . $faker->sentences(5, true),
    ];
});
