<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TugboatRequest extends FormRequest
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
        $tugboat = $this->route('tugboat');

        return [
            'name' => [
                'required',
                Rule::unique('tugboats')->ignore($tugboat ? $tugboat->id : 0)
            ]
        ];
    }
}
