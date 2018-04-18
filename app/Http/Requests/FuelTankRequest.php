<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FuelTankRequest extends FormRequest
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
        $fuelTank = $this->route('fuelTank');

        return [
            'name' => [
                'required',
                Rule::unique('fuel_tanks')->ignore($fuelTank ? $fuelTank->id : 0)
            ],
            'capacity' => 'required',
        ];
    }
}
