<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PitstopRequest extends FormRequest
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
        $pitstop = $this->route('pitstop');

        return [
            'unit_id' => 'required',
            'location_id' => 'required',
            'shift' => 'required',
            'time_in' => 'required',
            'time_out' => 'required_if:status,1',
            'description' => 'required_if:status,1',
            'hm' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'description.required_if' => 'Description harus diisi jika Close',
            'time_out.required_if' => 'Time Out harus diisi jika Close',
        ];
    }

    public function attributes()
    {
        return [
            'unit_id' => 'Unit',
            'location_id' => 'Location',
            'shift' => 'Shift',
            'time_in' => 'Time In',
            'time_out' => 'Time Out',
            'hm' => 'HM',
            'description' => 'Description'
        ];
    }
}
