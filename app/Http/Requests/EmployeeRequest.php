<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EmployeeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $employee = $this->route('employee');

        return [
            'nrp' => [
                'required',
                Rule::unique('employees')->ignore($employee ? $employee->id : 0)
            ],
            'name' => 'required',
            'department_id' => 'required',
            'position_id' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'Name',
            'nrp' => 'NRP',
            'department_id' => 'Department',
            'position_id' => 'Position',
            'office_id' => 'Office',
            'owner_id' => 'Owner'
        ];
    }
}
