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
            'tindakan' => 'required_if:status,1',
            'time_out' => 'required_if:status,1',
            'component_criteria_id' => 'required_if:status,1',
            'warning_part' => 'required_if:status,1',
            'breakdown_status_id' => 'required_if:status,1',
        ];
    }

    public function messages()
    {
        return [
            'tindakan.required_if' => ':attribute harus diisi jika Close',
            'time_out.required_if' => ':attribute harus diisi jika Close',
            'component_criteria_id.required_if' => ':attribute harus diisi jika Close',
            'warning_part.required_if' => ':attribute harus diisi jika Close',
            'breakdown_status_id.required_if' => ':attribute harus diisi jika Close',
        ];
    }

    public function attributes()
    {
        return [
            'unit_id' => 'Unit',
            'breakdown_status_id' => 'B/D Status',
            'breakdown_category_id' => 'B/D Type',
            'component_criteria_id' => 'Component Criteria',
            'tindakan' => 'Tindakan',
            'time_out' => 'Time Out',
            'location_id' => 'Location',
            'time_in' => 'Time In',
            'diagnosa' => 'Diagnosa',
            'warning_part' => 'Warning Part',
            'hm' => 'HM',
            'km' => 'KM',
        ];
    }
}
