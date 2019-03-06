<?php

namespace App\Http\Controllers;

use App\publications_tag;
use Illuminate\Http\Request;
use App\tag;


class PublicationsTagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return response()->json([
            'publications_tag' => publications_tag::all(),
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
        $publication_id = $request['publication_id'];
        $tag_id = $request['tag_id'];
        $publication = publication::where('id', '=', $publication_id)->exists();
        $tag = tags::where('id', $tag_id)->exists();

        if(is_null($tag_id) || is_null($publication_id)){
            return parent::response("Something is null",400);
        }

        if(!$publication){
            return parent::response("That point doesn't exist", 400);
        }
        
        if(!$tag){
            return parent::response("That tag doesn't exist", 400);
        }

        $publicationTag = new publications_tag;
        $publicationTag->publication_id = $publication_id;
        $publicationTag->tag_id = $tag_id;

        $publicationTag->save();

        return parent::response("Relatioship created", 200);
    }

    

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\publications_tag  $publications_tag
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, publications_tag $publications_tag)
    {
        $publication_id = $request->publication_id;
        $publication_tags = publications_tag::where('publication_id','=', $publication_id)->get();

        $tags = [];
        for ($i=0; $i < count($publication_tags); $i++) 
        { 
            array_push($tags, $publication_tags[$i]["tag_id"]);
        }

        $arrayTags = [];
        for ($i=0; $i < count($tags); $i++) { 
            array_push($arrayTags , tags::where('id', $tags[$i])->first());
        }

        return response()->json([
            'tags' => $arrayTags
        ]);
    }

    public function getPublicationsByTag($tag_id){
        return response()->json([
            'pblications' => tag::find($tag_id)->publications,
        ]);
    }
}
