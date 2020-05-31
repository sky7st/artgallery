<?php

namespace App\Http\Controllers;

use App\Trade;
use App\Work;
use App\User;
use App\EnquiryPair;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class TradeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'price' => [
                'numeric',
                'required'
            ],
            'pair_id' => [
                'required',
                'numeric',
                'exists:enquiry_pair,id'
            ]
        ]);
        if($validator->fails()){
            abort(403);
        }

        $pair = EnquiryPair::where('id', $request->input('pair_id'));
        if(!$pair->exists()){
            abort(404);
        }
        $pair = $pair->first();
        error_log($pair);
        if(!is_null($pair->saler_id) && $request->user()->id !== $pair->saler_id ){
            abort(403);
        }
        $dataTrade = [
            'price' => $request->input('price'),
            'enquiry_pair_id' => $pair->id 
        ];
        $dataEnquiry = [
            'pair_id' => $pair->id,
            'work_id' => $pair->work_id,
            'user_id' => $request->user()->id,
            'user_type' => "saler",
            'content' => "Hi, I'd sent you a trade.\nThe price is $".$request->input('price').".\nPlease confirm."
        ];
        if(is_null($pair->saler_id)){
            $pair->saler_id = $request->user()->id;
        }
        $trade = $pair->trade()->create($dataTrade);
        $pair->trade_id = $trade->id;
        $pair->enquirys()->create($dataEnquiry);
        $pair->saler_last_time = now();
        $pair->save();
        return response()->json([
            'msg' => 'success',
            'data' => ''
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $role = $request->user()->roles->first()->name;
        $validator = Validator::make($request->all(), [
            'pair' => [
                'numeric',
                'required',
                'exists:enquiry_pair,id'
            ],
            'confirm' => [
                'required',
                'numeric',
                'in:1,2'
            ]
        ]);
        if($validator->fails()){
            abort(403);
        }
        $pair = EnquiryPair::where('id', $request->input('pair'))->first();
        if($role === "customer"){
            if($request->user()->id !== $pair->customer_id){
                abort(404);
            }else{
                $confirm = $request->input('confirm') === "1" ? true : false;

                $pair->trade->cust_confirmed = $confirm;
                $pair->trade->cust_confirmed_at = now();
                $pair->trade->save();
                if(!$confirm){
                    $pair->trade_id = null;
                    $pair->save();
                }
                $dataEnquiry = [
                    'pair_id' => $pair->id,
                    'work_id' => $pair->work_id,
                    'user_id' => $request->user()->id,
                    'user_type' => "customer",
                    'content' => $confirm ? "Hi, I'd confirmed the trade!" : "Hi, I'd rejected the trade!"
                ];
                $pair->enquirys()->create($dataEnquiry);
                $pair->cust_last_time = now();
                $pair->save();
                // error_log($pair->trade);
            }
        }else if($role === "artist"){
            if($request->user()->id !== $pair->work->artist->user_id){
                abort(404);
            }else{
                $confirm = $request->input('confirm') === "1" ? true : false;

                $pair->trade->artist_confirmed = $confirm;
                $pair->trade->artist_confirmed_at = now();
                $pair->trade->save();
                if(!$confirm){
                    $pair->trade_id = null;
                    $pair->save();
                }else{
                    $dataEnquiry = [
                        'pair_id' => $pair->id,
                        'work_id' => $pair->work_id,
                        'user_id' => $pair->saler_id,
                        'user_type' => "saler",
                        'content' => $confirm ? "Hi, the artist confirmed the trade!The trade is success!!" : "Hi, the artist rejected the trade!"
                    ];
                    $pair->enquirys()->create($dataEnquiry);
                    $pair->saler_last_time = now();
                    $pair->save();

                    $pair->work->trade_id = $pair->trade->id;
                    $pair->work->state = 2;
                    $pair->work->save();

                    $price = $pair->trade->price;
                    $pair->saler->total_sale = $pair->saler->total_sale + $price;
                    $pair->saler->save();

                    $pair->customer->amt_bought_year_to_date = $pair->customer->amt_bought_year_to_date + $price;
                    $pair->customer->save();

                    $pair->work->artist->sales_year_to_date = $pair->work->artist->sales_year_to_date + $price;
                    $pair->work->artist->save();
                }
            }
            // error_log($pair->work->artist->user_id);
        }else{
            abort(403);
        }
        return response()->json([
            'msg' => 'success',
            'data' => ''
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
