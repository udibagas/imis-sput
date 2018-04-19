<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Employee;
use App\Http\Requests\EmployeeRequest;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $pageSize = $request->rowCount > 0 ? $request->rowCount : 1000000;
        $request['page'] = $request->current;
        $sort = $request->sort ? key($request->sort) : 'employees.name';
        $dir = $request->sort ? $request->sort[$sort] : 'asc';

        $employee = Employee::selectRaw('
                        employees.*,
                        departments.name AS department,
                        offices.name AS office,
                        owners.name AS owner,
                        positions.name AS position
                    ')
                    ->join('departments', 'departments.id', '=', 'employees.department_id')
                    ->join('offices', 'offices.id', '=', 'employees.office_id', 'LEFT')
                    ->join('owners', 'owners.id', '=', 'employees.owner_id', 'LEFT')
                    ->join('positions', 'positions.id', '=', 'employees.position_id')
                    ->when($request->searchPhrase, function($query) use ($request) {
                        return $query->where('employees.name', 'LIKE', '%'.$request->searchPhrase.'%')
                                     ->orWhere('employees.nrp', 'LIKE', '%'.$request->searchPhrase.'%')
                                     ->orWhere('departments.name', 'LIKE', '%'.$request->searchPhrase.'%')
                                     ->orWhere('offices.name', 'LIKE', '%'.$request->searchPhrase.'%')
                                     ->orWhere('owners.name', 'LIKE', '%'.$request->searchPhrase.'%')
                                     ->orWhere('positions.name', 'LIKE', '%'.$request->searchPhrase.'%');
                    })->orderBy($sort, $dir)->paginate($pageSize);


        if ($request->ajax()) {
            return [
                'rowCount' => $employee->perPage(),
                'total' => $employee->total(),
                'current' => $employee->currentPage(),
                'rows' => $employee->items(),
            ];
        }

        return view('employee.index', [
            'breadcrumbs' => [
                '#' => 'Employee'
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EmployeeRequest $request)
    {
        return Employee::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Employee $employee)
    {
        return $employee;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EmployeeRequest $request, Employee $employee)
    {
        $employee->update($request->all());
        return $employee;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employee $employee)
    {
        return ['success' => $employee->delete()];
    }
}
