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

});

// ga perlu auth
Route::get('runningText', 'Api\RunningTextController@index');

Route::get('ping', function() {
    return ['status' => true];
});

Route::get('employee', function() {
    return App\Employee::all();
});

Route::get('user', function() {
    return App\User::all();
});

Route::get('unit', function() {
    return App\Unit::all();
});

Route::get('fuelTank', function() {
    return App\FuelTank::all();
});

Route::get('fuelRefill', function() {
    return App\FuelRefill::orderBy('id', 'DESC')->limit(100)->get();
});

Route::post('fuelRefill', function() {
    $rows   = json_decode(request('rows'));
    $ids    = [];

    foreach($rows as $r)
    {
        $ids[] = $r->id;

        $data = [
            'date'              => $r->date,
            'shift'             => $r->shift,
            'fuel_tank_id'		=> $r->fuel_tank_id,
            'unit_id'           => $r->unit_id,
            'employee_id'       => $r->employee_id,
            'start_time'        => $r->start_time,
            'finish_time'       => $r->finish_time,
            'hm'                => $r->hm,
            'km'                => $r->km,
            'hm_last'           => $r->hm_last,
            'km_last'           => $r->km_last,
            'total_real'        => $r->total_real,
            'total_recommended' => $r->total_recommended,
            'user_id'      	    => $r->user_id,
            'insert_via'        => 'mobile'
        ];

        // check duplikasi
        $exists = App\FuelRefill::where($data)->first();

        if ($exists) {
            continue;
        }

        App\FuelRefill::insert($data);
    }

    $ret = (count($ids) > 0)
        ? ['ids' => implode(',', $ids), 'success' => true]
        : ['success' => false];

    return json_encode($ret);
});
