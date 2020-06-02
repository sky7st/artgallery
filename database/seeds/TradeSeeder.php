<?php

use Illuminate\Database\Seeder;
use App\Trade;
use App\EnquiryPair;
use App\Enquiry;
use Carbon\Carbon;
class TradeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 1;$i <= 8; $i++){
            $price = 1000 + $i;
            $tradeData = [
                'price' => 1000 + $i,
                'cust_confirmed' => true,
                'cust_confirmed_at' => now(),
                'artist_confirmed' => true,
                'artist_confirmed_at' => Carbon::create(2020, 6, 1+$i, 12, 50 ,16)
            ];
            $trade = new Trade;
            $enquiryPairData = [
                'work_id' => $i,
                'customer_id' => 80,
                'saler_id' => 84 + $i % 4
            ];
            $enquiryPair = $trade->enquiry_pair()->create($enquiryPairData);
            $tradeData['enquiry_pair_id'] = $enquiryPair->id;
            $tradeObj = $trade->create($tradeData);
            $enquiryPair->trade_id = $tradeObj->id;
            $enquiryPair->save();
            $enquiryPair->work->trade_id = $tradeObj->id;
            $enquiryPair->work->state = 2;
            $enquiryPair->work->save();
        }
    }
}
