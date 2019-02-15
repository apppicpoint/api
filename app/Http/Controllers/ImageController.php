<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use File;
use Intervention\Image\Facades\Image;


class ImageController extends Controller
{


	public function store(Request $request)
	{		

  		// ruta de las imagenes guardadas
		$rute = public_path().'/img/';
		if (!file_exists($rute)) {
            mkdir($rute, 666, true);
        }
  		
  		// recogida del form
		$originalImg = $request->file('img');
  		
  		// crear instancia de imagen
		$image = Image::make($originalImg);
		$imgName = $request->file('img')->getClientOriginalName();
		$image->resize(300,300);
  		
  		// guardar imagen
  		// save( [ruta], [calidad])
		$image->save($rute . $imgName, 100);
		return parent::response("Image uploaded", 200);
	}	


    public function getImage($fileName){       

        $path = public_path().'/img/'.$fileName.'.jpeg';

	    $file = File::get($path);
	    $type = File::mimeType($path);
	    $response = Response::make($file, 200);
	    $response->header("Content-Type", $type);
	    ob_end_clean();
	    return $response;
    }

     
}


