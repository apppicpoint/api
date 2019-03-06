<?php

namespace App\Http\Controllers;

use App\spot;
use App\User;
use Illuminate\Http\Request;
use App\Validator;
use App\spots_tag;
use App\tag;

class SpotController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    // Devuelve todos los spots.
    // Si le pasamos un user_id, devuelve los spots de ese usuario.
    // Si le pasamos un cadena de caracteres por el parametro search, busca spots que contengan esa cadena en su nombre, país, o ciudad.


    public function index(Request $request)
    {
        $headers = getallheaders();

        if (isset($headers['search'])){

            $search = $headers['search'];

            $spots = Spot::where('name', "like", "%".$search."%")->orWhere('city', "like", "%".$search."%")->orWhere('country', "like", "%".$search."%")->get();

        } else if (isset($headers['user_id'])) {

            return response()->json([
            'spots' => Spot::where('user_id', '=', $headers['user_id'])->get(),
            ]);

        } else {
            $spots = Spot::all();
        }

        foreach ($spots as $spot) {                        
            $spot->tags;
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

    // Crea un spot

    public function store(Request $request)
    {
        if (parent::getUserRol() != 4) {
            if (Validator::isStringEmpty($request->name) or Validator::isStringEmpty($request->description) or Validator::isStringEmpty($request->latitude) or Validator::isStringEmpty($request->longitude)) 
            {
                return parent::response('Dont leave blank fields', 400);
            } else {
                $spot = new Spot;
                $spot->name = $request->name;
                $spot->description = $request->description;
                $spot->latitude = $request->latitude;
                $spot->longitude = $request->longitude;
                $spot->city = $request->city; 
                $spot->country = $request->country;
                $spot->image = $request->image;  
                $spot->user_id = parent::getUserFromToken()->id;
                $tags_id = $request->tags_id; //puede ser un array de tags              
                $spot->save();

                if(!is_null($tags_id)){                    
                    foreach ($tags_id as $tag_id) {                        
                        $spot->tags()->attach($tag_id);                  
                    }
                }

                return parent::response('Spot created', 200);
            }
            
        } else {
            return parent::response('Access denied', 301);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\spot  $spot
     * @return \Illuminate\Http\Response
     */

    // Devuelve la información del spot seleccionado

    public function show(spot $spot)
    {
        $spot->tags;
        return response()->json([
            'spot' => $spot,
            

        ]);
    }


    // Actualiza los campos del spot editado

    public function update(Request $request, spot $spot)
    {
        if (parent::getUserRol() != 4 && parent::getUserFromToken()->id == $spot->user_id || parent::getUserRol() == 1){
            $spot->update($request->all());

            $spotTags = spots_tag::where('spot_id', $spot->id)->get();            
            foreach ($spotTags as $relationship) {
                $relationship->delete();
            }

            if(!is_null($request->tag_id)){

                    foreach ($request->tag_id as $tag_id) {
                        $tagRelationShip = new spots_tag;
                        $tagRelationShip->spot_id = $spot->id;
                        $tagRelationShip->tag_id = $tag_id;
                        
                        $tagRelationShip->save();                        
                    }
                }

            return parent::response('Spot updated', 200);
        } else {
            return parent::response('Access denied', 301);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\spot  $spot
     * @return \Illuminate\Http\Response
     */

    // Elimina el spot seleccionado y las relaciones con los tags

    public function destroy(spot $spot)
    {
        if (parent::getUserRol() != 4 && parent::getUserFromToken()->id == $spot->user_id || parent::getUserRol() == 1){

            $spotTags = spots_tag::where('spot_id', $spot->id)->get();
            
            foreach ($spotTags as $relationship) {
                $relationship->delete();
            }

            $spot->delete();
            return parent::response('Spot deleted', 200);
        }
        else {
            return parent::response('Access denied', 301);
        }
    }

     public function distance(Request $request)
    {

        if ($request->filled("latitude") or $request->filled("longitude") or $request->filled("distance"))
        {
            $latitude = $_POST['latitude'];
            $longitude = $_POST['longitude'];
            $distanceUser = $_POST['distance'];
    
            $spotSave = spot::all();
            $spotsNear = [];

            foreach ($spotSave as $spots => $spot) 
            {
                $dlon = $longitude - $spot->longitude; 
                $degrees = rad2deg(acos((sin(deg2rad($latitude))*sin(deg2rad($spot->latitude))) + (cos(deg2rad($latitude))*cos(deg2rad($spot->latitude))*cos(deg2rad($longitude-$spot->longitude)))));
                $distance = $degrees * 111.13384;

                if($distance <= $distanceUser)
                {
                    $spot->distance_user = $distance;
                    array_push($spotsNear, $spot);
                }
            }

            for ($i=0; $i < count($spotsNear) ; $i++) 
            { 
                if($i + 1 >= count($spotsNear))
                {
                    break;
                }

                $actual = $spotsNear[$i];
                $siguiente = $spotsNear[$i + 1];

                if($actual->distance_user > $siguiente->distance_user)
                {

                    $spotsNear[$i] = $siguiente;
                    $spotsNear[$i + 1] = $actual;
                    $i = -1;
                }
            }

            foreach ($spotsNear as $spot) {                        
            $spot->tags;
            }
            return response()->json([
                'spots' => $spotsNear,
            ]);
        }  
    }
    //Esta función devuelve en booleano si puede o no poner un punto
    public function checkSpotNear(Request $request)
    {
        if ($request->filled("latitude") or $request->filled("longitude"))
        {
            $latitude = $_POST['latitude'];
            $longitude = $_POST['longitude'];

            $spotSave = spot::whereBetween('latitude', [$latitude - 0.00015, $latitude + 0.00015])->whereBetween('longitude', [$longitude - 0.00015, $longitude + 0.00015])->first();

            return response()->json([
                'spot' => is_null($spotSave),
            ]);
        }
    }

}