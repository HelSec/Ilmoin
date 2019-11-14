<?php

use App\Organizations\Organization;
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
        // $this->call(UsersTableSeeder::class);
    }
}
