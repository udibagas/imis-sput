<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ComponentCriteriaRequest extends FormRequest
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
        $componentCriteria = $this->route('componentCriteria');

        return [
            'code' => [
                'required',
                Rule::unique('component_criterias')
                    ->ignore($componentCriteria ? $componentCriteria->id : 0)
            ],
            'description' => 'required',
        ];
    }
}
