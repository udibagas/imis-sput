<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PortActivityRequest extends FormRequest
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
        return [
            'date' => 'required|date',
            'shift' => 'required',
            'unit_id' => 'required',
            'employee_id' => 'required',
            'time_start' => 'required',
            'time_end' => 'required',
            'unit_activity_id' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'date' => 'Date',
            'time_start' => 'Time Start',
            'time_end' => 'Time End',
            'unit_id' => 'Unit',
            'employee_id' => 'Employee',
            'volume' => 'Volume',
            'rit' => 'Bucket',
            'shift' => 'Shift',
            'hopper_id' => 'Hopper',
            'hauler_id' => 'Hauler',
            'material_stock_id' => 'Stock'
        ];
    }
}
