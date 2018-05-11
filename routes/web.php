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
    Route::resource('area', 'AreaController')->except(['edit', 'create']);
    Route::resource('subArea', 'SubAreaController')->except(['edit', 'create']);
    Route::resource('authorization', 'AuthorizationController')->except(['edit', 'create']);
    Route::get('barge/getAnchored', 'BargeController@getAnchored');
    Route::get('barge/resume', 'BargeController@resume');
    Route::resource('barge', 'BargeController')->except(['edit', 'create']);
    Route::resource('breakdownCategory', 'BreakdownCategoryController')->except(['edit', 'create']);
    Route::resource('breakdownStatus', 'BreakdownStatusController')->except(['edit', 'create']);

    Route::get('breakdownPcr', 'BreakdownPcrController@index');
    Route::get('breakdownPcr/{breakdown}', 'BreakdownPcrController@show');
    Route::put('breakdownPcr/{breakdown}', 'BreakdownPcrController@update');

    Route::get('breakdown/getUnitReady', 'BreakdownController@getUnitReady');
    Route::resource('breakdown', 'BreakdownController')->except(['edit', 'create']);
    Route::resource('componentCriterias', 'ComponentCriteriaController')->except(['edit', 'create']);
    Route::resource('buyer', 'BuyerController')->except(['edit', 'create']);
    Route::resource('customer', 'CustomerController')->except(['edit', 'create']);
    Route::get('dailyCheckSetting/getData', 'DailyCheckSettingController@getData');
    Route::get('dailyCheckSetting/unScheduled', 'DailyCheckSettingController@unScheduled');
    Route::get('dailyCheckSetting/todayPlan', 'DailyCheckSettingController@todayPlan');
    Route::get('dailyCheckSetting/tomorrowPlan', 'DailyCheckSettingController@tomorrowPlan');
    Route::resource('dailyCheckSetting', 'DailyCheckSettingController')->except(['edit', 'create']);
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
    Route::get('leadTimeBreakdownUnit', 'LeadTimeBreakdownUnitController@index');
    Route::get('leadTimeDailyCheck', 'LeadTimeDailyCheckController@index');
    Route::resource('location', 'LocationController')->except(['edit', 'create']);
    Route::resource('lostTimeCategory', 'LostTimeCategoryController')->except(['edit', 'create']);
    Route::resource('material', 'MaterialController')->except(['edit', 'create']);
    Route::resource('office', 'OfficeController')->except(['edit', 'create']);
    Route::resource('owner', 'OwnerController')->except(['edit', 'create']);
    Route::get('pitstop/achievementDailyCheck', 'PitstopController@achievementDailyCheck');
    Route::resource('pitstop', 'PitstopController')->except(['edit', 'create']);
    Route::resource('planCategory', 'PlanCategoryController')->except(['edit', 'create']);
    Route::resource('position', 'PositionController')->except(['edit', 'create']);
    Route::resource('problemProductivityCategory', 'ProblemProductivityCategoryController')->except(['edit', 'create']);
    Route::resource('runningText', 'RunningTextController')->except(['edit', 'create']);
    Route::resource('seam', 'SeamController')->except(['edit', 'create']);
    Route::resource('staffCategory', 'StaffCategoryController')->except(['edit', 'create']);
    Route::resource('stopWorkingPrediction', 'StopWorkingPredictionController')->except(['edit', 'create']);
    Route::resource('supervisingPrediction', 'SupervisingPredictionController')->except(['edit', 'create']);
    Route::resource('terminalAbsensi', 'TerminalAbsensiController')->except(['edit', 'create']);
    Route::get('unit/remarkUnitByType', 'UnitController@remarkUnitByType');
    Route::resource('unit', 'UnitController')->except(['edit', 'create']);
    Route::resource('unitCategory', 'UnitCategoryController')->except(['edit', 'create']);
    Route::resource('user', 'UserController')->except(['edit', 'create']);
    // end of master data
    Route::get('pasangSurut', 'OperationController@pasangSurut');
    Route::get('game', 'OperationController@game');
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
                'leadTimeBreakdownUnit' => 'Lead Time B/D Unit',
                'leadTimeDailyCheck' => 'Lead Time Daily Check',
                'breakdownPcr' => 'Breakdown PCR',
                'pitstop' => 'Daily Check',
                '<i class="fa fa-database"></i> Master Data' => [
                    'breakdownStatus' => 'Breakdown Statuses',
                    'breakdownCategory' => 'Breakdown Categories',
                    'componentCriterias' => 'Component Criterias',
                    'dailyCheckSetting' => 'Daily Check Setting',
                    'egi' => 'EGI',
                    'location' => 'Locations',
                    'owner' => 'Unit Owners',
                    'unit' => 'Units',
                    'unitCategory' => 'Unit Categories',
                ]
            ]
        ],
        'SM' => [
            'icon' => 'map-marker',
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
                'breakdown' => 'Breakdown OCR',
                'stockBalanced' => 'Stock Balanced',
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
                    'area' => 'Area',
                    'barge' => 'Barges',
                    'buyer' => 'Buyers',
                    'customer' => 'Customers',
                    'jetty' => 'Jetties',
                    'lostTimeCategory' => 'Lost Time Categories',
                    'material' => 'Materials',
                    'planCategory' => 'Plan Category',
                    'problemProductivityCategory' => 'Problem Productivity Categories',
                    'seam' => 'Seam',
                    'subArea' => 'Sub Area',
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
        'ADMINISTRATION' => [
            'icon' => 'sliders',
            'url'=> [
                'user' => 'Users',
                'authorization' => 'Authorization',
                'runningText' => 'Running Text',
                // 'setting' => 'Settings',
            ]
        ]
    ];

    $view->with('menus', $menus);
});
