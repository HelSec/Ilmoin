<?php

use App\Organizations\Events\Event;
use App\Organizations\Organization;
use App\Organizations\OrganizationGroup;
use App\Organizations\OrganizationGroupMember;
use App\Users\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        factory(Organization::class, 10)->create();
        factory(OrganizationGroup::class, 50)->create();

        Organization::with('groups')
            ->get()->each(function (Organization $organization) {
                if ($organization->groups->isNotEmpty()) {
                    $firstGroup = $organization->groups->first();
                    $firstGroup->update([
                        'is_public' => true,
                        'is_member_list_public' => true,
                        'is_member_list_shown_to_other_members' => true,
                    ]);

                    $organization->admin_group_id = $firstGroup->id;
                    $organization->saveOrFail();
                }
            });

        factory(User::class, 100)->create()
            ->each(function (User $user) use ($faker) {
                OrganizationGroupMember::create([
                    'user_id' => $user->id,
                    'organization_group_id' => $faker->numberBetween(1, OrganizationGroup::count()),
                ]);
            });

        factory(Event::class, 50)->create();
    }
}
