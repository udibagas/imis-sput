<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class LostTimeCategoryRequest extends FormRequest
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
        $lostTimeCategory = $this->route('lostTimeCategory');

        return [
            'code' => [
                'required',
                Rule::unique('lost_time_categories')
                    ->ignore($lostTimeCategory ? $lostTimeCategory->id : 0)
            ],
            'description' => 'required',
        ];
    }
}
