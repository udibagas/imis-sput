<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Authorization extends Model
{
    protected $fillable = [
        'controller', 'create', 'update', 'delete',
        'export', 'import', 'view', 'user_id'
    ];

    public static function getModule()
    {
        return [
            [
                'id' => 'plant',
                'text' => 'Plant',
                'children' => [
                    ['id' => 'LeadTimeBreakdownUnit', 'text' => 'Lead Time B/D Unit'],
                    ['id' => 'LeadTimeDailyCheck', 'text' => 'Lead Time Daily Check'],
                    ['id' => 'BreakdownPcr', 'text' => 'Breakdown PCR'],
                    ['id' => 'Pitstop', 'text' => 'Daily Check'],
                ]
            ], [
                'id' => 'plant>master_data',
                'text' => 'Plant > Master Data',
                'children' => [
                    ['id' => 'BreakdownStatus', 'text' => 'Breakdown Statuses'],
                    ['id' => 'BreakdownCategory', 'text' => 'Breakdown Categories'],
                    ['id' => 'ComponentCriteria', 'text' => 'Component Criteria'],
                    ['id' => 'DailyCheckSetting', 'text' => 'Daily Check Setting'],
                    ['id' => 'Egi', 'text' => 'EGI'],
                    ['id' => 'Location', 'text' => 'Locations'],
                    ['id' => 'Owner', 'text' => 'Unit Owner'],
                    ['id' => 'Unit', 'text' => 'Units'],
                    ['id' => 'UnitCategory', 'text' => 'Unit Categories'],
                ]
            ], [
                'id' => 'sm',
                'text' => 'SM',
                'children' => [
                    ['id' => 'Sm', 'text' => 'Dashboard'],
                    ['id' => 'FlowMeter', 'text' => 'Flow Meter'],
                    ['id' => 'FuelRefill', 'text' => 'Fuel Refill'],
                    ['id' => 'WarningPart', 'text' => 'Warning Part'],
                ]
            ], [
                'id' => 'sm>master_data',
                'text' => 'SM > Master Data',
                'children' =>[
                    ['id' => 'FuelTank', 'text' => 'Fuel Tanks'],
                ]
            ], [
                'id' => 'operation',
                'text' => 'Operation',
                'children' => [
                    ['id' => 'Breakdown', 'text' => 'Breakdown OCR'],
                    ['id' => 'StockBalanced', 'text' => 'Stock Balanced'],
                    ['id' => 'HourlyMonitoringBarging', 'text' => 'Hourly Monitoring Barging'],
                ]
            ], [
                'id' => 'operation>master_data',
                'text' => 'Operation > Master Data',
                'children' => [
                    ['id' => 'Area', 'text' => 'Area'],
                    ['id' => 'Barge', 'text' => 'Barges'],
                    ['id' => 'Buyer', 'text' => 'Buyers'],
                    ['id' => 'Customer', 'text' => 'Customers'],
                    ['id' => 'Jetty', 'text' => 'Jetties'],
                    ['id' => 'LostTimeCategory', 'text' => 'Lost Time Categories'],
                    ['id' => 'Material', 'text' => 'Material'],
                    ['id' => 'PlanCategory', 'text' => 'Plan Categories'],
                    ['id' => 'ProblemProductivityCategory', 'text' => 'Problem Productivity Categories'],
                    ['id' => 'Seam', 'text' => 'Seam'],
                    ['id' => 'SubArea', 'text' => 'Sub Area'],
                ]
            ], [
                'id' => 'hcgs',
                'text' => 'HCGS',
                'children' => [
                    ['id' => 'Hcgs', 'text' => 'Dashboard'],
                    ['id' => 'Absensi', 'text' => 'Absensi'],
                    ['id' => 'Prajob', 'text' => 'Pra Job & Fatique'],
                    ['id' => 'FatiqueApproval', 'text' => 'Fatique Approval'],
                ]
            ], [
                'id' => 'hcgs>master_data',
                'text' => 'HCGS > Master Data',
                'children' => [
                    ['id' => 'Department', 'text' => 'Departments'],
                    ['id' => 'Employee', 'text' => 'Employees'],
                    ['id' => 'Jabatan', 'text' => 'Jabatan'],
                    ['id' => 'Office', 'text' => 'Offices'],
                    ['id' => 'Position', 'text' => 'Positions'],
                    ['id' => 'StopWorkingPrediction', 'text' => 'Stop Working Prediction'],
                    ['id' => 'SupervisingPrediction', 'text' => 'Supervising Prediction'],
                    ['id' => 'StaffCategory', 'text' => 'Staff Categories'],
                    ['id' => 'TerminalAbsensi', 'text' => 'TerminalAbsensi'],
                ]
            ], [
                'id' => 'she',
                'text' => 'SHE',
                'children' => [
                    ['id' => 'OperatorPerformance', 'text' => 'Operator Performance']
                ]
            ], [
                'id' => 'administration',
                'text' => 'Administration',
                'children' => [
                    ['id' => 'User', 'text' => 'Users'],
                    ['id' => 'Authorization', 'text' => 'Authorization'],
                    ['id' => 'RunningText', 'text' => 'Runnin Text'],
                ]
            ]
        ];
    }
}
