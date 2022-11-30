<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Throwable;

class AuthController extends Controller {

    public function login(Request $request){
        $user = User::where('email', $request->email)->get()->first();
        if(!$user || Hash::check($request->passowrd, $user->password)){
            return response()->json([
                'message' => 'Invalid credentials!'
            ], Response::HTTP_NOT_ACCEPTABLE);
        }
        $token = $user->createToken("loginToken")->plainTextToken;
        return response()->json([
            'user' => $user,
            'loginToken' => $token
        ], Response::HTTP_OK);
    }

    public function register(Request $request){
        try {
            $request->validate([
                'name' => 'required|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required',
            ]);
                        
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'admin' => false,
            ]);

            $token = $user->createToken("loginToken")->plainTextToken;
            return response()->json([
                'scucess' => true,
                'message' => 'Registration successful!',
                'token' => $token,
                'user' => $user,
                $request->all(),
            ], Response::HTTP_OK);

        } catch (Throwable $error) {
            return response()->json([
                'scucess' => false,
                'message' => 'Registration failed!',
                'error' => $error->errors(),
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}