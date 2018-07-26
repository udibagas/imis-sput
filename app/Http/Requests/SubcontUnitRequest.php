<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SubcontUnitRequest extends FormRequest
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
        $subcontUnit = $this->route('subcontUnit');

        return [
            'code_number' => [
                'required',
                Rule::unique('subcont_units')->ignore($subcontUnit ? $subcontUnit->id : 0)
            ],
            'type' => 'required',
            'model' => 'required',
            'subcont_id' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'code_number' => 'NamCodee',
            'model' => 'Register',
            'type' => 'Type',
            'subcont_id' => 'Subcont',
        ];
    }
}
