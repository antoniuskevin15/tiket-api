<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use App\Models\Circle;
use Throwable;

class CircleController extends Controller {

    public function getAllCircles() {
        $circle = Circle::with('users', 'users.packages')->get();
        return response()->json([
            "status" => "success",
            "message" => "All circles",
            "data" => $circle
        ], Response::HTTP_OK);
    }

    public function getCircleById($id) {
        $circle = Circle::with('users', 'users.packages')->find($id);
        return response()->json([
            "status" => "success",
            "message" => "Circle by id",
            "data" => $circle
        ], Response::HTTP_OK);
    }
    
    public function create(Request $request){
        try {
            $request->validate([
                'name' => 'required|max:255|unique:circles,name',
                'description' => 'required',
                'address' => 'required',
            ]);
        } catch(Throwable $error){
            return response()->json([
                'status' => "error",
                'message' => 'Circle creation failed!',
                'error' => $error->errors(),
            ], Response::HTTP_BAD_REQUEST);
        }

        $circle = Circle::create([
            'name' => $request->name,
            'description' => $request->description,
            'address' => $request->address,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Circle created successfully',
            'circle' => $circle,
        ], Response::HTTP_OK);
    }

    public function addUser(Request $request) {
        try {
            $request->validate([
                'circle_id' => 'required|exists:circles,id',
                'user_id' => 'required|exists:users,id',
            ]);
        } catch(Throwable $error){
            return response()->json([
                'status' => "error",
                'message' => 'User addition failed!',
                'error' => $error->errors(),
            ], Response::HTTP_BAD_REQUEST);
        }

        $circle = Circle::find($request->circle_id);
        $user = User::find($request->user_id);

        $circle->users()->attach($user);

        return response()->json([
            'status' => 'success',
            'message' => 'User added successfully',
            'circle' => $circle,
        ], Response::HTTP_OK);
    }

}