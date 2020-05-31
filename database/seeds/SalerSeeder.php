<?php

use Illuminate\Database\Seeder;
use App\Saler;
use App\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
class SalerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 0;$i <= 3; $i++){
            $saler = new Saler;
            $userData = [
                'name' => "saler".$i,
                'email' => "saler".$i."@mail.com",
                'ssn' => "s".str_repeat((string)$i, 3)."-".str_repeat((string)$i, 5)."-".str_repeat((string)$i, 4),
                'password' => Hash::make('password')
            ];
            $user = $saler->user()->create($userData);
            $user->assignRole('saler');
            $user->save();
            $saler->name = "saler".$i;
            $saler->user_id = $user->id;
            $saler->phone = "saler phone".$i;
            $saler->save();    
        }
    }
}
