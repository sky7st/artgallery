<?php

use Illuminate\Database\Seeder;
use App\Admin;
use App\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = new Admin;
        $admin->admin_ssn = "777-7777-777777";
        $admin->name = "admin";
        $admin->phone = "admin phone";
        $admin->admin_email = "admin@mail.com";
        $admin->save();
        
        $user = new User;
        $user->name = "admin";
        $user->email = "admin@mail.com";
        $user->password = Hash::make('password');
        $user->assignRole('admin');
        $user->save();
    }
}
