<?php

namespace App\Http\Controllers;

use App\comment;
use Illuminate\Http\Request;
use App\spot;
use App\Validator;



class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   $headers = getallheaders();

        if (isset($headers['spot_id'])) {
            return response()->json([
            'comments' => Spot::find($headers['spot_id'])->comments,
            ]);
        }
        
        return response()->json([
            'comments' => comment::all(),
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
        if (parent::getUserRol() != 4) {
            if (Validator::isStringEmpty($request->text)) 
            {
                return parent::response('Dont leave blank fields', 400);
            } else {
                $comment = new comment;
                $comment->text = $request->text;                
                $comment->spot_id = $request->spot_id;                  
                $comment->user_id = parent::getUserFromToken()->id;                
                $comment->save();
                
                return parent::response('Comment created', 200);
            }
            
        } else {
            return parent::response('Access denied', 301);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function show(comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function edit(comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, comment $comment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(comment $comment)
    {
        //
    }
}
