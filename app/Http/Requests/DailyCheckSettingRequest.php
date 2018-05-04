<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DailyCheckSettingRequest extends FormRequest
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
        $dailyCheckSetting = $this->route('dailyCheckSetting');

        return [
            'unit_id' => [
                'required',
                Rule::unique('daily_check_settings')->ignore($dailyCheckSetting ? $dailyCheckSetting->id : 0)
            ],
            'day' => 'required'
        ];
    }
}
