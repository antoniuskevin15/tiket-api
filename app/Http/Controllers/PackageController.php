<?php

namespace App\Http\Controllers;

use App\Models\Package;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Throwable;

class PackageController extends Controller
{
    public function create(Request $request){
        try {
            $request->validate([
                'sender' => 'required',
                'expedition' => 'required',
                'resi' => 'required',
                'nomorKamar' => 'required',
                'photoURL' => 'required',
                'user_id' => 'required'
            ]);
        } catch(Throwable $error){
            return response()->json([
                'status' => "error",
                'message' => 'Package creation failed!',
                'error' => $error->errors(),
            ], Response::HTTP_BAD_REQUEST);
        }

        $package = Package::create([
            'sender' => $request->sender,
            'expedition' => $request->expedition,
            'resi' => $request->resi,
            'nomorKamar' => $request->nomorKamar,
            'photoURL' => $request->photoURL,
            'user_id' => $request->user_id
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Package created successfully',
            'package' => $package,
        ], Response::HTTP_OK);
    }
}
