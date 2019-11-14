<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Organizations\Organization;
use Faker\Generator as Faker;

$factory->define(Organization::class, function (Faker $faker) {
    return [
        'name' => ucfirst($faker->words(2, true)),
        'bio' => $faker->sentence,
    ];
});
