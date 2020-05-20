<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Artist;
use Validator;
class ArtistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $results = Artist::paginate(10);
        return view('pages.artist.index', [
            "artists" => $results
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
            'ssn' => 'required',
            'name' => 'required',
            'phone' => 'required',
            'add' => 'required'
        ]);
        if($validator->fails()){
            return response()->json([
                'msg' => 'err',
                'err' => $validator->errors()
            ]);
        }
        $ssn = $request->input('ssn'); 
        $name = $request->input('name'); 
        $phone = $request->input('phone'); 
        $add = $request->input('add'); 
        $umedium = $request->input('umedium'); 
        $ustyle = $request->input('ustyle'); 
        $utype = $request->input('utype'); 

        $artist = new Artist;
        $artist->artist_ssn = $ssn; 
        $artist->name = $name; 
        $artist->address = $add; 
        $artist->phone = $phone; 
        $artist->usual_type = $utype; 
        $artist->usual_medium = $umedium; 
        $artist->usual_style = $ustyle; 

        $newArtist = $artist->save();
        if(!$newArtist){
            return response()->json([
                'msg' => 'err',
                'err' => 'insert err!'
            ]);
        }else{
            return response()->json([
                'msg' => 'success',
                'data' => [
                    'lastPage' => $artist->paginate(10)->lastPage()
                ]
            ]);
        }
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
        $artist = Artist::where('id', $id);
        if($artist->exists()){
            $artist = $artist->first();
            return view('pages.artist.show', [
                "artist" => $artist
            ]);
        }else{

        }  
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'phone' => 'required',
            'add' => 'required'
        ]);
        if($validator->fails()){
            return response()->json([
                'msg' => 'err',
                'err' => $validator->errors()
            ]);
        }
        $name = $request->input('name'); 
        $phone = $request->input('phone'); 
        $add = $request->input('add'); 
        $umedium = $request->input('umedium'); 
        $ustyle = $request->input('ustyle'); 
        $utype = $request->input('utype'); 
       
        $data = [
            'name' => $name,
            'phone' => $phone,
            'address' => $add,
            'usual_type' => $utype,
            'usual_medium' => $umedium,
            'usual_style' => $ustyle
        ];

        $artist = Artist::where('id', $id);
        if($artist->exists())
            $artist = $artist->first();
        else
            return response()->json([
                'msg' => 'err',
                'err' => 'artist does not exist'
            ]); 
        $updated = $artist->update($data);
        if(!$updated){
            return response()->json([
                'msg' => 'err',
                'err' => $validator->errors()
            ]);
        }else{
            return response()->json([
                'msg' => 'success',
                'err' => ''
            ]);
        }
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
                'msg' => 'error',
                'err' => 'id is not numeric'
            ]);
        else{
            $delete = Artist::where('id', $id)->first()->delete();
            $resp = [];
            if(!$delete){
                $resp = [
                    'msg' => 'err',
                    'err' => 'delete error!!!'
                ];
            }else{
                $resp = [
                    'msg' => 'success'
                ];
            }
            $lastPage = Artist::paginate(10)->lastPage();
            $resp['data'] = [
                'lastPage' => $lastPage
            ];
            return response()->json($resp);
        }
    }
}
