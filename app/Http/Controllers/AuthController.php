<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\LoginUserRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    

    public function register(StoreUserRequest $request){
        $request->validated($request->all());

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        $token = $user->createToken('API Token of'.$user->name)->plainTextToken;
        
        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }


    public function login(LoginUserRequest $request){
        $request->validated($request->all());

        // find user by email
        $user = User::where('email', $request->email)->first();
        
        // Check email
        if(!$user ){
                return response([
                    'message'=> 'User not found'
                ], 401);
        }
        // Check password
        else if(!Hash::check($request->password, $user->password)){
            return response([
                'message'=> 'Login failed, check your email and password'
            ], 402);
        }

        // create token
        $token = $user->createToken('API Token of'.$user->name)->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);

    }

    public function logout(Request $request){
        
        auth()->user()->tokens()->delete();

        return [
            'message' => 'Successfully logged out'
        ];
    }
    
}