<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SupervisingPredictionRequest extends FormRequest
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
        $supervisingPrediction = $this->route('supervisingPrediction');

        return [
            'description' => [
                'required',
                Rule::unique('supervising_predictions')
                    ->ignore($supervisingPrediction ? $supervisingPrediction->id : 0)
            ],
            'jam' => 'required'
        ];
    }
}
