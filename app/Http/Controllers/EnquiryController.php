<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Enquiry;
use App\User;
use App\Work;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
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
        error_log($user->id);
        
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
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'work' => [
                'required',
                'numeric',
                'exists:work,id'
            ],
            'subject' => 'required|string|max:255',
            'query' => 'required|string'
        ]);
        if(!$request->user()->can('send enquiry')){
            abort(403);
        }
        $role = $request->user()->roles->first()->name;
        $enquiry = new Enquiry;
        $enquiry->work_id = $request->input('work');
        $enquiry->user_id = $request->user()->id;
        $enquiry->user_type = $role;
        $enquiry->subject = $request->input('subject');
        $enquiry->content = $request->input('query');
        
        $enquiry->save();
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
        $this->authorize('isHimSelf', $user, User::class);
        $role = Auth::user()->roles->first()->name;
        
        if($role === "customer"){
            $work = Work::find($work)->first();
            $work->enquirys;
            return view("pages.enquiry.customer",[
                "work" => $work
            ]);
        }else{
            return view("pages.enquiry.saler");
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
