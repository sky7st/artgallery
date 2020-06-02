<?php

use Illuminate\Database\Seeder;
use App\Admin;
use App\User;
use App\Saler;
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
        $userData = [
            'name' => 'admin',
            'email' => "admin@mail.com",
            'ssn' => "a777-7777-777777",
            'password' => Hash::make('password')
        ];
        $user = $admin->user()->create($userData);
        $user->assignRole('saler','admin');
        $user->save();

        $admin->name = "admin";
        $admin->phone = "admin phone";
        $admin->user_id = $user->id;
        $admin->save();
        $saler = new Saler;
        $saler->name = "saler admin";
        $saler->user_id = $user->id;
        $saler->phone = "admin phone";
        $saler->save();    
    }
}
