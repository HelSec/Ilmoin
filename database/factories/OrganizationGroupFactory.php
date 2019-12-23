<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Organizations\Organization;
use App\Organizations\OrganizationGroup;
use Faker\Generator as Faker;

$factory->define(OrganizationGroup::class, function (Faker $faker) {
    return [
        'organization_id' => $faker->numberBetween(1, Organization::count()),
        'name' => ucfirst($faker->words(2, true)),
        'is_public' => $faker->boolean,
        'is_member_list_public' => $faker->boolean,
        'is_member_list_shown_to_other_members' => $faker->boolean,
    ];
});
