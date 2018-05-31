<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SeamRequest extends FormRequest
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
        $seam = $this->route('seam');

        return [
            'color' => 'required',
            'name' => [
                'required',
                Rule::unique('seams')->ignore($seam ? $seam->id : 0)
            ]
        ];
    }
}
