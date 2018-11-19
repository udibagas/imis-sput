<?php

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

});

Route::get('ping', function() {
    return ['status' => true];
});

Route::get('area', 'Api\AreaController@index');
Route::resource('asset', 'Api\AssetController');
Route::get('assetLocation', 'Api\AssetLocationController@index');
Route::get('assetStatus', 'Api\AssetStatusController@index');
Route::get('assetCategory', 'Api\AssetCategoryController@index');
Route::get('assetVendor', 'Api\AssetVendorController@index');
Route::resource('assetTaking', 'Api\AssetTakingController');
Route::get('barge', 'Api\BargeController@index');
Route::get('customer', 'Api\CustomerController@index');
Route::get('contractor', 'Api\ContractorController@index');
Route::get('defaultMaterial', 'Api\DefaultMaterialController@index');
Route::get('dwellingTime', 'Api\DwellingTimeController@index');
Route::get('employee', 'Api\EmployeeController@index');
Route::get('fuelTank', 'Api\FuelTankController@index');
Route::resource('fuelRefill', 'Api\FuelRefillController')->only(['index', 'store']);
Route::get('jetty', 'Api\JettyController@index');
Route::get('seam', 'Api\SeamController@index');
Route::get('stockArea', 'Api\StockAreaController@index');
Route::resource('stockDumping', 'Api\StockDumpingController')->only(['index', 'store']);
Route::get('subcont', 'Api\SubcontController@index');
Route::get('subcontUnit', 'Api\SubcontUnitController@index');
Route::get('tugboat', 'Api\CustomerController@index');
Route::get('unit', 'Api\UnitController@index');
Route::get('user', 'Api\UserController@index');
Route::post('login', 'Api\UserController@login');
Route::post('absensi', 'Api\AbsensiController@store');
