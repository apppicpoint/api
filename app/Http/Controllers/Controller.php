<?php

namespace App\Http\Controllers;

use \Firebase\JWT\JWT;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\User;



class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    protected const TOKEN_KEY = "54a6e4fga84b6a";

    protected function findUser($email)
    {
        $user = User::where('email',$email)->first();       
        return $user;
        
    }

    protected function getUserRol(){
        $decodedToken = self::decodeToken();
        return $decodedToken->role_id;    
    }

    protected function getUserFromToken()
    {
       
        $decodedToken = self::decodeToken();
        $user = self::findUser($decodedToken->email);
        return $user;
    }

    

    //Comprueba si el token es valido.
    protected function checkLogin()
    {   
        $headers = getallheaders();
        if(!isset($headers['Authorization']) ) { return false;}    
        $tokenDecoded = self::decodeToken();
        $user = self::getUserFromToken();
        if ($tokenDecoded->password == $user->password and $tokenDecoded->email == $user->email) 
        {
            return true;
        }        
        else             
        {
            return response ('no tienes permisos', 301);
        }

    }

    private static function decodeToken()
    {  
        $headers = getallheaders();
        if(isset($headers['Authorization'])) 
        {
            $token = $headers['Authorization'];
            $tokenDecoded = JWT::decode($token, self::TOKEN_KEY, array('HS256'));
            return $tokenDecoded;
        }
    }

    protected function response($text, $code = 400){
    	return response()->json ([
            'message' => $text
        ],$code);
    }

    private function hasOnlyOneWord($name)
    {     
        if(ctype_graph($name)) 
        {
            return true;
        }
        else 
        {
            return false; 
        }
    }

    protected function randomPassword(){

        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $count = mb_strlen($chars);

        for ($i = 0, $result = ''; $i < 8; $i++) {
            $index = rand(0, $count - 1);
            $result .= mb_substr($chars, $index, 1);
        }

        return $result;
    }

}
