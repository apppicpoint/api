<?php

namespace App\Http\Controllers;

use App\publication;
use Illuminate\Http\Request;
use App\Validator;
use App\publications_tag;
use App\tags;

class PublicationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $headers = getallheaders();

        if (isset($headers['user_id'])) {

            return response()->json([
                'publications' => publication::where('user_id', '=', $headers['user_id'])->get(),
            ]);

        } else {
            $publications = publication::all();
        }

        return response()->json([
            'publications' => $publications,
        ]);
    }


    public function getSpotPublications(){

        $headers = getallheaders();
        if (isset($headers['spot_id'])) {
            return response()->json([
                'publications' => publication::where('spot_id', '=', $headers['spot_id'])->get(),
            ]);
        }
        return parent::response("select a spot_id", 400);
        
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
        if (parent::getUserRol() != 4) {
            if (Validator::isStringEmpty($request->media)) {
                return parent::response('Dont leave blank fields', 400);
            } 

            else {
                $publication = new publication;
                $publication->media = $request->media; 
                if(isset($request->description)) {
                    $publication->description = $request->description;
                }
                if(isset($request->spot_id)) {
                    $publication->spot_id = $request->spot_id;
                }
                $publication->user_id = parent::getUserFromToken()->id;
                $tags_id = $request->tag_id; //puede ser un array de tags
                
                $publication->save();

                if(!is_null($tags_id)){

                    foreach ($tags_id as $tag_id) {
                        $tagRelationShip = new publications_tag;
                        $tagRelationShip->publication_id = $publication->id;
                        $tagRelationShip->tag_id = $tag_id;                        
                        $tagRelationShip->save();                        
                    }
                }

                return parent::response('publication created', 200);
            }
            
        } else {
            return parent::response('Access denied', 301);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\publication  $publication
     * @return \Illuminate\Http\Response
     */
    public function show(publication $publication)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\publication  $publication
     * @return \Illuminate\Http\Response
     */
    public function edit(publication $publication)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\publication  $publication
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, publication $publication)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\publication  $publication
     * @return \Illuminate\Http\Response
     */
    public function destroy(publication $publication)
    {
        //
    }
}
