<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TerminalAbsensiRequest extends FormRequest
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
        $terminalAbsensi = $this->route('terminalAbsensi');

        return [
            'code' => [
                'required',
                Rule::unique('terminal_absensis')->ignore($terminalAbsensi ? $terminalAbsensi->id : 0)
            ],
            'ip_address' => [
                'required',
                'ip',
                Rule::unique('terminal_absensis')->ignore($terminalAbsensi ? $terminalAbsensi->id : 0)
            ],
            'location_id' => 'required'
        ];
    }

    public function attributes()
    {
        return [
            'ip_address' => 'IP Address',
            'code' => 'Code',
            'location_id' => 'Location'
        ];
    }

    public function messages()
    {
        return [
            'ip_address.ip' => 'IP Address tidak valid'
        ];
    }
}
