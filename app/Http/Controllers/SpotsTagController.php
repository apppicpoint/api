<?php

namespace App\Http\Controllers;

use App\spots_tag;
use Illuminate\Http\Request;
use App\spot;
use App\tag;

class SpotsTagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json([
            'spot_tag' => spots_tag::all(),
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
        $spot_id = $request['spot_id'];
        $tag_id = $request['tag_id'];
        $spot = spot::where('id', '=', $spot_id)->exists();
        $tag = tags::where('id', $tag_id)->exists();

        if(is_null($tag_id) || is_null($spot_id)){
            return parent::response("Something is null",400);
        }

        if(!$spot){
            return parent::response("That point doesn't exist", 400);
        }
        
        if(!$tag){
            return parent::response("That tag doesn't exist", 400);
        }

        $spotTag = new spots_tag;
        $spotTag->spot_id = $spot_id;
        $spotTag->tag_id = $tag_id;

        $spotTag->save();

        return parent::response("Relatioship created", 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\spots_tag  $spots_tag
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        
    }

//Este método devuelve un array de los tags de un spot
    public function spotHasTags(Request $request)
    {   
        return response()->json([
            'tags' => spot::find($request['spot_id'])->tags,
        ]);
    }

    public function getSpotsByTag($tag_id){
        return response()->json([
            'spots' => tag::find($tag_id)->spots,
        ]);
    }
}
