<?php

namespace App\Http\Controllers;

use App\spots_tag;
use Illuminate\Http\Request;
use App\spot;
use App\tags;

class SpotsTagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (parent::checkLogin() && parent::getUserRol() == 1)
        {
            return response()->json([
                'spot_tag' => spots_tag::all(),
            ]);
        } 
        else 
        {
            return parent::response("You have no permissions", 403);
        }
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
    public function show($id)
    {
        $tagDeSpot = spots_tag::where('spot_id','=', $id)->get();

        return response()->json([
            "relacion" => $tagDeSpot
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\spots_tag  $spots_tag
     * @return \Illuminate\Http\Response
     */
    public function edit(spots_tag $spots_tag)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\spots_tag  $spots_tag
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, spots_tag $spots_tag)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\spots_tag  $spots_tag
     * @return \Illuminate\Http\Response
     */
    public function destroy(spots_tag $spots_tag)
    {
        //
    }
}
