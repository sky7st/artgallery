<?php

use Illuminate\Database\Seeder;
use App\Role;
class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role_artist = new Role;
        $role_artist->name = "artist";
        $role_artist->description = "A artist user";
        $role_artist->save();

        $role_customer = new Role;
        $role_customer->name = "customer";
        $role_customer->description = "A customer user";
        $role_customer->save();

        $role_owner = new Role;
        $role_owner->name = "owner";
        $role_owner->description = "A owner user";
        $role_owner->save();

        $role_saler = new Role;
        $role_saler->name = "saler";
        $role_saler->description = "A saler user";
        $role_saler->save();

        $role_admin = new Role;
        $role_admin->name = "admin";
        $role_admin->description = "A admin user";
        $role_admin->save();
    }
}
