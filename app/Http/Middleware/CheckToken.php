<?php

namespace App\Http\Middleware;
use \Firebase\JWT\JWT;

use Closure;

class CheckToken
{

    protected const TOKEN_KEY = "54a6e4fga84b6a";
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $headers = getallheaders();

        if(isset($headers['Authorization'])) {

            try {

                $token = $headers['Authorization'];
                $tokenDecoded = JWT::decode($token, self::TOKEN_KEY, array('HS256'));
                return $next($request);

            } catch (Exception $e){

                return response()->json ([
                    'message' => 'Access denied'
                ],301);
            }

        }
        else {

            return response()->json ([
                    'message' => 'Access denied'
            ],301);
        }
        
    }
}
