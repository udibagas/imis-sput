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
                Rule::unique('terminal_absensis')->ignore($terminalAbsensi ? $terminalAbsensi->id : 0)
            ],
            'location_id' => 'required'
        ];
    }
}
