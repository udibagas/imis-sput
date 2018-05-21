<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;

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
        // unit id tidak boleh kembar di hari yang sama

        return [
            'unit_id' => [
                'required',
                // function($attribute, $value, $fail) use ($request) {
                //     $sudah = \App\Pitstop::whereRaw("DATE('$request->time_in') = DATE(NOW()) AND unit_id = $value")->pluck('unit_id')->toArray();
                //
                //     if (in_array($value, $sudah)) {
                //         $fail('Unit sudah dicek.');
                //     }
                // }
            ],
            'location_id' => 'required',
            'shift' => 'required',
            'time_in' => 'required',
            'time_out' => [
                'required_if:status,1',
                function($attribute, $value, $fail) {
                    if ($value != '' && strtotime($value) <= strtotime($this->time_in)) {
                        $fail("Time Out mundur.");
                    }

                    if (strtotime($value) > strtotime(now())) {
                        $fail("Time Out di masa depan.");
                    }
                }
            ],
            'description' => 'required_if:status,1',
            'hm' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'description.required_if' => 'Description harus diisi jika Close.',
            'time_out.required_if' => 'Time Out harus diisi jika Close.',
            'unit_id.not_in' => 'Unit sudah dicheck.'
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
