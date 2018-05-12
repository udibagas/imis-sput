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
            'total_recommended' => 'required',
            'total_real' => 'required',
            'km' => 'required',
            'hm' => 'required',
            'km_last' => 'required',
            'hm_last' => 'required',
            'start_time' => 'required',
            'finish_time' => 'required',
        ];
    }
}
