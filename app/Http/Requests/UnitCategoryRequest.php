<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UnitCategoryRequest extends FormRequest
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
        $unitCategory = $this->route('unitCategory');

        return [
            'name' => [
                'required',
                Rule::unique('unit_categories')
                    ->ignore($unitCategory ? $unitCategory->id : 0)
            ]
        ];
    }
}
