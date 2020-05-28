<?php

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
        // $this->call(UsersTableSeeder::class);
        $this->call(RolePermissionSeeder::class);

        $this->call(ArtistSeeder::class);
        $this->call(SalerSeeder::class);
        $this->call(AdminSeeder::class);
        $this->call(WorkSeeder::class);
    }
}
