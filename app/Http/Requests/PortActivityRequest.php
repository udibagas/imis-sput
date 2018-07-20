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
            'time_start' => 'required',
            'time_end' => 'required',
            'unit_id' => 'required',
            'employee_id' => 'required',
            'customer_id' => 'required',
            'material_type' => 'required',
            'volume' => 'required',
            'stock_area_id' => 'required',
        ];
    }
}
