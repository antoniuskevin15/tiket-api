<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class CircleController extends Controller
{
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
}
