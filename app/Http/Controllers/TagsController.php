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

    public function array_sort_by($arrIni, $col, $order = SORT_ASC)
    {
        $arrAux = array();
        foreach ($arrIni as $key => $row)
        {
            $arrAux[$key] = is_object($row) ? $arrAux[$key] = $row->$col : $row[$col];
            $arrAux[$key] = strtolower($arrAux[$key]);
        }

        array_multisort($arrAux, $order, $arrIni);
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
    public function show($id)
    {
        if(!parent::checkLogin()){
            return parent::response("You don't have permissions", 403);
        }

        $tag = tags::where('id', $id)->first();
        return response()->json([
            'tag' => $tag
        ]);
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
    public function update(Request $request, $id)
    {
        if(parent::getUserRol() == 1){

            $newName = $request['name'];

            if(Validator::isStringEmpty($newName)){
                return parent::response("Cannot be any empty field", 400);
            }

            if(Validator::isTagNameInUse($newName)){
                return parent::response("This tag name already exists", 400);
            }

            if(is_null($newName)){
                return parent::response("The name cannot be empty", 400);
            }
            $tag = tags::where('id', $id)->first();

            $tag->name = $newName;
            $tag->update();

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
    public function destroy($id)
    {   
        $tag = tags::where('id', $id)->first();

        $tag->delete();
        return parent::response("Tag deleted", 200);
    }

    //Buscar tag mientras escribes
    public function selectTagByName($name){
        $tags = tags::where('name', $name)->first();

        return response()->json([
            'tags' => $tags
        ]); 
    }
}
