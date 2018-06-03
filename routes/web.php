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

    Route::get('absensi/export', 'AbsensiController@export');
    Route::resource('absensi', 'AbsensiController')->except(['edit']);

    Route::get('backup/export', 'BackupController@export');
    Route::get('backup/import', 'BackupController@import');
    Route::resource('backup', 'BackupController')->except(['edit', 'create']);

    // Master data
    Route::resource('area', 'AreaController')->except(['edit', 'create']);

    Route::get('asset/generateQrCode/{asset}', 'AssetController@generateQrCode');
    Route::get('asset/generateQrCode', 'AssetController@generateQrCode');
    Route::get('asset/export', 'AssetController@export');
    Route::resource('asset', 'AssetController')->except(['edit', 'create']);

    Route::resource('assetLocation', 'AssetLocationController')->except(['edit', 'create']);
    Route::resource('assetStatus', 'AssetStatusController')->except(['edit', 'create']);
    Route::resource('subArea', 'SubAreaController')->only(['destroy']);
    Route::resource('authorization', 'AuthorizationController')->except(['edit', 'create']);
    Route::get('barge/getAnchored', 'BargeController@getAnchored');
    Route::get('barge/resume', 'BargeController@resume');
    Route::resource('barge', 'BargeController')->except(['edit', 'create']);
    Route::resource('breakdownCategory', 'BreakdownCategoryController')->except(['edit', 'create']);
    Route::resource('breakdownStatus', 'BreakdownStatusController')->except(['edit', 'create']);

    Route::get('breakdownPcr', 'BreakdownPcrController@index');
    Route::get('breakdownPcr/{breakdown}', 'BreakdownPcrController@show');
    Route::put('breakdownPcr/{breakdown}', 'BreakdownPcrController@update');

    Route::get('breakdown/export', 'BreakdownController@export');
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

    Route::get('dormitory/getAllData', 'DormitoryController@getAllData');
    Route::resource('dormitory', 'DormitoryController')->except(['edit', 'create']);

    Route::get('dormitoryRoom/getCurrentReservation/{dormitoryRoom}', 'DormitoryRoomController@getCurrentReservation');
    Route::resource('dormitoryRoom', 'DormitoryRoomController')->only(['show', 'destroy']);

    Route::get('dormitoryReservation/export', 'DormitoryReservationController@export');
    Route::get('dormitoryReservation/lewatMasaCuti', 'DormitoryReservationController@lewatMasaCuti');
    Route::resource('dormitoryReservation', 'DormitoryReservationController')->except(['edit', 'create']);

    Route::resource('egi', 'EgiController')->except(['edit', 'create']);

    Route::get('employee/generateNameTag/{employee}', 'EmployeeController@generateNameTag');
    Route::get('employee/generateNameTag', 'EmployeeController@generateNameTag');
    Route::get('employee/export', 'EmployeeController@export');
    Route::resource('employee', 'EmployeeController')->except(['edit', 'create']);

    Route::put('fatiqueApproval/{prajob}', 'FatiqueApprovalController@update');
    Route::get('fatiqueApproval', 'FatiqueApprovalController@index');

    Route::get('flowMeter/export', 'FlowMeterController@export');
    Route::resource('flowMeter', 'FlowMeterController')->except(['edit', 'create']);

    Route::get('fuelRefill/getLastRefill/{unit}', 'FuelRefillController@getLastRefill');
    Route::get('fuelRefill/downloadApp', 'FuelRefillController@downloadApp');
    Route::get('fuelRefill/export', 'FuelRefillController@export');
    Route::resource('fuelRefill', 'FuelRefillController')->except(['edit', 'create']);

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
    Route::resource('mealLocation', 'MealLocationController')->except(['edit', 'create']);
    Route::resource('office', 'OfficeController')->except(['edit', 'create']);
    Route::resource('owner', 'OwnerController')->except(['edit', 'create']);

    Route::resource('p2h', 'P2hController')->except(['edit', 'create']);

    Route::get('pitstop/export', 'PitstopController@export');
    Route::get('pitstop/achievementDailyCheck', 'PitstopController@achievementDailyCheck');
    Route::resource('pitstop', 'PitstopController')->except(['edit', 'create']);

    Route::resource('planCategory', 'PlanCategoryController')->except(['edit', 'create']);
    Route::resource('position', 'PositionController')->except(['edit', 'create']);
    Route::resource('problemProductivityCategory', 'ProblemProductivityCategoryController')->except(['edit', 'create']);

    Route::get('prajob/export', 'PrajobController@export');
    Route::resource('prajob', 'PrajobController')->except(['edit', 'create']);

    Route::resource('runningText', 'RunningTextController')->except(['edit', 'create']);
    Route::resource('sadp', 'SadpController')->except(['edit', 'create']);
    Route::resource('seam', 'SeamController')->except(['edit', 'create']);
    Route::resource('staffCategory', 'StaffCategoryController')->except(['edit', 'create']);
    Route::resource('stopWorkingPrediction', 'StopWorkingPredictionController')->except(['edit', 'create']);

    Route::get('sm/fuelConsumption', 'SmController@fuelConsumption');
    Route::get('sm/fuelRatio', 'SmController@fuelRatio');
    Route::get('sm/fuelStock', 'SmController@fuelStock');
    Route::get('sm', 'SmController@index');

    Route::resource('supervisingPrediction', 'SupervisingPredictionController')->except(['edit', 'create']);
    Route::resource('terminalAbsensi', 'TerminalAbsensiController')->except(['edit', 'create']);

    Route::resource('tugboat', 'TugboatController')->except(['edit', 'create']);

    Route::get('unit/remarkUnitByType', 'UnitController@remarkUnitByType');
    Route::get('unit/export', 'UnitController@export');
    Route::resource('unit', 'UnitController')->except(['edit', 'create']);

    Route::resource('unitCategory', 'UnitCategoryController')->except(['edit', 'create']);

    Route::get('user/getAuth/{user}', 'UserController@getAuth');
    Route::resource('user', 'UserController')->except(['edit', 'create']);

    Route::get('warningPart/export', 'WarningPartController@export');
    Route::resource('warningPart', 'WarningPartController')->only(['index', 'show', 'update']);

    Route::get('pasangSurut', 'OperationController@pasangSurut');
    Route::get('game', 'OperationController@game');
    Route::get('test', 'OperationController@test');

    Route::get('hcgs', 'HcgsController@index');
    Route::get('doUpdate', 'AdminController@doUpdate');
    Route::get('update', 'AdminController@update');

    // untuk ketinggian sungai
    Route::get('baseSurface', 'BaseSurfaceController@index');
    Route::get('transSurface', 'TransSurfaceController@index');
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
                'sm' => 'Dashboard',
                'flowMeter' => 'Flow Meter',
                'fuelRefill' => 'Fuel Refill',
                'fuelRestock' => 'Fuel Restock',
                'warningPart' => 'Warning Parts',
                '<i class="fa fa-database"></i> Master Data' => [
                    'fuelTank' => 'Fuel Tanks',
                    'sadp' => 'SADP',
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
                    'tugboat' => 'Tugboat',
                ]
            ]
        ],
        'HCGS' => [
            'icon' => 'users',
            'url' => [
                'hcgs' => 'Dashboard',
                'absensi' => 'Absensi',
                'asset' => 'Asset Management',
                'assetTaking' => 'Asset Taking',
                'cateringManagement' => 'Catering Management',
                'dormitoryReservation' => 'Dormitory Management',
                'fuelManagement' => 'Fuel Management',
                'p2h' => 'P2H',
                '<i class="fa fa-database"></i> Master Data' => [
                    // 'asset' => 'Asset',
                    'assetLocation' => 'Asset Location',
                    'assetStatus' => 'Asset Status',
                    'dormitory' => 'Dormitory',
                    'department' => 'Departments',
                    'employee' => 'Employees',
                    'jabatan' => 'Jabatan',
                    'mealLocation' => 'Meal Location',
                    'office' => 'Offices',
                    'position' => 'Positions',
                    'staffCategory' => 'Staff Categories',
                    'terminalAbsensi' => 'Terminal Absensi'
                ]
            ]
        ],
        'SHE' => [
            'icon' => 'medkit',
            'url' => [
                'prajob' => 'Pra Job & Fatique',
                'fatiqueApproval' => 'Fatique Approval',
                'operatorPerformance' => 'Operator Performance',
                '<i class="fa fa-database"></i> Master Data' => [
                    'stopWorkingPrediction' => 'Stop Working Predictions',
                    'supervisingPrediction' => 'Supervising Predictions',
                ]
            ]
        ],
        'FAT' => [
            'icon' => 'dollar',
            'url' => [
                'fat' => 'Dashboard',
                '<i class="fa fa-database"></i> Master Data' => [
                ]
            ]
        ],
        'ADMINISTRATION' => [
            'icon' => 'sliders',
            'url'=> [
                'user' => 'Users',
                'user/log' => 'User Logs',
                // 'authorization' => 'Authorization',
                // 'runningText' => 'Running Text',
                // todo
                'backup' => 'Backup & Restore',
                'update' => 'Update',
                'log' => 'Logs', // log error aplikasi & status pembenahan
                'setting' => 'Settings',
            ]
        ]
    ];

    $view->with('menus', $menus);
});
