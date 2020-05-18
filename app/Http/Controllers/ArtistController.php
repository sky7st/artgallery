<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
class ArtistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
    }

    public function insert(Request $request){
        $ssn = $request->input('ssn'); 
        $name = $request->input('name'); 
        $phone = $request->input('phone'); 
        $add = $request->input('add'); 
        $umedium = $request->input('umedium'); 
        $ustyle = $request->input('ustyle'); 
        $utype = $request->input('utype'); 
        $sly = $request->input('sly'); 
        $sytd = $request->input('sytd'); 

        //check code
        
        DB::table('artist')->insert([
            [
                'artist_ssn' => $ssn,
                'name' => $name,
                'address' => $add,
                'phone' => $phone,
                'usual_type' => $utype,
                'usual_medium' => $umedium,
                'usual_style' => $ustyle,
                'sales_last_year' => $sly,
                'sales_year_to_date' => $sytd
            ]
        ]);        
        return redirect('/');
    }

    public function insertIndex(){
        return view('artist.insert');
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
