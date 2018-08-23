<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StockDumpingRequest extends FormRequest
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
            'time' => 'required|date_format:"H:i"',
            'subcont_unit_id' => 'required',
            'customer_id' => 'required',
            'contractor_id' => 'required',
            'material_type' => 'required',
            'volume' => 'required',
            'stock_area_id' => 'required',
            'shift' => 'required',
            'register_number' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'date' => 'Date',
            'time' => 'Time',
            'subcont_unit_id' => 'Unit',
            'customer_id' => 'Customer',
            'material_type' => 'Material Type',
            'volume' => 'Volume',
            'stock_area_id' => 'Stock Area',
            'shift' => 'Shift',
            'register_number' => 'Register Number',
            'contractor_id' => 'Contractor'
        ];
    }
}
