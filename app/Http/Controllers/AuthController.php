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
                'telephone' => 'required|unique:users,telephone',
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
            'telephone' => $request->telephone,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'admin' => false,
        ]);

        $token = $user->createToken("loginToken")->plainTextToken;
        
        return response()->json([
            'status' => 'error',
            'message' => 'Registration successful!',
            'token' => [
                'type' => 'Bearer',
                'value' => $token
            ],
            'user' => $user,
        ], Response::HTTP_OK);
    }

    public function logout(Request $request){
        auth()->user()->tokens()->delete();
        $user = $request->user();
        $user->currentAccessToken()->delete();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return response()->json([
            'user' => $user,
            'status' => 'success',
            'message' => 'Logged out successfully',
        ], Response::HTTP_OK);
    }
}