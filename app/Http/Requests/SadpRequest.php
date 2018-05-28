<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SadpRequest extends FormRequest
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
        $sadp = $this->route('sadp');

        return [
            'name' => [
                'required',
                Rule::unique('sadps')->ignore($sadp ? $sadp->id : 0)
            ]
        ];
    }
}
