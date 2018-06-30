<?php

use Illuminate\Http\Request;
use Carbon\Carbon;

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

Route::resource('assetTaking', 'Api\AssetTakingController');

Route::get('asset', function() {
    return App\Asset::orderBy('reg_no', 'ASC')->get();
});

Route::get('assetLocation', function() {
    return App\AssetLocation::orderBy('name', 'ASC')->get();
});

Route::get('assetStatus', function() {
    return App\AssetStatus::orderBy('code', 'ASC')->get();
});

Route::get('ping', function() {
    return ['status' => true];
});

Route::get('employee', function() {
    return App\Employee::all();
});

Route::get('user', function() {
    return App\User::all()->makeVisible('password');
});

Route::get('unit', function() {
    return App\Unit::all();
});

Route::get('fuelTank', function() {
    return App\FuelTank::all();
});

Route::get('fuelRefill', function() {
    return App\FuelRefill::selectRaw('
        fuel_refills.*, units.name AS unit,
        employees.name AS operator
    ')
    ->join('units', 'units.id', '=', 'fuel_refills.unit_id')
    ->join('employees', 'employees.id', '=', 'fuel_refills.employee_id')
    ->when(request('fuel_tank_id'), function($query) {
        return $query->where('fuel_tank_id', request('fuel_tank_id'));
    })
    ->when(request('date'), function($query) {
        return $query->where('date', request('date'));
    })
    ->orderBy('id', 'DESC')->limit(100)->get();
});

Route::post('login', function() {
    $user = App\User::where('email', 'LIKE', request('email'))->first();

    if ($user && password_verify(request('password'), $user->password)) {
        return $user;
    }

    return null;
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
            'hm_last'           => $r->hm_last ? $r->hm_last : 0,
            'km_last'           => $r->km_last ? $r->km_last : 0,
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

        $fuelRefill = App\FuelRefill::insert($data);

        // update stock fuel tank
        $fuelRefill->fuelTank->update([
            'stock' => $fuelRefill->fuelTank->stock - $request->total_real,
            'last_stock_time' => Carbon::now()
        ]);
    }

    $ret = (count($ids) > 0)
        ? ['ids' => implode(',', $ids), 'success' => true]
        : ['success' => false];

    return json_encode($ret);
});

// untuk game operational

Route::get('area', function() {
    return App\Area::with('subArea')->get();
});

Route::get('barge', function() {
    return App\Barge::all();
});

Route::get('customer', function() {
    return App\Customer::all();
});

Route::get('jetty', function() {
    return App\Jetty::orderBy('order', 'ASC')->get();
});

Route::get('seam', function() {
    return App\Seam::all();
});

Route::get('tugboat', function() {
    return App\Tugboat::all();
});
