<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

$controller_path = 'App\Http\Controllers\Api';

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

Route::post('/auth/login', $controller_path . '\authentications\ApiAuthController@dologin')->name('api-auth-dologin');
//Route::middleware('auth:sanctum')->post('/auth/logout', $controller_path . '\authentications\ApiAuthController@logout')->name('api-auth-logout');
Route::post('/auth/logout', $controller_path . '\authentications\ApiAuthController@logout')->name('api-auth-logout');
