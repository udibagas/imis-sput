<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ArmadaUnitRequest extends FormRequest
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
        $armadaUnit = $this->route('armadaUnit');

        return [
            'name' => [
                'required',
                Rule::unique('armada_units')->ignore($armadaUnit ? $armadaUnit->id : 0)
            ],
            'register' => 'required',
            'armada_id' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'Name',
            'register' => 'Register',
            'armada_id' => 'Armada',
        ];
    }
}
