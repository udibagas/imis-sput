<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Authorization;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Absensi' => 'App\Policies\AbsensiPolicy',
        'App\Area' => 'App\Policies\AreaPolicy',
        'App\Asset' => 'App\Policies\AssetPolicy',
        'App\AssetLocation' => 'App\Policies\AssetLocationPolicy',
        'App\AssetStatus' => 'App\Policies\AssetStatusPolicy',
        'App\AssetTaking' => 'App\Policies\AssetTakingPolicy',
        'App\Authorization' => 'App\Policies\AuthorizationPolicy',
        'App\Barge' => 'App\Policies\BargePolicy',
        'App\Breakdown' => 'App\Policies\BreakdownPolicy',
        'App\BreakdownCategory' => 'App\Policies\BreakdownCategoryPolicy',
        'App\BreakdownStatus' => 'App\Policies\BreakdownStatusPolicy',
        'App\Buyer' => 'App\Policies\BuyerPolicy',
        'App\ComponentCriteria' => 'App\Policies\ComponentCriteriaPolicy',
        'App\Customer' => 'App\Policies\CustomerPolicy',
        'App\DailyCheckSetting' => 'App\Policies\DailyCheckSettingPolicy',
        'App\Department' => 'App\Policies\DepartmentPolicy',
        'App\Dormitory' => 'App\Policies\DormitoryPolicy',
        'App\DormitoryReservation' => 'App\Policies\DormitoryReservationPolicy',
        'App\Egi' => 'App\Policies\EgiPolicy',
        'App\Employee' => 'App\Policies\EmployeePolicy',
        'App\FuelTank' => 'App\Policies\FuelTankPolicy',
        'App\FuelTankTera' => 'App\Policies\FuelTankTeraPolicy',
        'App\FlowMeter' => 'App\Policies\FlowMeterPolicy',
        'App\FuelRefill' => 'App\Policies\FuelRefillPolicy',
        // 'App\Jabatan' => 'App\Policies\JabatanPolicy',
        'App\Jetty' => 'App\Policies\JettyPolicy',
        'App\Location' => 'App\Policies\LocationPolicy',
        'App\LostTimeCategory' => 'App\Policies\LostTimeCategoryPolicy',
        'App\Material' => 'App\Policies\MaterialPolicy',
        'App\Meal' => 'App\Policies\MealPolicy',
        'App\MealLocation' => 'App\Policies\MealLocationPolicy',
        'App\Office' => 'App\Policies\OfficePolicy',
        'App\Owner' => 'App\Policies\OwnerPolicy',
        'App\Pitstop' => 'App\Policies\PitstopPolicy',
        'App\PlanCategory' => 'App\Policies\PlanCategoryPolicy',
        'App\Position' => 'App\Policies\PositionPolicy',
        'App\Prajob' => 'App\Policies\PrajobPolicy',
        'App\ProblemProductivityCategory' => 'App\Policies\ProblemProductivityCategoryPolicy',
        'App\ProductivityPlan' => 'App\Policies\ProductivityPlanPolicy',
        'App\RunningText' => 'App\Policies\RunningTextPolicy',
        'App\Sadp' => 'App\Policies\SadpPolicy',
        'App\Seam' => 'App\Policies\SeamPolicy',
        'App\StaffCategory' => 'App\Policies\StaffCategoryPolicy',
        'App\StopWorkingPrediction' => 'App\Policies\StopWorkingPredictionPolicy',
        'App\StockArea' => 'App\Policies\JettyPolicy',
        'App\SubArea' => 'App\Policies\AreaPolicy',
        'App\SupervisingPrediction' => 'App\Policies\SupervisingPredictionPolicy',
        'App\TerminalAbsensi' => 'App\Policies\TerminalAbsensiPolicy',
        'App\Tugboat' => 'App\Policies\TugboatPolicy',
        'App\Unit' => 'App\Policies\UnitPolicy',
        'App\UnitCategory' => 'App\Policies\UnitCategoryPolicy',
        'App\UnitActivity' => 'App\Policies\UnitActivityPolicy',
        'App\User' => 'App\Policies\UserPolicy',
        'App\WarningPart' => 'App\Policies\WarningPartPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::before(function ($user, $ability) {
            if ($user->super_admin) {
                return true;
            }
        });

        // Register controller yang bukan resource disini
        Gate::define('view-leadtime-breakdown-unit', function($user) {
            return Authorization::where('controller', 'LeadTimeBreakdownUnit')
                ->where('user_id', $user->id)
                ->where('view', 1)->count();
        });

        Gate::define('view-leadtime-daily-check', function($user) {
            return Authorization::where('controller', 'LeadTimeDailyCheck')
                ->where('user_id', $user->id)
                ->where('view', 1)->count();
        });

        Gate::define('view-breakdown-pcr', function($user) {
            return Authorization::where('controller', 'BreakdownPcr')
                ->where('user_id', $user->id)
                ->where('view', 1)->count();
        });

        Gate::define('update-breakdown-pcr', function($user) {
            return Authorization::where('controller', 'BreakdownPcr')
                ->where('user_id', $user->id)
                ->where('update', 1)->count();
        });

        Gate::define('view-hcgs', function($user) {
            return Authorization::where('controller', 'Hcgs')
                ->where('user_id', $user->id)
                ->where('view', 1)->count();
        });

        Gate::define('view-backup', function($user) {
            return Authorization::where('controller', 'Backup')
                ->where('user_id', $user->id)
                ->where('view', 1)->count();
        });

        Gate::define('export-backup', function($user) {
            return Authorization::where('controller', 'Backup')
                ->where('user_id', $user->id)
                ->where('export', 1)->count();
        });

        Gate::define('import-backup', function($user) {
            return Authorization::where('controller', 'Backup')
                ->where('user_id', $user->id)
                ->where('import', 1)->count();
        });

        Gate::define('create-backup', function($user) {
            return Authorization::where('controller', 'Backup')
                ->where('user_id', $user->id)
                ->where('create', 1)->count();
        });

        Gate::define('delete-backup', function($user) {
            return Authorization::where('controller', 'Backup')
                ->where('user_id', $user->id)
                ->where('delete', 1)->count();
        });
    }
}
