<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StaffCategoryRequest extends FormRequest
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
        $staffCategory = $this->route('staffCategory');

        return [
            'name' => [
                'required',
                Rule::unique('staff_categories')
                    ->ignore($staffCategory ? $staffCategory->id : 0)
            ]
        ];
    }
}
