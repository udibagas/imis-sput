<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class JabatanRequest extends FormRequest
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
        $jabatan = $this->route('jabatan');

        return [
            'name' => [
                'required',
                Rule::unique('jabatans')->ignore($jabatan ? $jabatan->id : 0)
            ]
        ];
    }
}
