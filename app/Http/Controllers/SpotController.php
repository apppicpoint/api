<?php

namespace App\Http\Controllers;

use App\spot;
use Illuminate\Http\Request;

class SpotController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (parent::checkLogin() || parent::getUserRol() != 4){

            return response()->json([
                'spots' => Spot::all(),
            ]);
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

        if (parent::checkLogin() && parent::getUserRol() != 4) {

            if (Validator::isStringEmpty($request->name) or Validator::isStringEmpty($request->description) or Validator::isStringEmpty($request->latitude) or Validator::isStringEmpty($request->longitude)) 
            {
                return parent::response('Los campos no pueden estar vacios', 400);
            }
            
            $spot = new Spot;
            $spot->name = $request->name;
            $spot->description = $request->description;
            $spot->latitude = $request->latitude;
            $spot->longitude = $request->longitude; 
            $spot->user_id = parent::getUserFromToken()->id;
            $user->save();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\spot  $spot
     * @return \Illuminate\Http\Response
     */
    public function show(spot $spot)
    {
        if (parent::checkLogin() || parent::getUserRol() == 4){

            return response()->json([
                'spot' => $spot,
            ]);

        }
        
    }

    public function showUserSpots(Request $request)
    {

        if (parent::checkLogin() || parent::getUserRol() == 4){

            try {

                return response()->json([
                'spots' => Spot::where('user_id', '=', parent::getUserFromToken()->id)->get(),
                ]);

            }
            catch(\Exception $e){

                return response()->json([
                'spots' => Spot::where('user_id', '=', $request->user_id)->get(),
                ]);
            }
            

        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\spot  $spot
     * @return \Illuminate\Http\Response
     */
    public function edit(spot $spot)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\spot  $spot
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, spot $spot)
    {

        if (parent::checkLogin() && parent::getUserFromToken()->id == $spot->user_id || parent::getUserRol() == 1){

            $spot->update([

                'name' => $request->name,
                'description' => $request->description,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,

            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\spot  $spot
     * @return \Illuminate\Http\Response
     */
    public function destroy(spot $spot)
    {

        if (parent::checkLogin() && parent::getUserFromToken()->id == $spot->user_id || parent::getUserRol() == 1){

            $category->delete();
        }
        
    }
}
