<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StopWorkingPredictionRequest extends FormRequest
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
        $stopWorkingPrediction = $this->route('stopWorkingPrediction');

        return [
            'description' => [
                'required',
                Rule::unique('stop_working_predictions')
                    ->ignore($stopWorkingPrediction ? $stopWorkingPrediction->id : 0)
            ],
            'jam' => 'required'
        ];
    }
}
