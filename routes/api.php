<?php

use Illuminate\Http\Request;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(['middleware' => 'auth:api'], function() {
    Route::resource('employee', 'Api\EmployeeController')->except(['edit', 'create']);
    Route::resource('fuelTank', 'Api\FuelTankController')->except(['edit', 'create']);
    Route::resource('prajobs', 'Api\PrajobsController')->except(['edit', 'create']);
    Route::resource('unit', 'Api\UnitController')->except(['edit', 'create']);
    Route::resource('user', 'Api\UserController')->except(['edit', 'create']);
});
