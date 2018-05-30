<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MealLocationRequest extends FormRequest
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
        $mealLocation = $this->route('mealLocation');

        return [
            'user_id' => 'required',
            'name' => [
                'required',
                Rule::unique('meal_locations')->ignore($mealLocation ? $mealLocation->id : 0)
            ]
        ];
    }
}
