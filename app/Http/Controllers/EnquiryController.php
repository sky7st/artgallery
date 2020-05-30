<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Enquiry;
use App\User;
use App\Work;
use App\EnquiryPair;
use Auth;
use DB;
class EnquiryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $role = $user->roles->first()->name;
        if($role === "customer"){
            $enquiry_ids = Enquiry::select(DB::raw('max(id) as id'))
                ->where('user_id', $user->id)
                ->groupBy('work_id')->get();
            $enquirys = Enquiry::whereIn('id', $enquiry_ids)->orderBy('created_at', 'DESC')->get();
            foreach($enquirys as $enquiry){
                $enquiry->work->artist;
            }
            return view("pages.enquiry.index",[
                'enquirys' => $enquirys
            ]);
        }else{
            $unsold_works = Work::where('state', 1)->with([
                'enquiryPair' => function($query)use($user){
                    $query->whereNull('saler_id')->orWhere('saler_id', $user->id)->get();
                }]);
            error_log($unsold_works->get());
            // $unsold_works = Work::where('state', 1);
            return view("pages.enquiry.index",[
                'unsold_works' => $unsold_works->paginate(10)
            ]);
        }
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, $work, $user)
    {
        $role = $request->user()->roles->first()->name;
        $validatorArr = [
            'query' => 'required|string'
        ];
        $validator = Validator::make($request->all(), $validatorArr);
        if(!$request->user()->can('send enquiry')){
            abort(403);
        }
        if($validator->fails()){
            abort(403);
        }
        if(!User::exists($user) || !Work::exists($work)){
            abort(404);
        }
        if($role === "customer"){
            $pair = EnquiryPair::where([
                'work_id' => $work,
                'customer_id' => $user
            ]);
            if(!$pair->exists()){
                $pair = new EnquiryPair;
                $pair->work_id = $work;
                $pair->customer_id = $user;
                $pair->save();
                error_log("not exists");
            }else{
                $pair = $pair->first();
            }
        }else{
            $pair = EnquiryPair::where([
                'work_id' => $work,
                'customer_id' => $user
            ])->first;
            if(is_null($pair->saler_id)){
                $pair->saler_id = $request->user()->id;
                $pair->save();
            }
        }
        // error_log($pair);
        $pair->enquirys()->create([
            'pair_id' => $pair->id,
            'work_id' => $work,
            'user_id' => $request->user()->id,
            'user_type' => $role,
            'content' => $request->input('query')
        ]);   
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
    public function show($work, $id)
    {
        $user = User::find($id);
        $role = Auth::user()->roles->first()->name;
        $enquiryPair = EnquiryPair::where([
            'work_id' => $work,
            'customer_id' => $id
        ]);
        if(!$enquiryPair->exists()){
            return abort(404);
        }else{
            $enquiryPair = $enquiryPair->first();
        }
        if($role === "customer"){
            $this->authorize('isHimSelf', $user, User::class);
            
            $enquirys = $enquiryPair->enquirys;
            // $work = Work::where('id', $work)->first();
            // $enquirys = $work->enquirys->where("user_id", '=', $user->id);
            return view("pages.enquiry.customer",[
                "work" => $enquiryPair->work->first(),
                "user_id" => $id,
                "enquirys" => $enquirys
            ]);
        }else{
            // $work = Work::where('id', $work)->first();
            // $enquirys = $work->enquirys->where("user_id", '=', $user->id);
            $enquirys = $enquiryPair->enquirys;

            return view("pages.enquiry.customer",[
                "work" => $enquiryPair->work->first(),
                "user_id" => $id,
                "enquirys" => $enquirys
            ]);
            // return view("pages.enquiry.customer");
        }
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
