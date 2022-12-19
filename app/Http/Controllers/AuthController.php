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
        if(!$user || !Hash::check($request->password, $user->password)){
            return response()->json([
                "status" => "error",
                "message" => "Invalid credentials"
            ], Response::HTTP_UNAUTHORIZED);
        }
        
        $token = $user->createToken("loginToken")->plainTextToken;
        return response()->json([
            'status' => 'success',
            'message' => 'Authentication successful!',
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
                'photo' => [
                    'required',
                    'image',
                    'mimes:jpeg,png,jpg,gif,svg',
                    'max:2048',
                ]
            ]);
        } catch (Throwable $error) {
            return response()->json([
                'status' => "error",
                'message' => 'Registration failed!',
                'error' => $error->errors(),
            ], Response::HTTP_BAD_REQUEST);
        }

        $image_path = $request->file('photo')->store('avatars', 'public');
        
        $user = User::create([
            'name' => $request->name,
            'telephone' => $request->telephone,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'photoPath' => $image_path,
            'admin' => false,
        ]);

        $token = $user->createToken("loginToken")->plainTextToken;
        
        return response()->json([
            'status' => 'success',
            'message' => 'Registration successful!',
            'token' => [
                'type' => 'Bearer',
                'value' => $token
            ],
            'user' => $user,
        ], Response::HTTP_OK);
    }

    public function edit(Request $request){
        try {
            
            if($request->photo){
                $request->validate([
                    'name' => 'required|max:255',
                    'email' => 'required|email',
                    'telephone' => 'required',
                    'photo' => [
                        'required',
                        'image',
                        'mimes:jpeg,png,jpg,gif,svg',
                        'max:2048',
                    ]
                ]);
                $image_path = $request->file('photo')->store('avatars', 'public');
    
                $user = User::where('id',$request->id)->update([
                    'name' => $request->name,
                    'telephone' => $request->telephone,
                    'email' => $request->email,
                    'photoPath' => $image_path,
                ]);
            }else{
                $request->validate([
                    'name' => 'required|max:255',
                    'email' => 'required|email',
                    'telephone' => 'required'
                ]);
                User::where('id',$request->id)->update([
                    'name' => $request->name,
                    'telephone' => $request->telephone,
                    'email' => $request->email,
                ]);
            }
            $user = User::where('id',$request->id)->first();
        } catch (Throwable $error) {
            return response()->json([
                'status' => "error",
                'message' => 'Update failed!',
                'error' => $error,
            ], Response::HTTP_BAD_REQUEST);
        }
        
        return response()->json([
            'status' => 'success',
            'message' => 'Update successful!',
            'token' => [
                'type' => 'Bearer',
                'value' => $request->token
            ],
            'user' => $user,
        ], Response::HTTP_OK);

    }

    public function logout(Request $request){
        auth()->user()->tokens()->delete();
        $user = $request->user();
        
        return response()->json([
            'user' => $user,
            'status' => 'success',
            'message' => 'Logged out successfully',
        ], Response::HTTP_OK);
    }

    public function verifySession(Request $request){
        return response()->json([
            'status' => 'success',
            'message' => 'Session is valid',
            'user' => $request->user(),
        ], Response::HTTP_OK);
    }

}