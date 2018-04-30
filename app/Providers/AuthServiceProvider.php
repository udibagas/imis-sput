<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Area' => 'App\Policies\AreaPolicy',
        'App\Authorization' => 'App\Policies\AuthorizationPolicy',
        'App\Barge' => 'App\Policies\BargePolicy',
        'App\Breakdown' => 'App\Policies\BreakdownPolicy',
        'App\BreakdownCategory' => 'App\Policies\BreakdownCategoryPolicy',
        'App\BreakdownStatus' => 'App\Policies\BreakdownStatusPolicy',
        'App\Buyer' => 'App\Policies\BuyerPolicy',
        'App\ComponentCriteria' => 'App\Policies\ComponentCriteriaPolicy',
        'App\Customer' => 'App\Policies\CustomerPolicy',
        'App\Department' => 'App\Policies\DepartmentPolicy',
        'App\Egi' => 'App\Policies\EgiPolicy',
        'App\Employee' => 'App\Policies\EmployeePolicy',
        'App\FuelTank' => 'App\Policies\FuelTankPolicy',
        'App\Jabatan' => 'App\Policies\JabatanPolicy',
        'App\Jetty' => 'App\Policies\JettyPolicy',
        'App\Location' => 'App\Policies\LocationPolicy',
        'App\LostTimeCategory' => 'App\Policies\LostTimeCategoryPolicy',
        'App\Material' => 'App\Policies\MaterialPolicy',
        'App\Office' => 'App\Policies\OfficePolicy',
        'App\Owner' => 'App\Policies\OwnerPolicy',
        'App\Pitstop' => 'App\Policies\PitstopPolicy',
        'App\PlanCategory' => 'App\Policies\PlanCategoryPolicy',
        'App\Position' => 'App\Policies\PositionPolicy',
        'App\Prajob' => 'App\Policies\PrajobPolicy',
        'App\ProblemProductivityCategory' => 'App\Policies\ProblemProductivityCategoryPolicy',
        'App\RunningText' => 'App\Policies\RunningTextPolicy',
        'App\Seam' => 'App\Policies\SeamPolicy',
        'App\StaffCategory' => 'App\Policies\StaffCategoryPolicy',
        'App\StopWorkingPrediction' => 'App\Policies\StopWorkingPredictionPolicy',
        'App\SubArea' => 'App\Policies\SubAreaPolicy',
        'App\SupervisingPrediction' => 'App\Policies\SupervisingPredictionPolicy',
        'App\TerminalAbsensi' => 'App\Policies\TerminalAbsensiPolicy',
        'App\Unit' => 'App\Policies\UnitPolicy',
        'App\UnitCategory' => 'App\Policies\UnitCategoryPolicy',
        'App\User' => 'App\Policies\UserPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
