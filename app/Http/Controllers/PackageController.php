<?php

namespace App\Http\Controllers;

use App\Models\Package;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Throwable;

class PackageController extends Controller {

    public function getAllPackages() {
        $packages = Package::with('user')->get();
        return response()->json([
            'status' => 'success',
            'message' => 'All packages',
            'packages' => [
                'total' => $packages->count(),
                'data' => $packages
            ]
        ], Response::HTTP_OK);
    }

    public function create(Request $request){
        try {
            $request->validate([
                'sender' => 'required',
                'expedition' => 'required',
                'resi' => 'required',
                'nomorKamar' => 'required',
                'photoURL' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
                'user_id' => 'required'
            ]);
            $image_path = $request->file('photoURL')->store('photoURL', 'public');
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
            'photoURL' => $image_path,
            'user_id' => $request->user_id
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Package created successfully',
            'package' => $package,
        ], Response::HTTP_OK);
    }

    public function toggleIsTaken(Request $request){
        try {
            $request->validate([
                'packageId' => 'required',
            ]);
        } catch(Throwable $error){
            return response()->json([
                'status' => "error",
                'message' => 'Package update failed!',
                'error' => $error->errors(),
            ], Response::HTTP_BAD_REQUEST);
        }

        $package = Package::find($request->id);
        
        $user = $request->user();
        if(!$user->admin || $user->circle_id != $package->user->circle_id){
            return response()->json([
                'status' => "error",
                'message' => 'Package update failed!',
                'error' => 'You are not an admin',
            ], Response::HTTP_FORBIDDEN);
        }

        $package->update([
            'isTaken' => !$package->isTaken,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Package updated successfully',
            'package' => $package,
        ], Response::HTTP_OK);
    }
}