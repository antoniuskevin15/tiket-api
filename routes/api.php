<?php

use App\Http\Controllers\CircleController;
use App\Http\Controllers\PackageController;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Middleware\Cors;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// }); 

Route::get("/", function (Request $request) {
    return response()->json([
        "status" => "success",
        "message" => "Welcome to the API!"
    ], Response::HTTP_OK);
});

    
Route::controller(AuthController::class)->group(function(){
    Route::post('/user/login', 'login');
    Route::post('/user/register', 'register');
});

Route::middleware('auth:sanctum')->post('/user/logout', [AuthController::class, 'logout']);

Route::middleware('auth:sanctum')->controller(CircleController::class)->group(function(){
    Route::get('/circle', 'getAllCircles');
    Route::get('/circle/{id}', 'getCircleById');
    Route::post('/circle/create', 'create');
    Route::post('/circle/join', 'join');
    Route::post('/circle/leave', 'leave');
});

Route::middleware('auth:sanctum')->controller(PackageController::class)->group(function(){
    Route::get('/package', 'getAllPackages');
    Route::get('/package/{id}', 'getPackageById');
    Route::get('/package/circle/{id}', 'getPackagesByCircle');
    Route::get('/package/user/{id}', 'getPackagesByUser');
    Route::post('/package/create', 'create');
    Route::post('/package/toggle', 'toggleIsTaken');
});