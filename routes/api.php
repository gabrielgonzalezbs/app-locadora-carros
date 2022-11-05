<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
Route::prefix('v1')->middleware('jwt.auth')->group(function () {

    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');

    Route::apiResource('automakers', 'AutomakerController');
    Route::apiResource('car-models', 'CarModelController');
    Route::apiResource('clients', 'ClientController');
    Route::apiResource('locations', 'LocationController');
    Route::apiResource('vehicles', 'VehicleController');

});

Route::post('login', 'AuthController@login');
Route::post('logout', 'AuthController@logout');
