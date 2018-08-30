<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DraughtSurveyRequest extends FormRequest
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
            'barging_material_id' => 'required',
            'volume' => 'required',
            'pic' => 'required'
        ];
    }

    public function attributes()
    {
        return [
            'barging_id' => 'Barging',
            'barging_material_id' => 'Barging Material',
            'volume' => 'Volume',
            'pic' => 'PIC'
        ];
    }
}
