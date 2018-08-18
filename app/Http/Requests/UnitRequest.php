<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UnitRequest extends FormRequest
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
        $unit = $this->route('unit');

        return [
            'name' => [
                'required',
                Rule::unique('units')->ignore($unit ? $unit->id : 0)
            ],
            'egi_id' => 'required',
            'owner_id' => 'required',
            'unit_category_id' => 'required',
        ];
    }
}
