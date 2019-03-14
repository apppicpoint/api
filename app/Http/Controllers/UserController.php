<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Validator;
use \Firebase\JWT\JWT;
use Illuminate\Support\Facades\Hash;
use Mail;

class UserController extends Controller
{
    /**
     * Muestra todos los usuarios registrados si el usuario que lo pide tiene el rol de administrador
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (parent::checkLogin() && parent::getUserRol() == 1)
        {
            return response()->json([
                'users' => User::all(),
            ]);
        } 
        else 
        {
            return parent::response("You have no permissions", 403);
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

    }

    /**
     * Muestra el usuario pedido por parametro.
     *
     * @param  \App\user  $user
     * @return \Illuminate\Http\Response
     */
    public function show(user $user)
    {        
        return response()->json([
            'user' => $user,
        ]);        
        
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
     * Comprueba el rol del usuario y valida todos los campos.
     * Si un campo requerido (email) no es rellenado, se considerá que no se quiere modificar y se mantendrá
     * en la base de datos como está.
     * Si un campo no requerido (biografía) no es rellenado, se enviará a la base de datos vacío.
     * Una vez modificados todos los datos se actualizará la bd.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\user  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {   

        if(parent::getUserRol() == 1 or (parent::getUserRol() != 4 and parent::getUserId() == $request['user_id'])) {       


            if (!Validator::isValidEmail($request['email']) && !is_null($request['email'])) {
                return parent::response('Use a valid email.', 400);
            }

            if (Validator::isEmailInUse($request['email']) && !is_null($request['email']) && $request['email'] != $user->email) 
            {
                return parent::response('Email already exists', 400);
            } else if(!is_null($request['email'])){
                $user->email = $request['email'];
            }

            if (Validator::isNickNameInUse($request['nickName']) && !is_null($request['nickName']) && $request['nickName'] != $user->nickName) 
            {
                return parent::response('NickName already exists', 400);
            } 

            if (Validator::exceedsMaxLength($request['nickName'], 30) && !is_null($request['nickName'])) {
                return parent::response('NickName too long', 400);
            } else if(!is_null($request['nickName'])){
                $user->nickName = $request['nickName'];
            }
            
            if (!Validator::reachesMinLength($request['password'],8) && !is_null($request['password']))
            {
                return parent::response('Password too short.', 400);
            } else if(!is_null($request['password'])){
                $encodedPassword = password_hash($request['password'], PASSWORD_DEFAULT);
                $user->password = $encodedPassword;
            }
            
            if (Validator::exceedsMaxLength($request['name'], 30) && !is_null($request['name'])) {
                return parent::response('Name too long.', 400);
            } else if(!is_null($request['name'])){
                $user->name = $request['name'];
            }
            
            if ($request['role_id'] < 1 or $request['role_id'] > 3 and !is_null($request['role_id'])) {               
                return parent::response('This is not a correct user status', 400);
            } else if (!is_null($request['role_id'])) {
                $user->role_id = $request['role_id'];
            }
            

            $user->biography = $request['biography'];
            $user->photo = $request['photo'];
            $user->telephone = $request['telephone'];
            $user->update();
            return parent::response("User modified", 200);
        }
    }

    /**
     * Marca como "eliminado" el usuario especificado.
     *
     * @param  \App\user  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {

       if (parent::checkLogin() && parent::getUserFromToken()->id == $user->user_id || parent::getUserRol() == 1){
        $user->delete();
        return parent::response("User deleted", 200);
    }
}



    /**
     * Valida las credenciales del usuario y devuelve un token 
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $email = $request['email'];
        $password = $request['password'];

        if (Validator::isStringEmpty($password) or Validator::isStringEmpty($email)) 
        {
            return parent::response('Fields cannot be empty', 400);
        }

        if (!Validator::isEmailInUse($email)) {
         return(parent::response("User doesn't exist",400));
     }

     $user = parent::findUser($email);

     if (password_verify($password, $user->password) and $user->email == $email) 
        {   if ($user->banned) {
            return parent::response('You have been banned', 301);
        }
        else {
            $token = self::generateToken($user);
            return response()->json ([
                'token' => $token,
                'role_id' => $user->role_id,
                'user_id' => $user->id
            ]);
        }
    }


    else 
    {            
        return parent::response('Invalid inputs', 400);
    }


}



const STANDARD_ROLE_ID = 3; 
const GUEST_ROLE_ID = 4;

    /**
     * Valida todos los campos, registra al usuario en la base de datos y devuelve un token 
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function register(Request $request)
    {
        $password = $request['password'];
        $email = $request['email'];
        $nickName = $request['nickName'];
        if (Validator::isStringEmpty($nickName) or Validator::isStringEmpty($password) or Validator::isStringEmpty($email)) 
        {
            return parent::response('Fields cannot be empty', 400);
        }
        
        if (!Validator::isValidEmail($email)) {
            return parent::response('Use a valid email.', 400);
        }
        
        if (Validator::isEmailInUse($email)) 
        {
            return parent::response('Email already exists', 400);
        } 
        if (Validator::isNickNameInUse($nickName)) 
        {
            return parent::response('Nickname already exists', 400);
        } 

        if (!Validator::hasOnlyOneWord($nickName)) 
        {
            return parent::response('Nickname must be only one word', 400);
        }
        
        if (!Validator::reachesMinLength($password,8))
        {
            return parent::response('Password too short', 400);
        }

        if (Validator::exceedsMaxLength($nickName, 50)) {
            return parent::response('NickName too long', 400);
        }
        
        if (($request['role_id'] < 1 or $request['role_id'] > 3) and !is_null($request['role_id'])) {
            return parent::response('This is not a correct user status', 400);
        }
        
        $encodedPassword = password_hash($password, PASSWORD_DEFAULT);
        $user = new User;
        $user->password = $encodedPassword;
        $user->email = $email;
        $user->role_id = ($request['role_id']) ? $request['role_id'] : $role_id = self::STANDARD_ROLE_ID;
        $user->nickName = $nickName;
        $user->save();
        
        $token = self::generateToken($user);
        return response()->json ([
            'token' => $token,
            'role_id' => $user->role_id,
            'user_id' => $user->id
        ]);
    }

    /**
     * Comprueba si existe el email, genera una nueva contraseña y le envia un correo al usuario.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    // Recibe un email, comprueba que está registrado, e intenta enviar el email con la nueva password. 

    public function forgotPassword(Request $request){

       if (Validator::isEmailInUse($request->email)){

        try {

            $user = parent::findUser($request->email);
            $newPassword = parent::randomString(8);
            $to_name = $user->name;
            $to_email = $user->email;

            $user->update([
                'password' => Hash::make($newPassword),
            ]);

            $data = array('name'=>$user->name, "password" => $newPassword );

            Mail::send('emails.forgot', $data, function($message) use ($to_name, $to_email) {
                $message->to($to_email, $to_name)
                ->subject('Picpoint | Forgot password');
                $message->from('apppicpoint@gmail.com','Picpoint');
            });

            return parent::response('New password sent', 200);

        } catch (Exception $e) {

            return parent::response('Error in the request', 400);
        }      
    }
    else {

        return parent::response('This email is not registered', 400);
    }
}

    /**
     * Genera un token a partir de los daros del usuario.
     *
     * @param  $user
     * @return $token
     */
    private function generateToken(User $user)    {       

        $dataToken = [
            'email' => $user->email,
            'password' => $user->password,
            'name' => $user->name,
            'nickName' => $user->nickName,
            'role_id' => $user->role_id,
            'user_id' => $user->id,
            'random' => time()
        ];

        $token = JWT::encode($dataToken, self::TOKEN_KEY);
        return $token;       

    }

    /**
     * Genera un token de invitado
     *
     * @return $token
     */
    public function guestToken(){
        $dataToken = [            
            'role_id' => self::GUEST_ROLE_ID,
            'random' => time()
        ];

        $token = JWT::encode($dataToken, self::TOKEN_KEY);
        return response()->json([
            'token' => $token,
            'role_id' => self::GUEST_ROLE_ID
        ]); 
    }


/**
     * Obtiene el rol del usuario a partir de un token.
     *
     * @return \Illuminate\Http\Response
     */    
public function getUserRol(){
    $role = parent::getUserRol();
    return response()->json ([
        'role' => $role
    ]);
}

    /**
     * Alterna el estado del usuario entre bloqueado y desbloqueado.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */    
    public function changeBannedState(User $user)
    {
        $user->banned = !$user->banned;
        $user->update();
        return parent::response('Estado cambiado', 200);
    }
    
}
