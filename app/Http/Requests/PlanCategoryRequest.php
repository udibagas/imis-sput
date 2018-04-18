<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PlanCategoryRequest extends FormRequest
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
        $planCategory = $this->route('planCategory');

        return [
            'name' => [
                'required',
                Rule::unique('plan_categories')->ignore($planCategory ? $planCategory->id : 0)
            ]
        ];
    }
}
