<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AlocationRequest extends FormRequest
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
        $alocation = $this->route('alocation');

        return [
            'name' => [
                'required',
                Rule::unique('alocations')->ignore($alocation ? $alocation->id : 0)
            ]
        ];
    }
}
