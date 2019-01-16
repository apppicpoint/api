<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Validator;
use \Firebase\JWT\JWT;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (parent::checkLogin() && parent::getUserRol() == 1){
            return response()->json([
                'users' => User::all(),
            ]);;

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
        self::register($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\user  $user
     * @return \Illuminate\Http\Response
     */
    public function show(user $user)
    {
        if (parent::getUserRol() != 4) {
            return response($user);
        }
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\user  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(user $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\user  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {   
        $user->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\user  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        
         if (parent::checkLogin() && parent::getUserFromToken()->id == $user->user_id || parent::getUserRol() == 1){
            $user->delete();
        }


    }

    


    public function login(Request $request)
    {
        $email = $request['email'];
        $password = $request['password'];

        if (Validator::isStringEmpty($password) or Validator::isStringEmpty($email)) 
        {
            return parent::response('Los campos no pueden estar vacios', 400);
        }

        if (!Validator::isEmailInUse($email)) {
           return(parent::response("El usuario no existe",400));
        }

        $user = parent::findUser($email);

         if (password_verify($password, $user->password) and $user->email == $email) 
        {
            $token = self::generateToken($email, $password, $user->name, $user->nickName, $user->role_id);
            return response()->json ([
                'token' => $token
            ]);
        }
        else 
        {            
            return parent::response('Datos incorrectos', 400);
        }


    }

    

    const ROLE_ID = 2; 
//registrar nuevo usuario
    public function register(Request $request)
    {
        $name = $request['name'];
        $password = $request['password'];
        $email = $request['email'];
        $nickName = $request['nickName'];

        if (Validator::isStringEmpty($name) or Validator::isStringEmpty($password) or Validator::isStringEmpty($email)) 
        {
            return parent::response('Los campos no pueden estar vacios', 400);
        }
        if (!Validator::isValidEmail($email)) {
            return parent::response('Usa un email valido.', 400);
        }
        if (Validator::isEmailInUse($email)) 
        {
            return parent::response('El email ya existe.', 400);
        } 
        if (!Validator::hasOnlyOneWord($name)) 
        {
            return parent::response('El nombre debe contener una unica palabra.', 400);
        }
        if (!Validator::reachesMinLength($password,8))
        {
            return parent::response('Contraseña demasiado corta.', 400);
        }
        
        if (Validator::exceedsMaxLength($name, 50)) {
            return parent::response('Nombre demasiado largo.', 400);
        }
        

        $encodedPassword = password_hash($password, PASSWORD_DEFAULT);
        $user = new User;
        $user->name = $name;
        $user->password = $encodedPassword;
        $user->email = $email;
        $user->role_id = self::ROLE_ID; 
        $user->nickName = $nickName;
        $user->save();
        
        $token = self::generateToken($email, $password, $name, $nickName, $role_id);
            return response()->json ([
                'token' => $token
            ]);
    }


    

    private function generateToken($email, $password, $name, $nickName, $role_id)    {       

        $dataToken = [
            'email' => $email,
            'password' => $password,
            'name' => $name,
            'nickName' => $nickName,
            'role_id' => $role_id,
            'random' => time()
        ];

        $token = JWT::encode($dataToken, self::TOKEN_KEY);
        return $token;       

    }

    public function guestToken(){
        $dataToken = [            
            'role_id' => 4,
            'random' => time()
        ];

        $token = JWT::encode($dataToken, self::TOKEN_KEY);
        return response()->json([
            'token' => $token
        ]); 
    }

    

    

    
}
