<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Throwable;

class AuthController extends Controller {

    public function login(Request $request){
        try {
            $request->validate([
                'email' => 'required|email',
                'password' => 'required'
            ]);
        } catch (Throwable $error) {
            return response()->json([
                'status' => "error",
                'message' => 'Authentication failed',
                'error' => $error->errors(),
            ], Response::HTTP_BAD_REQUEST);
        }

        $user = User::where('email', $request->email)->get()->first();
        if(!$user || Hash::check($request->passowrd, $user->password)){
            return response()->json([
                "status" => "error",
                "message" => "Invalid credentials"
            ], Response::HTTP_UNAUTHORIZED);
        }
        
        $token = $user->createToken("loginToken")->plainTextToken;
        return response()->json([
            'user' => $user,
            'token' => [
                'type' => 'Bearer',
                'value' => $token
            ]
        ], Response::HTTP_OK);
    }

    public function register(Request $request){
        try {
            $request->validate([
                'name' => 'required|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required',
                'telephone' => 'required',
            ]);
        } catch (Throwable $error) {
            return response()->json([
                'status' => "error",
                'message' => 'Registration failed!',
                'error' => $error->errors(),
            ], Response::HTTP_BAD_REQUEST);
        }
        
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'telephone' => $request->phone,
            'admin' => false,
        ]);

        $token = $user->createToken("loginToken")->plainTextToken;
        
        return response()->json([
            'status' => 'error',
            'message' => 'Registration successful!',
            'token' => $token,
            'user' => $user,
            $request->all(),
        ], Response::HTTP_OK);
    }

    public function logout(Request $request){
        $user = $request->user();
        $user->currentAccessToken()->delete();
        
        return response()->json([
            'user' => $user,
            'status' => 'success',
            'message' => 'Logged out successfully',
        ], Response::HTTP_OK);
    }
}