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
        if (parent::checkLogin() && parent::getUserRol() == 1)
        {
            return response()->json([
                'users' => User::all(),
            ]);
        } 
        else 
        {
            parent::response("You have no permissions")
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
        if(parent::getUserRol() != 4) {       

        
            if (!Validator::isValidEmail($request['email']) && !is_null($request['email'])) {
                return parent::response('Use a valid email.', 400);
            }
            if (Validator::isEmailInUse($request['email']) && !is_null($request['email'])) 
            {
                return parent::response('Email already exists', 400);
            } else if(!is_null($request['email'])){
                $user->email = $request['email'];
            }
            if (Validator::isNickNameInUse($request['nickName']) && !is_null($request['nickName'])) 
            {
                return parent::response('NickName already exists', 400);
            } 

            if (Validator::exceedsMaxLength($request['nickName'], 30) && !is_null($request['nickName'])) {
                return parent::response('NickName too long', 400);
            }else if(!is_null($request['nickName'])){
                $user->nickName = $request['nickName'];
            }
            
            if (!Validator::reachesMinLength($request['password'],8) && !is_null($request['password']))
            {
                return parent::response('Password too short.', 400);
            }else if(!is_null($request['password'])){
                $encodedPassword = password_hash($request['password'], PASSWORD_DEFAULT);
                $user->password = $encodedPassword;
            }
            
            if (Validator::exceedsMaxLength($request['name'], 30) && !is_null($request['name'])) {
                return parent::response('Name too long.', 400);
            }else if(!is_null($request['name'])){
                $user->name = $request['name'];
            }
            
            
            $user->biography = $request['biography'];
            $user->photo = $request['photo'];
            $user->telephone = $request['telephone'];
            $user->update();
            return parent::response("User modified", 200);
        }
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
            return parent::response("User deleted", 200);
        }


    }

    


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
        {
            $token = self::generateToken($email, $password, $user->name, $user->nickName, $user->role_id);
            return response()->json ([
                'token' => $token
            ]);
        }
        else 
        {            
            return parent::response('Invalid inputs', 400);
        }


    }

    

    const ROLE_ID = 3; 
//registrar nuevo usuario
    public function register(Request $request)
    {
        $name = $request['name'];
        $password = $request['password'];
        $email = $request['email'];
        $nickName = $request['nickName'];

        if (Validator::isStringEmpty($name) or Validator::isStringEmpty($password) or Validator::isStringEmpty($email)) 
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
        if (!Validator::hasOnlyOneWord($nickName)) 
        {
            return parent::response('NickName must be only one word', 400);
        }
        if (!Validator::reachesMinLength($password,8))
        {
            return parent::response('Password too short', 400);
        }
        
        if (Validator::exceedsMaxLength($name, 50)) {
            return parent::response('Name too long', 400);
        }
        if (Validator::exceedsMaxLength($nickName, 50)) {
            return parent::response('NickName too long', 400);
        }
        

        $encodedPassword = password_hash($password, PASSWORD_DEFAULT);
        $user = new User;
        $user->name = $name;
        $user->password = $encodedPassword;
        $user->email = $email;
        $user->role_id = self::ROLE_ID; 
        $user->nickName = $nickName;
        $user->save();
        
        $token = self::generateToken($email, $password, $name, $nickName, self::ROLE_ID);
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
