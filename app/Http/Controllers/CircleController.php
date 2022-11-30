<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use App\Models\Circle;
use Throwable;

class CircleController extends Controller {
    
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

}