<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use File;
use Intervention\Image\Facades\Image;



class ImageController extends Controller
{
	const FULL_RESOLUTION_IMAGE_PATH = '/img/full/';
	const LOW_RESOLUTION_IMAGE_PATH = '/img/low/';


	public function store(Request $request)
	{	

  		// ruta de las imagenes guardadas
		if (!file_exists(storage_path() . self::FULL_RESOLUTION_IMAGE_PATH)) {
			mkdir(storage_path().self::FULL_RESOLUTION_IMAGE_PATH, 666, true);
		}
		else if (!file_exists(storage_path() . self::LOW_RESOLUTION_IMAGE_PATH)) {
			mkdir(storage_path().self::LOW_RESOLUTION_IMAGE_PATH, 666, true);
		} 

  		// recogida del form
		$originalImg = $request->file('img');

  		// crear instancia de imagen
		$image = Image::make($originalImg);
		$imgName = $request->file('img')->getClientOriginalName();

		$filename = pathinfo($_FILES['img']['name'], PATHINFO_FILENAME);
		//$image = self::crop_image($filename);
		//$image->resize(300,300);

		if(is_null($originalImg))
		{
			return parent::response("null img",400);
		}

		//$allowedMimeTypes = ['image/png'];
		//$contentType = mime_content_type($rute);
		
  		// guardar imagen
 		// save([ruta], [calidad])

		$image->save(storage_path() . self::FULL_RESOLUTION_IMAGE_PATH . $imgName, 100);
		$image->fit(200);
		$image->save(storage_path() . self::LOW_RESOLUTION_IMAGE_PATH . $imgName, 15);

		return parent::response("Image uploaded", 200);
	}


	
	public function getFullImage($fileName)
	{       
		$path = storage_path() . self::FULL_RESOLUTION_IMAGE_PATH . $fileName . '.png';;
		$file = File::get($path);
		$type = File::mimeType($path);
		$response = Response::make($file, 200);
		$response->header("Content-Type", $type);
		ob_end_clean();
		return $response;
	}

	public function getLowImage($fileName)
	{       
		$path = storage_path() . self::LOW_RESOLUTION_IMAGE_PATH . $fileName . '.png';
		$file = File::get($path);
		$type = File::mimeType($path);
		$response = Response::make($file, 200);
		$response->header("Content-Type", $type);
		ob_end_clean();
		return $response;
	}

}


