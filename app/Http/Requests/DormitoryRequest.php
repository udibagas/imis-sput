<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DormitoryRequest extends FormRequest
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
        $dormitory = $this->route('dormitory');

        return [
            'total_room' => 'required',
            'name' => [
                'required',
                Rule::unique('dormitories')->ignore($dormitory ? $dormitory->id : 0)
            ]
        ];
    }
}
