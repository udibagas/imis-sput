<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FlowMeterRequest extends FormRequest
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
        $flowMeter = $this->route('flowMeter');

        return [
            'date' => 'required',
            'status' => 'required',
            'fuel_tank_id' => 'required',
            'flowmeter_start' => 'required',
            'flowmeter_end' => 'required',
            'sounding_start' => 'required',
            'sounding_end' => 'required',
            'volume_by_sounding' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'date' => 'Date',
            'status' => 'Status',
            'fuel_tank_id' => 'Fuel Tank',
            'flowmeter_start' => 'Flowmeter Start',
            'flowmeter_end' => 'Flowmeter End',
            'sounding_start' => 'Sounding Start',
            'sounding_end' => 'Sounding End',
            'volume_by_sounding' => 'Volume By Sounding',
        ];
    }
}
