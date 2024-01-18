<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Validator;

class AuthController extends Controller
{
    public function register(Request $req) {
        $req->validate([
            'name' => 'required|string',
            'email'=>'required|string|unique:users',
            'password'=>'required|string|min:4',
        ]);

        $user = new User([
            'name' =>  $req->name,
            'email' =>  $req->email,
            'password' => bcrypt($req->password)  
        ]);

        if($user->save()) {
            $tokenResult = $user->createToken('Access Token');
            $token = $tokenResult->plainTextToken;

            return response()->json([
                'message' => 'User Created Successfully',
                'token' => $token
            ], 200) ;
        } else {
            return response()->json([
                'error' => 'Error Registing User'
            ], 401) ;
        }

    }

    public function login(Request $req) {
        $req->validate([
            'email'=>'required|string',
            'password'=>'required|string',
        ]);

        $credentials = request(['email', 'password']) ;
        if(!Auth::attempt($credentials)) {
            return response()->json([
                'error' => 'Email or Password is incorrect'
            ], 401) ;
        }

        $user = $req->user() ;
        $tokenResult = $user->createToken('Access Token');
        $token = $tokenResult->plainTextToken;

        return response()->json([
            'message' => 'User logIn Successfully',
            'token' =>$token,
            'token_type' => 'Bearer',
            ], 200);

    }

    public function user(Request $request) {
        return response()->json($request->user());
    }

    public function logout(Request $request) {
        $request->user()->tokens()->delete();

        return response()->json([
         'message' => 'Successfully logged out'
        ]);

    }
}
