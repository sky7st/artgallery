<?php

use Illuminate\Database\Seeder;
use App\Customer;
use App\User;
use App\Enquiry;
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
            $userData = [
                'name' => "customer".$i,
                'email' => "cust".$i."@mail.com",
                'ssn' => str_repeat((string)$i, 3)."-".str_repeat((string)$i, 5)."-".str_repeat((string)$i, 4),
                'password' => Hash::make('password')
            ];
            $user = $customer->user()->create($userData);
            $user->assignRole('customer');
            $user->save();
            $customer->name = "customer".$i;
            $customer->user_id = $user->id;
            $customer->phone = "customer phone".$i;
            $customer->address = "address".$i;
            $customer->save();

            // for($j = 1;$j <= 3; $j++){
            //     for($k = 1;$k <= 3; $k++){
            //         $enquiry = new Enquiry;
            //         $enquiry->work_id = $k;
            //         $enquiry->user_id = $user->id;
            //         $enquiry->user_type = "customer";
            //         $enquiry->subject = "work".$k." customer".$i." time:".$j;
            //         $enquiry->content = "work".$k." customer".$i." content: ".$j;
            //         $enquiry->save();
            //     }
            // }
        }
    }
}
