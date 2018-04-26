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
    Route::resource('alocation', 'AlocationController')->except(['edit', 'create']);
    Route::resource('authorization', 'AuthorizationController')->except(['edit', 'create']);
    Route::resource('bagian', 'BagianController')->except(['edit', 'create']);
    Route::get('barge/getAnchored', 'BargeController@getAnchored');
    Route::get('barge/resume', 'BargeController@resume');
    Route::resource('barge', 'BargeController')->except(['edit', 'create']);
    Route::resource('breakdownCategory', 'BreakdownCategoryController')->except(['edit', 'create']);
    Route::resource('breakdownStatus', 'BreakdownStatusController')->except(['edit', 'create']);
    Route::resource('breakdown', 'BreakdownController')->except(['edit', 'create']);
    Route::resource('componentCriterias', 'ComponentCriteriaController')->except(['edit', 'create']);
    Route::resource('buyer', 'BuyerController')->except(['edit', 'create']);
    Route::resource('cargo', 'CargoController')->except(['edit', 'create']);
    Route::resource('customer', 'CustomerController')->except(['edit', 'create']);
    Route::resource('department', 'DepartmentController')->except(['edit', 'create']);
    Route::resource('egi', 'EgiController')->except(['edit', 'create']);
    Route::resource('employee', 'EmployeeController')->except(['edit', 'create']);
    Route::get('fuelTank/ratio', 'FuelTankController@ratio');
    Route::get('fuelTank/dashboard', 'FuelTankController@dashboard');
    Route::resource('fuelTank', 'FuelTankController')->except(['edit', 'create']);
    Route::resource('jabatan', 'JabatanController')->except(['edit', 'create']);
    Route::get('jetty/productivity', 'JettyController@productivity');
    Route::get('jetty/dwellingTime', 'JettyController@dwellingTime');
    Route::resource('jetty', 'JettyController')->except(['edit', 'create']);
    Route::resource('location', 'LocationController')->except(['edit', 'create']);
    Route::resource('lostTimeCategory', 'LostTimeCategoryController')->except(['edit', 'create']);
    Route::resource('material', 'MaterialController')->except(['edit', 'create']);
    Route::resource('office', 'OfficeController')->except(['edit', 'create']);
    Route::resource('owner', 'OwnerController')->except(['edit', 'create']);
    Route::resource('pitstop', 'PitstopController')->except(['edit', 'create']);
    Route::resource('planCategory', 'PlanCategoryController')->except(['edit', 'create']);
    Route::resource('position', 'PositionController')->except(['edit', 'create']);
    Route::resource('problemProductivityCategory', 'ProblemProductivityCategoryController')->except(['edit', 'create']);
    Route::resource('staffCategory', 'StaffCategoryController')->except(['edit', 'create']);
    Route::resource('stopWorkingPrediction', 'StopWorkingPredictionController')->except(['edit', 'create']);
    Route::resource('station', 'StationController')->except(['edit', 'create']);
    Route::resource('subUnit', 'SubUnitController')->except(['edit', 'create']);
    Route::resource('supervisingPrediction', 'SupervisingPredictionController')->except(['edit', 'create']);
    Route::resource('terminalAbsensi', 'TerminalAbsensiController')->except(['edit', 'create']);
    Route::resource('unit', 'UnitController')->except(['edit', 'create']);
    Route::resource('unitCategory', 'UnitCategoryController')->except(['edit', 'create']);
    Route::resource('user', 'UserController')->except(['edit', 'create']);
    // end of master data
    Route::get('pasangSurut', 'OperationController@pasangSurut');
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
                    'componentCriterias' => 'Component Criterias',
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
                'pasangSurut' => 'Hourly Monitoring Barging',
                // 'Hourly Monitoring Barging' => [
                //     'stockBalanced' => 'Stock Balanced',
                //     'anchoredBarge' => 'Anchored Barge',
                // ],
                'Status Jetty' => [
                    'jetty/dwellingTime' => 'Dwelling Time',
                    'barge/resume' => 'Resume Barging Daily',
                    'jetty/productivity' => 'Productivity Jetty'
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
                'authorization' => 'Authorization',
                // 'setting' => 'Settings',
            ]
        ]
    ];

    $view->with('menus', $menus);
});
