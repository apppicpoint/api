<?php

namespace App\Http\Controllers;

use App\publication;
use Illuminate\Http\Request;
use App\Validator;
use App\publications_tag;
use App\tags;
use App\spot;
use App\User;

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

        foreach ($publications as $publication) {                        
            $publication->tags;
        }
        return response()->json([
            'publications' => $publications,
        ]);
    }


    public function getSpotPublications($spot_id){
        
        $publications = spot::find($spot_id)->publications;
        foreach ($publications as $publication) {                        
            $publication->tags;
        }

        return response()->json([
                'publications' => $publications,
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
                $tags_id = $request->tags_id; //puede ser un array de tags
                $publication->save();
                
                if(!is_null($tags_id)){                    
                    foreach ($tags_id as $tag_id) {                        
                        $publication->tags()->attach($tag_id);                  
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
        $publication->tags;
        return response()->json([
            'publication' => $publication,
        ]);
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
        if (parent::getUserRol() != 4 && parent::getUserFromToken()->id == $publication->user_id || parent::getUserRol() == 1){
                        $publication->update($request->all());


            $publicationTags = publications_tag::where('publication_id', $publication->id)->get();            
            foreach ($publicationTags as $relationship) {
                $relationship->delete();
            }

            if(!is_null($request->tag_id)){

                    foreach ($request->tag_id as $tag_id) {
                        $tagRelationShip = new publications_tag;
                        $tagRelationShip->publication_id = $publication->id;
                        $tagRelationShip->tag_id = $tag_id;                        
                        $tagRelationShip->save();                        
                    }
                }

            return parent::response($publication->description, 200);
        } else {
            return parent::response('Access denied', 301);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\publication  $publication
     * @return \Illuminate\Http\Response
     */
    public function destroy(publication $publication)
    {
        if (parent::getUserRol() != 4 && parent::getUserFromToken()->id == $publication->user_id || parent::getUserRol() == 1){

            $publicationTag = publications_tag::where('publication_id', $publication->id)->get();
            
            foreach ($publicationTag as $relationship) {
                $relationship->delete();
            }

            $publication->delete();
            return parent::response('Publication deleted', 200);
        }
        else {
            return parent::response('Access denied', 301);
        }
    }

    public function getUserPublications($user_id) {
        return response()->json([
                'publications' => User::find($user_id)->publications,
            ]);
    }
}
