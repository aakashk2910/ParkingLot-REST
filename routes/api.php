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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('login', 'API\UserController@login');
Route::post('register', 'API\UserController@register');
Route::group(['middleware' => 'auth:api'], function(){
    Route::post('user', 'API\UserController@details');

    Route::post('vehicle', 'API\ParkingLotController@addVehicle');
    Route::get('vehicle', 'API\ParkingLotController@getVehicle');
    Route::get('vehicle/{id}', 'API\ParkingLotController@getVehicleById');

    Route::post('vehicle/park/{vehicleId}/{lotId}', 'API\ParkingLotController@parkVehicle');
    Route::post('vehicle/depart/{vehicleId}', 'API\ParkingLotController@departVehicle');


    Route::get('parking-lot', 'API\ParkingLotController@getParkingLotInstance');
    Route::get('parking-lot/{id}', 'API\ParkingLotController@getParkingLotInstanceById');
});
