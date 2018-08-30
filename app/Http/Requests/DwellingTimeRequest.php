<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DwellingTimeRequest extends FormRequest
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
            'barging_id' => 'required',
            'jetty_id' => 'required',
            'time' => 'required',
            'status' => 'required',
            'description' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'barging_id' => 'Barging',
            'jetty_id' => 'Jetty',
            'time' => 'Time',
            'status' => 'Status',
            'description' => 'Description'
        ];
    }
}
