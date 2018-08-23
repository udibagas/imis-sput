<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BargingRequest extends FormRequest
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
        return [
            'start' => 'required',
            'customer_id' => 'required',
            'tugboat_id' => 'required',
            'jetty_id' => 'required',
            'barge_id' => 'required',
            'buyer_id' => 'required',
            'volume' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'start' => 'Start Time',
            'jetty_id' =>'Jetty',
            'barge_id' => 'Barge',
            'buyer_id' => 'Buyer',
            'volume' => 'Target Barging',
            'customer_id' => 'Customer',
            'tugboat_id' => 'Tugboat',
        ];
    }
}
