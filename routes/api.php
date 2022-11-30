<?php

use App\Http\Controllers\CircleController;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get("/", function (Request $request) {
    return response()->json([
        "message" => "Welcome to the API!"
    ], Response::HTTP_OK);
});

Route::controller(AuthController::class)->group(function(){
    Route::post('/user/login', 'login');
    Route::post('/user/register', 'register');
});