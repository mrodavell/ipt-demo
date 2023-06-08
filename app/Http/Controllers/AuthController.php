<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request){

        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        try{

            $user = User::where('email', $request->email)->first();

            // Checks if user exist with correct password
            if (!$user || !Hash::check($request->password, $user->password)) {
                return response([
                    'message' => 'Account is not registered',
                ], 401);
            } 

            $token = $user->createToken($request->email . 'appToken')->plainTextToken;

            $response = [
                'token' => $token,
            ];

            return response($response, 200);

        }catch(\Exception $e){
            return response(["message" => $e->getMessage()], 400);
        }
    }

    public function register(Request $request){

        $request->validate([
            'email' => 'required|email|unique:users,email',
            'name' => 'required|string',
            'password' => 'required|string',
        ]);

        try{

            User::create([
                "email" => $request->email,
                "name" => $request->name,
                "password" => $request->password
            ]);

            return response(["message" => "Successfully Registered"], 200);

        }catch(\Exception $e){
            return response(["message" => $e->getMessage()], 400);
        }
    }

    public function logout(){
        try {
            auth()->user()->currentAccessToken()->delete();
            return response(["message" => "Logged Out"], 200);
        } catch (\Exception $e) {
            return response(["message" => $e->getMessage()], 400);
        }
    }
}
