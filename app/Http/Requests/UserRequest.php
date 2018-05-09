<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
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
        $user = $this->route('user');

        $rules = [
            'name' => 'required|max:50',
            'email' => [
                'required', 'email',
                Rule::unique('users')->ignore($user ? $user->id : 0)
            ],
            'password' => 'required|confirmed',
        ];

        // kalau edit password boleh tidak diisi
        if ($user) {
            unset($rules['password']);
        }

        return $rules;
    }

    public function attributes()
    {
        return [
            'name' => 'Name',
            'email' => 'Email',
            'password' => 'Password',
        ];
    }
}
