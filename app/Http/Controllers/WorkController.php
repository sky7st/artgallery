<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Work;
use App\Artist;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use Image;
class WorkController extends Controller
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
        $id = $request->user()->id;
        $validator = Validator::make($request->all(),[
            'title' => [
                'required',
                'string',
                'max:100',
                Rule::unique('work')->where(function ($query) use($request){
                    $query->where([
                        'artist_id' => $request->user()->id,
                        'title' => $request->input('title')
                    ]);
                })
            ],
            'type' => 'required|string|max:20',
            'medium' => 'required|string|max:20',
            'style' => 'required|string|max:20',
            'size' => 'required|string|max:20',
            'price' => 'required|numeric',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:4096'
        ]);
        $validator->validate();
        
        $work = new Work;
        $work->title = $request->input('title');
        $work->artist_id = $request->user()->id;
        $work->type = $request->input('type');
        $work->medium = $request->input('medium');
        $work->style = $request->input('style');
        $work->size = $request->input('size');

        $work->asking_price = $request->input('price');
        $work->descript = $request->input('description');

        $image = $request->file('image');
        $img = Image::make($image);
        //org
        $img->stream();
        $fileorg = uniqid('img_');
        Storage::disk('public')->put('images/arts/org/'.$fileorg, $img, 'public');

        //thumbnail
        $thumbnail = Image::make($image)->resize(200, 250, function($constraint){
            $constraint->aspectRatio();
        });
        $thumbnail->stream();
        $filethumb = uniqid('img_');
        $work->image_path = $fileorg;
        $work->image_thumb = $filethumb;
        Storage::disk('public')->put('images/arts/thumb/'.$filethumb, $thumbnail, 'public');

        $work->save();
        // if()
        return response()->json([
            'message' => 'success',
            'data' => $work->get()
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
        $work = Work::where('id', $id);
        if($work->exists()){
            // $work = $work->with([
            //     'artist' => function ($query) {
            //         $query->select('id','name');
            //     },
            //     'user' =>  function ($query) {
            //         $query->select('id');
            //     }])->get();
            $work->first()->artist;
            return view('pages.work.show',[
                'work' => $work->first()
            ]);
        }else{
            abort(404);
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
