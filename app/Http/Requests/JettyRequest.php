<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class JettyRequest extends FormRequest
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
        $jetty = $this->route('jetty');

        return [
            'order' => 'required|numeric',
            'name' => [
                'required',
                Rule::unique('jetties')->ignore($jetty ? $jetty->id : 0)
            ]
        ];
    }
}
