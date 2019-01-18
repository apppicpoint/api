<?php

namespace App\Http\Controllers;

use App\spot;
use App\User;
use Illuminate\Http\Request;
use App\Validator;

class SpotController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $headers = getallheaders();

        if (isset($headers['search'])){

            $search = $headers['search'];

            $spots = Spot::where('name', "like", "%".$search."%")->orWhere('city', "like", "%".$search."%")->orWhere('country', "like", "%".$search."%")->get();

        }
        else if (isset($headers['user_id'])){

            return response()->json([
            'spots' => Spot::where('user_id', '=', $headers['user_id'])->get(),
            ]);

        }
        else {

            $spots = Spot::all();
        }

        return response()->json([
                'spots' => $spots,
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

            if (Validator::isStringEmpty($request->name) or Validator::isStringEmpty($request->description) or Validator::isStringEmpty($request->latitude) or Validator::isStringEmpty($request->longitude)) 
            {
                return parent::response('Dont let blank fields', 400);
            }

            else {

                $spot = new Spot;
                $spot->name = $request->name;
                $spot->description = $request->description;
                $spot->latitude = $request->latitude;
                $spot->longitude = $request->longitude;
                $spot->city = $request->city; 
                $spot->country = $request->country; 
                $spot->user_id = parent::getUserFromToken()->id;
                $spot->save();

                return parent::response('Spot created', 200);
            }
            
            
        }
        else {
            return parent::response('Access denied', 301);
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
        return response()->json([
                'spot' => $spot,
        ]);
        
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

        if (parent::getUserRol() != 4 && parent::getUserFromToken()->id == $spot->user_id || parent::getUserRol() == 1){

            $spot->update($request->all());
            return parent::response('Spot updated', 200);

        }
        else {

            return parent::response('Access denied', 301);
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

        if (parent::getUserRol() != 4 && parent::getUserFromToken()->id == $spot->user_id || parent::getUserRol() == 1){

            $spot->delete();
            return parent::response('Spot deleted', 200);
        }
        else {

            return parent::response('Access denied', 301);
        }
        
    }
}
