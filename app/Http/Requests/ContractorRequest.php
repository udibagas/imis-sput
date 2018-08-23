<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ContractorRequest extends FormRequest
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
        $contractor = $this->route('contractor');

        return [
            'name' => [
                'required',
                Rule::unique('contractors')->ignore($contractor ? $contractor->id : 0)
            ],
            'email' => 'email'
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'Name',
            'address' => 'Address',
            'phone' => 'Phone',
            'fax' => 'Fax',
            'email' => 'Email'
        ];
    }
}
