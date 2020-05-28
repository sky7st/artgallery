<?php

use Illuminate\Database\Seeder;
use App\Customer;
use App\User;
class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 0;$i <= 3; $i++){
            $customer = new Customer();
            $customer->customer_ssn = str_repeat((string)$i, 3)."-".str_repeat((string)$i, 5)."-".str_repeat((string)$i, 4);
            $customer->name = "customer".$i;
            $customer->phone = "customer phone".$i;
            $customer->address = "address".$i;
            $customer->customer_email = "cust".$i."@mail.com";
            $customer->save();
            
            $user = new User;
            $user->name = "customer".$i;
            $user->email = "cust".$i."@mail.com";
            $user->password = Hash::make('password');
            $user->assignRole('customer');
            $user->save();
            
        }
    }
}
