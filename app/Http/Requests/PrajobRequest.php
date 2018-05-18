<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PrajobRequest extends FormRequest
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
            'employee_id' => 'required', // cutom validation, kalau tanggal ini sudah input ga perlu input lagi
            'tgl' => 'required|date',
            'shift' => 'required',
            'jam_tidur' => 'required|time',
            'jam_tidur_kemarin' => 'required|time',
            'jam_bangun' => 'required|time',
            'jam_bangun_kemarin' => 'required|time',
            'minum_obat' => 'required',
            'ada_masalah' => 'required',
            'siap_bekerja' => 'required',
        ];
    }
}
