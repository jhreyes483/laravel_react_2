<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    public function register(Request $request){


        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save(); 
        $token = $user->createToken('auth_token')->plainTextToken;


        return ['user'=>$user,'token'=>$token ];
    }

    public function login(Request $request){
        $divice  = config('vars.DIVICE_NAME', '');
        /*
        old aut
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string'
        ]);
        $credentials = $request->only('email', 'password');
        

        $token = Auth::attempt($credentials);
        $data = response()->json([
            'status' => 'success',
            'authorisation' => [
                'token' => $token,
                'type' => 'bearer',
            ]
        ]);

          if (Auth::attempt($credentials)) {
            $user = User::whereId(Auth::id())->first(["id", "fullname"]);
            $token =  $user->createToken('Laika')->accessToken;
            $user->token = $token;
            $roles = $this->executeSP('CALL lsp_get_roles_by_picking(:user_id)', ["user_id" => $user->id]);
            if ($roles["status"] && count($roles["data"]) > 0) {
                return  $this->responseApi(true, ["type" => "success", "content" => "Usuario autenticado"], [
                    "fullname" => $user->fullname,
                    "email" => $request->email,
                    "token" => $token,
                    "roles" => $roles,
                    "id" => $user->id
                ]);
            }else{
                return  $this->responseApi(false, ["type" => "error", "content" => "No tiene acceso a ninguna bodega"], $roles);
            }
        }else{
            return  $this->responseApi(false, ["type" => "error", "content" => "Credenciales incorrectas"], []);
        }
        */

        $data = [];
        $user = User::where('email', $request->email)->first();
        if (!$user ||  !Hash::check( $request->password, $user->password )) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized',
            ], 401);
        }
  
        $token = $user->createToken('auth_token')->plainTextToken;
        $data = response()->json([
            'status' => 'success',
            'authorisation' => [
                'token' => $token,
                'type' => 'bearer',
            ]
        ]);
        return $data;
    }

    public function logout(Request $request){
        dd('aca');
        $user =  auth('sanctum')->user();
        if(!$user){
            return ['msg'=>'usuario no autenticado'];
        }else{
            $user->tokens()->where('id', $user->currentAccessToken()->id)->delete();
            return ['msg'=>'cerro session'];
        }    

    }



}
