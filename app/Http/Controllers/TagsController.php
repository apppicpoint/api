<?php

namespace App\Http\Controllers;

use App\tags;
use Illuminate\Http\Request;
use App\Validator;


class TagsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(!parent::checkLogin()){
            return parent::response("You don't have permissions", 403);
        }

        return response()->json([
            'tags' => tags::all(),
        ]);
        
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
        $inputName = $request->name;
        if(Validator::isStringEmpty($inputName)){
            return parent::response("Cannot be any empty field", 400);
        }

        if(Validator::isTagNameInUse($inputName)){
            return parent::response("This tag name already exists", 400);
        }

        $tag = new tags;
        $tag->name = $inputName;
        $tag->save();

        return parent::response("Tag created", 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\tags  $tags
     * @return \Illuminate\Http\Response
     */
    public function show(tags $tags)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\tags  $tags
     * @return \Illuminate\Http\Response
     */
    public function edit(tags $tags)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\tags  $tags
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, tags $tags)
    {
        if(parent::getUserRol() == 1){

            if(Validator::isStringEmpty($request['name'])){
                return parent::response("Cannot be any empty field", 400);
            }

            if(Validator::isTagNameInUse($request['name'])){
                return parent::response("This tag name already exists", 400);
            }

            if(is_null($request['name'])){
                return parent::response("The name cannot be empty", 400);
            }

            $tags->name = $request['name'];
            $tags->update($request->all());

            return parent::response("Tag modified",200);
        } else {
            return parent::response("You don't have permissions", 403);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\tags  $tags
     * @return \Illuminate\Http\Response
     */
    public function destroy(tags $tags)
    {
        if(parent::checkLogin() && parent::getUserRol() == 1){
            $tags->delete();

            return parent::response("Tag deleted", 200);
        }
        
    }
}
