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
        //
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\user  $user
     * @return \Illuminate\Http\Response
     */
    public function show(user $user)
    {
        //
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
    public function update(Request $request, user $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\user  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        self::deleteUser();       

    }

    


    public function login()
    {
        $email = $_POST['email'];
        $password = $_POST['password'];

        if (Validator::isStringEmpty($password) or Validator::isStringEmpty($email)) 
        {
            return parent::response('Los campos no pueden estar vacios', 400);
        }

        if (!self::isEmailInUse($email)) {
           return(parent::response("El usuario no existe",400));
        }

        $user = parent::findUser($email);

         if (password_verify($password, $user->password) and $user->email == $email) 
        {
            $token = self::generateToken($email, $password, $user->name, $user->nickName);
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
    public function register()
    {
        $name = $_POST['name'];
        $password = $_POST['password'];
        $email = $_POST['email'];
        $nickName = $_POST['nickName'];

        if (Validator::isStringEmpty($name) or Validator::isStringEmpty($password) or Validator::isStringEmpty($email)) 
        {
            return parent::response('Los campos no pueden estar vacios', 400);
        }
        if (!Validator::isValidEmail($email)) {
            return parent::response('Usa un email valido.', 400);
        }
        if (self::isEmailInUse($email)) 
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
        
        $token = self::generateToken($user);
            return response()->json ([
                'token' => $token
            ]);
    }


    

    private function generateToken($email, $password, $name, $nickName)    {       

        $dataToken = [
            'email' => $email,
            'password' => $password,
            'name' => $name,
            'nickName' => $nickName,
            'random' => time()
        ];

        $token = JWT::encode($dataToken, self::TOKEN_KEY);
        return $token;       

    }


    public function deleteUser()
    {
        if (parent::checkLogin())
        {
            $user = self::getUserFromToken();
            $user->delete();
            return parent::response('Su cuenta ha sido eliminada.', 200);
        }
        else 
        {
            return parent::response('Ha ocurrido un error con su sesión.', 303);
        }
        
    }

    private function isEmailInUse($email)
    {  
        $users = User::where('email', $email)->get();
        foreach ($users as &$user) 
        {
            if ($user->email == $email) 
            {
                return true; 
            }
        }
        
    }

    private function isValidPassword($password)
    {
        if (strlen($password) < 8) 
        {
            return false;
        }
        else 
        {
            return true; 
        }
    }

    private function isValidName($name)
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
}
