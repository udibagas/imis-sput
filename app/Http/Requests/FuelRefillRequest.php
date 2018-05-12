<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FuelRefillRequest extends FormRequest
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
        $fuelRefill = $this->route('fuelRefill');

        return [
            'date' => 'required',
            'unit_id' => 'required',
            'fuel_tank_id' => 'required',
            'employee_id' => 'required',
            'shift' => 'required',
            'total_real' => 'required',
            'km' => 'required',
            'hm' => 'required',
            'start_time' => 'required',
            'finish_time' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'date' => 'Date',
            'unit_id' => 'Unit',
            'fuel_tank_id' => 'Fuel Tank',
            'employee_id' => 'Employee',
            'shift' => 'Shift',
            'total_recommended' => 'Total Recommended',
            'total_real' => 'Total Real',
            'km' => 'KM',
            'hm' => 'HM',
            'km_last' => 'KM Last',
            'hm_last' => 'HM Last',
            'start_time' => 'Start Time',
            'finish_time' => 'Finish Time',
        ];
    }
}
