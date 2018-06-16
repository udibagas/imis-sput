<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MealRequest extends FormRequest
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
        $meal = $this->route('meal');

        return [
            'date' => 'required|date',
            'employee_id' => 'required',
            'meal_location_id' => 'required',
            'type' => 'required',
            'status' => 'required',
        ];
    }
}
