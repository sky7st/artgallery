<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Artist;
class ArtistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $results = DB::select('select * from artist', array(1));
        // $results = DB::table('artist')->get();
        $results = Artist::all();
        return view('pages.artist.index', [
            "artists" => $results
        ]);
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

        //check code todo

        // DB::table('artist')->insert([
        //     [
        //         'artist_ssn' => $ssn,
        //         'name' => $name,
        //         'address' => $add,
        //         'phone' => $phone,
        //         'usual_type' => $utype,
        //         'usual_medium' => $umedium,
        //         'usual_style' => $ustyle,
        //         'sales_last_year' => $sly,
        //         'sales_year_to_date' => $sytd
        //     ]
        // ]);        
        return redirect('/');
    }

    public function insertIndex(){
        return view('pages.artist.insert');
    }

    //todo
    public function update(Request $request){
        $ssn = $request->input('ssn'); 
        $name = $request->input('name'); 
        $phone = $request->input('phone'); 
        $add = $request->input('add'); 
        $umedium = $request->input('umedium'); 
        $ustyle = $request->input('ustyle'); 
        $utype = $request->input('utype'); 
        $sly = $request->input('sly'); 
        $sytd = $request->input('sytd'); 
       
        return redirect('/');
    }

    public function updateIndex(){
        return view('pages.artist.insert');
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
        $result = Artist::where('id', $id)->first();

        //todo check

        return view('pages.artist.show', [
            "artist" => $result
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(!is_numeric($id))
            return response()->json([
                'message' => 'error',
                'err' => "id is not numeric"
            ]);
        else{
            $artist = Artist::where("id", $id)->first();
            if(isset($artist))
                
                $artist->delete();
            //     if(!$res)
            //         return response()->json([
            //             'message' => 'error',
            //             'err' => "delete error"
            //         ]); 
            //     else
            //         return response()->json([
            //             'message' => 'true',
            //             'err' => ""
            //         ]);
            // }
            // return response()->json([
            //     'message' => 'error',
            //     'err' => "id does not exists"
            // ]);
                // return response()->json($artist->toJson());
                return redirect('/artist');
        }
    }
}
