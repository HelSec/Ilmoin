<?php

use App\Organizations\Events\Event;
use App\Organizations\Organization;
use App\Organizations\OrganizationGroup;
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
        factory(Organization::class, 10)->create();
        factory(OrganizationGroup::class, 50)->create();

        Organization::with('groups')
            ->get()->each(function (Organization $organization) {
                if ($organization->groups->isNotEmpty()) {
                    $organization->admin_group_id = $organization->groups->first()->id;
                    $organization->saveOrFail();
                }
            });

        factory(Event::class, 50)->create();
        // $this->call(UsersTableSeeder::class);
    }
}
