<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BreakdownCategoryRequest extends FormRequest
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
        $breakdownCategory = $this->route('breakdownCategory');

        return [
            'name' => [
                'required',
                Rule::unique('breakdown_categories')
                    ->ignore($breakdownCategory ? $breakdownCategory->id : 0)
            ],
            'description_en' => 'required',
            'description_id' => 'required',
        ];
    }
}
