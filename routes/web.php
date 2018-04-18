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
    Route::resource('breakdownCategory', 'BreakdownCategoryController');
    Route::resource('breakdownStatus', 'BreakdownStatusController');
    Route::resource('breakdown', 'BreakdownController');
    Route::resource('componentCriteria', 'ComponentCriteriaController');
    Route::resource('department', 'DepartmentController');
    Route::resource('egi', 'EgiController');
    Route::resource('employee', 'EmployeeController');
    Route::get('fuelTank/dashboard', 'FuelTankController@dashboard');
    Route::resource('fuelTank', 'FuelTankController');
    Route::resource('jabatan', 'JabatanController');
    Route::resource('location', 'LocationController');
    Route::resource('lostTimeCategory', 'LostTimeCategoryController');
    Route::resource('material', 'MaterialController');
    Route::resource('office', 'OfficeController');
    Route::resource('owner', 'OwnerController');
    Route::resource('planCategory', 'PlanCategoryController');
    Route::resource('position', 'PositionController');
    Route::resource('problemProductivityCategory', 'ProblemProductivityCategoryController');
    Route::resource('staffCategory', 'StaffCategoryController');
    Route::resource('stopWorkingPrediction', 'StopWorkingPredictionController');
    Route::resource('subUnit', 'SubUnitController');
    Route::resource('supervisingPrediction', 'SupervisingPredictionController');
    Route::resource('unit', 'UnitController');
    Route::resource('unitCategory', 'UnitCategoryController');
    Route::resource('user', 'UserController');
    // end of master data
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
                // master data
                'alocation' => 'Alocation',
                'breakdownStatus' => 'Breakdown Status',
                'breakdownCategory' => 'Breakdown Category',
                'componentCriteria' => 'Component Criteria',
                'egi' => 'EGI',
                'location' => 'Location',
                'material' => 'Material',
                'unit' => 'Unit',
                'unitCategory' => 'Unit Category',
            ]
        ],
        'SM' => [
            'icon' => 'industry',
            'url' => [
                'fuelTank/dashboard' => 'Dashboard',
                'pengisianSolar' => 'Pengisian Solar',
                'flowMeter' => 'Flow Meter',
                // master data
                'fuelTank' => 'Fuel Tank',
            ]
        ],
        'OPERATION' => [
            'icon' => 'cogs',
            'url' => [
                'operation/dashboard' => 'Dashboard',
                // master data
                'lostTimeCategory' => 'Lost Time Category',
                'planCategory' => 'Plan Category',
                'problemProductivityCategory' => 'Problem Productivity Category',
            ]
        ],
        'HCGS' => [
            'icon' => 'users',
            'url' => [
                'hcgs/dashboard' => 'Dashboard',
                'absen' => 'Absensi',
                'praJob' => 'Pra Job & Fatique',
                'prajob/approval' => 'Fatique Approval',
                // master data
                'bagian' => 'Bagian',
                'department' => 'Department',
                'employee' => 'Employee',
                'jabatan' => 'Jabatan',
                'office' => 'Office',
                'owner' => 'Owner',
                'position' => 'Position',
                'stopWorkingPrediction' => 'Stop Working Prediction',
                'supervisingPrediction' => 'Supervising Prediction',
                'staffCategory' => 'Staff Category',
                'terminalAbsensi' => 'Terminal Absensi'
            ]
        ],
        // 'MASTER DATA' => [
        //     'icon' => 'database',
        //     'url' => '#'
        // ],
        // 'Equipment & Material' => [
        //     'icon' => 'cubes',
        //     'url' => [
        //
        //     ]
        // ],
        // 'Unit/Sections' => [
        //     'icon' => 'bars',
        //     'url' => [
        //
        //     ]
        // ],
        // 'Statuses & Categories' => [
        //     'icon' => 'list',
        //     'url' => [
        //
        //     ]
        // ],
        'Auth' => [
            'icon' => 'lock',
            'url'=> [
                'user' => 'User',
            ]
        ]
    ];

    $view->with('menus', $menus);
});
