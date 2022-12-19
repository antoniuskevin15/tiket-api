<?php

namespace App\Http\Controllers;

use App\Models\Circle;
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
    
    public function getPackageById($id) {
        $package = Package::where("id", $id)->get()->first();
        return response()->json([
            'status' => 'success',
            'message' => 'All packages',
            'packages' => $package
        ], Response::HTTP_OK);
    }

    public function getPackagesByCircle($id) {
        $users = Circle::where('id', $id)->first()->users;
        $i = 0;
        $packages = Package::where('user_id', null)->get();
        foreach($users as $user){
            $i++;
            $package = Package::where('user_id', $user->id)->get();
            $packages = $packages->merge($package);
        }
        
        return response()->json([
            'status' => 'success',
            'message' => 'All packages',
            'packages' => $packages
        ], Response::HTTP_OK);
    }

    public function getPackagesByUser($id) {
        $packages = Package::where('user_id', $id)->get();
        return response()->json([
            'status' => 'success',
            'message' => 'All packages',
            'packages' => $packages
        ], Response::HTTP_OK);
    }

    public function create(Request $request){
        try {
            $request->validate([
                'sender' => 'required',
                'expedition' => 'required',
                'receiptNumber' => 'required',
                'photo' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
                'user_id' => 'required'
            ]);
            $image_path = $request->file('photo')->store('packages', 'public');
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
            'receiptNumber' => $request->receiptNumber,
            'photoPath' => $image_path,
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
                'packageId' => 'required|exists:packages,id',
                'status' => 'required|in:finished,unknown',
                'userId' => 'required|exists:users,id',
            ]);
        } catch(Throwable $error){
            return response()->json([
                'status' => "error",
                'message' => 'Package update failed!',
                'error' => $error->errors(),
            ], Response::HTTP_BAD_REQUEST);
        }

        $package = Package::find($request->packageId)->load('user');
        
        $user = $request->user();
        if(!$user->admin && $user->id != $package->user->id && $package->status != 'unknown'){
            return response()->json([
                'status' => "error",
                'message' => 'Package update failed!',
                'error' => 'You are not allowed to do s',
            ], Response::HTTP_FORBIDDEN);
        }

        $package->update([
            'isTaken' => $request->status == 'unknown' ? false: true,
            'status' => $request->status,
            'user_id' => $request->userId,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Package updated successfully',
            'package' => $package,
        ], Response::HTTP_OK);
    }
}