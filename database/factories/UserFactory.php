<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Users\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    $mattermostUserId = '';

    while (strlen($mattermostUserId) < 16) {
        $mattermostUserId .= $faker->randomAscii;
    }

    return [
        'name' => $faker->name,
        'mattermost_user_id' => $mattermostUserId,
        'email' => $faker->unique()->safeEmail,
        'remember_token' => Str::random(10),
    ];
});
