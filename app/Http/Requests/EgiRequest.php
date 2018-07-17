<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EgiRequest extends FormRequest
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
        $egi = $this->route('egi');

        return [
            'is_utama' => 'required',
            'name' => [
                'required',
                Rule::unique('egis')->ignore($egi ? $egi->id : 0)
            ]
        ];
    }

    public function attributes()
    {
        return [
            'is_utama' => 'Utama'
        ];
    }
}
