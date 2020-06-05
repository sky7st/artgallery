<?php

namespace App\Http\Controllers;

use App\Customer;
use Illuminate\Http\Request;
use App\Saler;
use App\EnquiryPair;
use App\Work;
class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function salerIndex()
    {
        $salers = Saler::select('name','id')->get();
        // $trades = $salers->trade->get();
        return view('pages.report.saler_index',[
            'salers' => $salers
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
    public function salerShow(Request $request)
    {
        $saler_id = $request->input('saler');
        $start = date('Y-m-d 00:00:00', strtotime($request->input('start')));
        $end = date('Y-m-d 23:59:59', strtotime($request->input('end')));
        if((int)$saler_id === -1){
            $salers = Saler::all();
            $salers->map(function ($saler)use($start, $end){
                $saler->setReportDate($start, $end);
                $saler->soldTradeBetween;
                $saler["betweenSum"] = (int)$saler->betweenSum;
            });      
        }else{
            $salers = Saler::where('id', $saler_id)->first();
            $salers->setReportDate($start, $end);
            $salers->soldTradeBetween;
            $salers["betweenSum"] = (int)$salers->betweenSum;
            $salers = [$salers];
        }
        return response()->json([
            'msg' => 'success',
            'data' => [
                'salers' => $salers
            ]
        ]);
    }

    public function salerSelf(){
        return view('pages.report.saler_self');
    }
    public function salerSelfNoDate(Request $request){
        $saler_id = $request->user()->saler()->first()->id;
        $salers = Saler::where('id', $saler_id)->first();
        $salers->allSoldTrade;
        $salers["totalSum"] = (int)$salers->totalSum;
        $salers = [$salers];
        return response()->json([
            'msg' => 'success',
            'data' => [
                'salers' => $salers
            ]
        ]);
    }

    public function salerSelfDate(Request $request){
        $saler_id = $request->user()->saler()->first()->id;
        $salers = Saler::where('id', $saler_id)->first();
        $start = date('Y-m-d 00:00:00', strtotime($request->input('start')));
        $end = date('Y-m-d 23:59:59', strtotime($request->input('end')));
        $salers->setReportDate($start, $end);
        $salers->soldTradeBetween;
        $salers["betweenSum"] = (int)$salers->betweenSum;
        $salers = [$salers];
        return response()->json([
            'msg' => 'success',
            'data' => [
                'salers' => $salers
            ]
        ]);
    }
    public function salerShowNoDate($id)
    {

        if((int)$id === -1){
            $salers = Saler::all();
            $salers->map(function ($saler){
                $saler->allSoldTrade;
                $saler["totalSum"] = (int)$saler->totalSum;
            });      
        }else{
            $salers = Saler::where('id', $id)->first();
            $salers->allSoldTrade;
            $salers["totalSum"] = (int)$salers->totalSum;
            $salers = [$salers];
        }
        return response()->json([
            'msg' => 'success',
            'data' => [
                'salers' => $salers
            ]
        ]);
    }
    public function customerIndex(){
        $customers = Customer::orderBy('name')->paginate(10);
        // $customers->load('boughtReport');
        $customers->map(function ($customer){
            $customer->boughtReport;
            $customer["thisYearSum"] = (int)$customer->thisYearSum;
            $customer["lastYearSum"] = (int)$customer->lastYearSum;
        }); 
        error_log($customers);
        return view('pages.report.customer_index',[
            'customers' => $customers
        ]);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
