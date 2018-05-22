<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;

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
            'km' => ['required', function($attribute, $value, $fail) {
                if ($value <= $this->km_last && $this->km_last > 0) {
                    $fail("KM Now harus lebih besar dari KM Last");
                }
            }],
            'hm' => ['required', function($attribute, $value, $fail) {
                if ($value <= $this->hm_last  && $this->hm_last > 0) {
                    $fail("HM Now harus lebih besar dari HM Last");
                }
            }],
            'start_time' => 'required|date_format:"H:i"',
            'finish_time' => [
                'required',
                'date_format:"H:i"',
                function($attribute, $value, $fail) {
                    if (strtotime($value) <= strtotime($this->start_time)) {
                        $fail("Waktu selesai mundur.");
                    }
                }
            ],
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

    public function messages()
    {
        return [
            'start_time.date_format' => 'Harus dengan format jam:menit (contoh: 13:35)',
            'start_time.date_format' => 'Harus dengan format jam:menit (contoh: 13:38)',
        ];
    }
}
