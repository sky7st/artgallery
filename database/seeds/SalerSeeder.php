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
            $saler->saler_ssn = str_repeat((string)$i, 3)."-".str_repeat((string)$i, 5)."-".str_repeat((string)$i, 4);
            $saler->name = "saler".$i;
            $saler->phone = "saler phone".$i;
            $saler->saler_email = "saler".$i."@mail.com";
            $saler->save();
            
            $user = new User;
            $user->name = "saler".$i;
            $user->email = "saler".$i."@mail.com";
            $user->password = Hash::make('password');
            $user->assignRole('saler');
            $user->save();
            
        }
    }
}
