<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Meal;
use App\Employee;
use App\Exports\MealExport;
use App\Http\Requests\MealRequest;
use Excel;
use DB;

class MealController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view', Meal::class);

        if ($request->ajax())
        {
            $sql = "SELECT
                    e.id AS employee_id,
                    e.name AS name,
                    e.nrp AS nrp,
                    departments.name AS department,
                    positions.name AS position,
                    owners.name AS employer,
                    (SELECT meal_location_id
                        FROM meals
                        WHERE
                            employee_id = e.id
                            AND `date` = '{$request->date}'
                            AND type = 'b'
                        LIMIT 1) AS breakfast,
                    (SELECT meal_location_id
                        FROM meals
                        WHERE
                            employee_id = e.id
                            AND `date` = '{$request->date}'
                            AND type = 'l'
                        LIMIT 1) AS lunch,
                    (SELECT meal_location_id
                        FROM meals
                        WHERE
                            employee_id = e.id
                            AND `date` = '{$request->date}'
                            AND type = 'd'
                        LIMIT 1) AS dinner,
                    (SELECT meal_location_id
                        FROM meals
                        WHERE
                            employee_id = e.id
                            AND `date` = '{$request->date}'
                            AND type = 's'
                        LIMIT 1) AS supper,
                    (SELECT status
                        FROM meals
                        WHERE
                            employee_id = e.id
                            AND `date` = '{$request->date}'
                            AND type = 'b'
                        LIMIT 1) AS b_status,
                    (SELECT status
                        FROM meals
                        WHERE
                            employee_id = e.id
                            AND `date` = '{$request->date}'
                            AND type = 'l'
                        LIMIT 1) AS l_status,
                    (SELECT status
                        FROM meals
                        WHERE
                            employee_id = e.id
                            AND `date` = '{$request->date}'
                            AND type = 'd'
                        LIMIT 1) AS d_status,
                    (SELECT status
                        FROM meals
                        WHERE
                            employee_id = e.id
                            AND `date` = '{$request->date}'
                            AND type = 's'
                        LIMIT 1) AS s_status
                FROM employees e
                JOIN departments ON departments.id = e.department_id
                JOIN positions ON positions.id = e.position_id
                LEFT JOIN owners ON owners.id = e.owner_id
                ORDER BY e.name ASC";

            return DB::select(DB::raw($sql));
        }

        return view('meal.index', [
            'breadcrumbs' => [
                'hcgs/dashboard' => 'HCGS',
                'meal' => 'Catering Management'
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', Meal::class);

        $meal = Meal::where('employee_id', $request->employee_id)
            ->where('date', $request->date)
            ->where('type', $request->type)
            ->first();

        if ($meal)
        {
            if (!$request->meal_location_id) {
                return ['status' => $meal->delete()];
            }

            $meal->update($request->all());
            return $meal;
        }

        if (!$request->meal_location_id) {
            return ['status' => true];
        }

        return Meal::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Meal $meal)
    {
        $this->authorize('view', Meal::class);
        return $meal;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Meal $meal)
    {
        $this->authorize('delete', Meal::class);
        return ['success' => $meal->delete()];
    }

    public function export(Request $request)
    {
        $this->authorize('export', Meal::class);
        return Excel::download(new MealExport($request), "meal-{$request->from}-to-{$request->to}.xlsx");
    }

    public function confirm(Request $request)
    {
        $status = Meal::where([
            'date'=> $request->date,
            'employee_id' => $request->employee_id
        ])->update(['status' => 1]);

        return ['status' => $status];
    }

    public function summary(Request $request)
    {
        $date   = $request->date ? $request->date : date("Y-m-d");
        $group  = 'meals.meal_location_id, employees.department_id';
        $select = 'departments.name AS department, meal_locations.name AS location';
        $order  = 'departments.name ASC, meal_locations.name ASC';

        if ($request->group == 'location') {
            $group  = 'meals.meal_location_id';
            $select = 'meal_locations.name AS location';
            $order  = 'meal_locations.name ASC';
        }

        else if ($request->group == 'department') {
            $group  = 'employees.department_id';
            $select = 'departments.name AS department';
            $order  = 'departments.name ASC';
        }

        $sql = "SELECT
                {$select},
                COUNT(IF(meals.type = 'b', 1, NULL)) AS b,
                COUNT(IF(meals.type = 'l', 1, NULL)) AS l,
                COUNT(IF(meals.type = 'd', 1, NULL)) AS d,
                COUNT(IF(meals.type = 's', 1, NULL)) AS s,
                COUNT(meals.id) AS t
            FROM meals
            JOIN employees ON employees.id = meals.employee_id
            JOIN departments ON departments.id = employees.department_id
            JOIN meal_locations ON meal_locations.id = meals.meal_location_id
            WHERE meals.date = '{$date}'
            GROUP BY {$group}
            ORDER BY {$order}
        ";

        return DB::select(DB::raw($sql));
    }
}
