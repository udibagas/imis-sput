<?php

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

Auth::routes();

Route::group(['middleware' => 'auth'], function() {
    Route::get('/', 'HomeController@index')->name('home');
    Route::get('/home', 'HomeController@index')->name('home');
    // Master data
    Route::resource('alocation', 'AlocationController');
    Route::resource('bagian', 'BagianController');
    Route::resource('barge', 'BargeController');
    Route::resource('breakdownCategory', 'BreakdownCategoryController');
    Route::resource('breakdownStatus', 'BreakdownStatusController');
    Route::resource('breakdown', 'BreakdownController');
    Route::resource('buyer', 'BuyerController');
    Route::resource('cargo', 'CargoController');
    Route::resource('componentCriteria', 'ComponentCriteriaController');
    Route::resource('customer', 'CustomerController');
    Route::resource('department', 'DepartmentController');
    Route::resource('egi', 'EgiController');
    Route::resource('employee', 'EmployeeController');
    Route::get('fuelTank/dashboard', 'FuelTankController@dashboard');
    Route::resource('fuelTank', 'FuelTankController');
    Route::resource('jabatan', 'JabatanController');
    Route::resource('jetty', 'JettyController');
    Route::resource('location', 'LocationController');
    Route::resource('lostTimeCategory', 'LostTimeCategoryController');
    Route::resource('material', 'MaterialController');
    Route::resource('office', 'OfficeController');
    Route::resource('owner', 'OwnerController');
    Route::resource('pitstop', 'PitstopController');
    Route::resource('planCategory', 'PlanCategoryController');
    Route::resource('position', 'PositionController');
    Route::resource('problemProductivityCategory', 'ProblemProductivityCategoryController');
    Route::resource('staffCategory', 'StaffCategoryController');
    Route::resource('stopWorkingPrediction', 'StopWorkingPredictionController');
    Route::resource('station', 'StationController');
    Route::resource('subUnit', 'SubUnitController');
    Route::resource('supervisingPrediction', 'SupervisingPredictionController');
    Route::resource('unit', 'UnitController');
    Route::resource('unitCategory', 'UnitCategoryController');
    Route::resource('user', 'UserController');
    // end of master data
    Route::get('pasangSurut', 'OperationController@pasangSurut');
    Route::get('productivityJetty', 'OperationController@productivityJetty');
});

View::composer('layouts._sidebar', function($view) {
    $menus = [
        'DASHBOARD' => [
            'icon' => 'dashboard',
            'url' => '/'
        ],
        'PLANT' => [
            'icon' => 'wrench',
            'url' => [
                'plant/dashboard' => 'Dashboard',
                'breakdown/leadTimeBreakdownUnit' => 'Leadtime B/D Unit',
                'breakdown/leadTimeDailyCheck' => 'Leadtime Daily Check',
                'breakdown' => 'Workshop',
                'breakdown/pcr' => 'Breakdown PCR',
                'pitstop' => 'Pitstop',
                '<i class="fa fa-database"></i> Master Data' => [
                    'alocation' => 'Alocations',
                    'bagian' => 'Bagian',
                    'breakdownStatus' => 'Breakdown Statuses',
                    'breakdownCategory' => 'Breakdown Categories',
                    'componentCriteria' => 'Component Criterias',
                    'egi' => 'EGI',
                    'location' => 'Locations',
                    'material' => 'Materials',
                    'station' => 'Stations',
                    'unit' => 'Units',
                    'unitCategory' => 'Unit Categories',
                ]
            ]
        ],
        'SM' => [
            'icon' => 'industry',
            'url' => [
                'fuelTank/dashboard' => 'Dashboard',
                'pengisianSolar' => 'Pengisian Solar',
                'flowMeter' => 'Flow Meter',
                '<i class="fa fa-database"></i> Master Data' => [
                    'fuelTank' => 'Fuel Tanks',
                ]
            ]
        ],
        'OPERATION' => [
            'icon' => 'cogs',
            'url' => [
                'operation/dashboard' => 'Dashboard',
                'Hourly Monitoring Barging' => [
                    'stockBalanced' => 'Stock Balanced',
                    'anchoredBarge' => 'Anchored Barge',
                    'pasangSurut' => 'Prediksi Pasang Surut',

                ],
                'Status Jetty' => [
                    'dwellingTime' => 'Dwelling Time',
                    'resumeBargingDaily' => 'Resume Barging Daily',
                    'productivityJetty' => 'Productivity Jetty'
                ],
                '<i class="fa fa-database"></i> Master Data' => [
                    'barge' => 'Barges',
                    'buyer' => 'Buyers',
                    'cargo' => 'Cargos',
                    'customer' => 'Customers',
                    'jetty' => 'Jetties',
                    'lostTimeCategory' => 'Lost Time Categories',
                    'planCategory' => 'Plan Category',
                    'problemProductivityCategory' => 'Problem Productivity Categories',
                ]
            ]
        ],
        'HCGS' => [
            'icon' => 'users',
            'url' => [
                'hcgs/dashboard' => 'Dashboard',
                'absen' => 'Absensi',
                'praJob' => 'Pra Job & Fatique',
                'prajob/approval' => 'Fatique Approval',
                '<i class="fa fa-database"></i> Master Data' => [
                    'department' => 'Departments',
                    'employee' => 'Employees',
                    'jabatan' => 'Jabatan',
                    'office' => 'Offices',
                    'owner' => 'Owners',
                    'position' => 'Positions',
                    'stopWorkingPrediction' => 'Stop Working Predictions',
                    'supervisingPrediction' => 'Supervising Predictions',
                    'staffCategory' => 'Staff Categories',
                    'terminalAbsensi' => 'Terminal Absensi'
                ]
            ]
        ],
        'SHE' => [
            'icon' => 'medkit',
            'url' => [
                'operatorPerformance' => 'Operator Performance'
            ]
        ],
        // Shared Master Data
        // 'MASTER DATA' => [
        //     'icon' => 'database',
        //     'url' => [
        //
        //     ]
        // ],
        'ADMINISTRATION' => [
            'icon' => 'sliders',
            'url'=> [
                'user' => 'Users',
                'setting' => 'Settings',
            ]
        ]
    ];

    $view->with('menus', $menus);
});
