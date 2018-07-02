<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UnitActivityRequest extends FormRequest
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
        $unitActivity = $this->route('unitActivity');

        return [
            'name' => [
                'required',
                Rule::unique('unit_activities')->ignore($unitActivity ? $unitActivity->id : 0)
            ]
        ];
    }
}
