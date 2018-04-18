<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BreakdownStatusRequest extends FormRequest
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
        $breakdownStatus = $this->route('breakdownStatus');

        return [
            'code' => [
                'required',
                Rule::unique('breakdown_statuses')
                    ->ignore($breakdownStatus ? $breakdownStatus->id : 0)
            ],
            'description' => 'required',
        ];
    }
}
