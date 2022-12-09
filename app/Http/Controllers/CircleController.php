<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use App\Models\Circle;
use App\Models\Package;
use Throwable;

class CircleController extends Controller {

    public function getAllCircles() {
        $circle = Circle::with('users')->get();
        foreach ($circle as $c) {
            $c->owner = $c->owner()->get()->first();
        }
        return response()->json([
            "status" => "success",
            "message" => "All circles",
            "circles" => [
                "total" => $circle->count(),
                "data" => $circle
            ]
        ], Response::HTTP_OK);
    }

    public function getCircleById($id) {
        $circle = Circle::with('users')->find($id);
        $circle->owner = $circle->owner()->get()->first();
        return response()->json([
            "status" => "success",
            "message" => "Circle by id",
            "data" => $circle,
        ], Response::HTTP_OK);
    }
    
    public function create(Request $request){
        try {
            $request->validate([
                'name' => 'required|max:255|unique:circles,name',
                'description' => 'required',
                'address' => 'required',
                'photo' => 'required',
            ]);
            $image_path = $request->file('photo')->store('circle', 'public');
        } catch(Throwable $error){
            return response()->json([
                'status' => "error",
                'message' => 'Circle creation failed!',
                'error' => $error->errors(),
            ], Response::HTTP_BAD_REQUEST);
        }

        $owner = $request->user();

        $circle = Circle::create([
            'name' => $request->name,
            'description' => $request->description,
            'address' => $request->address,
            'owner_id' => $owner->id,
            'photoURL' => $image_path
        ]);

        $circle->owner = $circle->owner()->get()->first();
        
        $user = $request->user();
        $user->update([
            'admin' => 1,
            'circle_id' => $circle->id
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Circle created successfully',
            'data' => $circle
        ], Response::HTTP_OK);
    }

    public function join(Request $request) {
        try {
            $request->validate([
                'circleId' => 'required|exists:circles,id',
            ]);
        } catch(Throwable $error){
            return response()->json([
                'status' => "error",
                'message' => 'User addition failed!',
                'error' => $error->errors(),
            ], Response::HTTP_BAD_REQUEST);
        }
        
        $user = $request->user();

        if($user->circle_id != null){
            return response()->json([
                'status' => "error",
                'message' => 'User already in a circle',
            ], Response::HTTP_BAD_REQUEST);
        } else if($user->admin_id){
            return response()->json([
                'status' => "error",
                'message' => 'User is an admin',
            ], Response::HTTP_BAD_REQUEST);
        }
        
        $user->update([
            'circle_id' => $request->circleId,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'User added successfully',
            'data' => $user,
        ], Response::HTTP_OK);
    }

    public function leave(Request $request){
        $user = $request->user();

        if($user->circle_id == null){
            return response()->json([
                'status' => 'error',
                'message' => 'User is not in any circle',
            ], Response::HTTP_BAD_REQUEST);
        }
        
        $user->update([
            'circle_id' => null,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'User removed successfully',
            'data' => $user,
        ], Response::HTTP_OK);
    }

}