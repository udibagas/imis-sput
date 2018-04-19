<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BreakdownRequest extends FormRequest
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
            'unit_id' => 'required',
            'breakdown_category_id' => 'required',
            'location_id' => 'required',
            'hm' => 'required',
            'km' => 'required',
            'time_in' => 'required',
            'diagnosa' => 'required',
        ];
    }
}
