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
		if (!file_exists($rute)) 
		{
            mkdir($rute, 666, true);
        }
  		// recogida del form
		$originalImg = $request->file('img');
  
  		// crear instancia de imagen
		$image = Image::make($originalImg);
		$imgName = $request->file('img')->getClientOriginalName();
		$image->resize(300,300);

		if(is_null($originalImg))
		{
			return parent::response("null img",400);
		}

		$allowedMimeTypes = ['image/png'];
		$contentType = mime_content_type($rute);
		
  		// guardar imagen
 		// save([ruta], [calidad])
		$image->save($rute . $imgName, 300);
		return parent::response("Image uploaded", 200);
	}

	/*//Hace la imagen cuadrada
	public function previewImage($image, $width,$height) {
		$image->resize($width,$height);
	}
	*/

	/*function crop_image($image) {

	    //$x_o и $y_o - Output image top left angle coordinates on input image
	    //$w_o и h_o - Width and height of output image

	    list($w_i, $h_i, $type) = getimagesize($image); // Return the size and image type (number)

	    //calculating 16:9 ratio
	    $w_o = $w_i;
	    $h_o = 9 * $w_o / 16;

	    //if output height is longer then width
	    if ($h_i < $h_o) {
	        $h_o = $h_i;
	        $w_o = 16 * $h_o / 9;
	    }

	    $x_o = $w_i - $w_o;
	    $y_o = $h_i - $h_o;

	    $types = array("", "gif", "jpeg", "png"); // Array with image types
	    $ext = $types[$type]; // If you know image type, "code" of image type, get type name
	    if ($ext) {
	      $func = 'imagecreatefrom'.$ext; // Get the function name for the type, in the way to create image
	      $img_i = $func($image); // Creating the descriptor for input image
	    } else {
	      echo 'Incorrect image'; // Showing an error, if the image type is unsupported
	      return false;
	    }
	    if ($x_o + $w_o > $w_i) $w_o = $w_i - $x_o; // If width of output image is bigger then input image (considering x_o), reduce it
	    if ($y_o + $h_o > $h_i) $h_o = $h_i - $y_o; // If height of output image is bigger then input image (considering y_o), reduce it
	    $img_o = imagecreatetruecolor($w_o, $h_o); // Creating descriptor for input image
	    imagecopy($img_o, $img_i, 0, 0, $x_o/2, $y_o/2, $w_o, $h_o); // Move part of image from input to output
	    $func = 'image'.$ext; // Function that allows to save the result
	    return $func($img_o, $image); // Overwrite input image with output on server, return action's result    
	}*/

    public function getImage($fileName)
    {       
        $path = public_path().'/img/'.$fileName.'.png';

	    $file = File::get($path);
	    $type = File::mimeType($path);
	    $response = Response::make($file, 200);
	    $response->header("Content-Type", $type);
	    ob_end_clean();
	    return $response;
    }
     
}


