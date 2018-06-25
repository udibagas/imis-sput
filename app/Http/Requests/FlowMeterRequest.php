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
            'fuel_tank_id' => 'required_without:sadp_id',
            'sadp_id' => 'required_without:fuel_tank_id',
            'flowmeter_start' => 'required',
            'flowmeter_end' => 'required',
            'sounding_start' => 'required',
            'sounding_end' => 'required',
            'volume_by_sounding' => 'required',
            'transfer_to_fuel_tank_id' => 'required_if:status,T',
            'shift' => 'required'
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
            'transfer_to_fuel_tank_id' => 'Transfer To',
            'shift' => 'Shift',
            'sadp_id' => 'SADP'
        ];
    }

    public function messages()
    {
        return [
            'transfer_to_fuel_tank_id.required_if' => 'Harus diisi.',
            'fuel_tank_id.required_without' => 'Isi fuel tank atau SADP',
            'sadp_id.required_without' => 'Isi fuel tank atau sadp'
        ];
    }
}
