<?php

use App\Models\Circle;
use App\Models\Package;
use App\Models\User;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     // return dd(Circle::all()->first()->users);
//     // return dd(Package::all()->last()->user);
//     return dd(User::where('id', 4)->get()->first()->packages);
// });

Route::get('/linkstorage', function () {
    Artisan::call('storage:link');
    return 'Storage directory linked';
});